<?php
namespace App\Controllers;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\MatapelajaranModel;
use App\Models\NilaiModel;

class Guru extends BaseController
{
    protected $siswaModel;
    protected $guruModel;
    protected $mapelModel;
    protected $nilaiModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->guruModel = new GuruModel();
        $this->mapelModel = new MatapelajaranModel();
        $this->nilaiModel = new NilaiModel();
    }

    private function checkAuth()
    {
        if (session()->get('role') !== 'guru') {
            throw new \CodeIgniter\Router\Exceptions\RedirectException('/login');
        }
    }

    public function index()
    {
        $this->checkAuth();
        $guruId = session()->get('id');

        // Cari mapel yang diajar oleh guru ini
        $db = \Config\Database::connect();
        $myMapel = $this->mapelModel->where('guru_id', $guruId)->findAll();
        
        $myMapelIds = array_column($myMapel, 'id');

        $siswa = [];
        if (!empty($myMapelIds)) {
            // Ambil semua siswa
            $siswa = $this->siswaModel->findAll();

            // Ambil nilai untuk mapel yang diajar oleh guru ini
            $grades = $db->table('nilai')
                           ->whereIn('mapel_id', $myMapelIds)
                           ->get()
                           ->getResultArray();

            // Petakan nilai berdasarkan siswa_id dan mapel_id
            $nilaiMap = [];
            foreach ($grades as $g) {
                $nilaiMap[$g['siswa_id']][$g['mapel_id']] = $g['nilai'];
            }

            foreach ($siswa as &$s) {
                $s['nilai'] = [];
                foreach ($myMapel as $m) {
                    $s['nilai'][$m['id']] = $nilaiMap[$s['id']][$m['id']] ?? 0;
                }
            }
        }

        $data = [
            'title'   => 'Dashboard Guru - Bimbel Online',
            'mapel'   => $myMapel,
            'siswa'   => $siswa
        ];

        return view('guru/index', $data);
    }

    public function editNilai($siswaId, $mapelId)
    {
        $this->checkAuth();
        $guruId = session()->get('id');

        // Pastikan guru ini memang mengajar mapel tersebut
        $mapel = $this->mapelModel->where('id', $mapelId)->where('guru_id', $guruId)->first();
        if (!$mapel) {
            return redirect()->to('/guru')->with('pesan_error', 'Akses ditolak: Anda tidak mengajar mata pelajaran ini.');
        }

        $siswa = $this->siswaModel->find($siswaId);
        if (!$siswa) {
            return redirect()->to('/guru')->with('pesan_error', 'Siswa tidak ditemukan.');
        }

        $db = \Config\Database::connect();
        $existing = $db->table('nilai')
                       ->where('siswa_id', $siswaId)
                       ->where('mapel_id', $mapelId)
                       ->get()
                       ->getRowArray();

        $data = [
            'title'  => 'Input / Edit Nilai Siswa',
            'siswa'  => $siswa,
            'mapel'  => $mapel,
            'nilai'  => $existing ? $existing['nilai'] : 0
        ];

        return view('guru/edit_nilai', $data);
    }

    public function updateNilai($siswaId, $mapelId)
    {
        $this->checkAuth();
        $guruId = session()->get('id');

        // Pastikan guru ini memang mengajar mapel tersebut
        $mapel = $this->mapelModel->where('id', $mapelId)->where('guru_id', $guruId)->first();
        if (!$mapel) {
            return redirect()->to('/guru')->with('pesan_error', 'Akses ditolak: Anda tidak mengajar mata pelajaran ini.');
        }

        $nilaiVal = $this->request->getVar('nilai');

        $db = \Config\Database::connect();
        $existing = $db->table('nilai')
                       ->where('siswa_id', $siswaId)
                       ->where('mapel_id', $mapelId)
                       ->get()
                       ->getRowArray();

        if ($existing) {
            $db->table('nilai')
               ->where('id', $existing['id'])
               ->update(['nilai' => $nilaiVal]);
        } else {
            $db->table('nilai')->insert([
                'siswa_id' => $siswaId,
                'mapel_id' => $mapelId,
                'nilai'    => $nilaiVal
            ]);
        }

        return redirect()->to('/guru')->with('pesan', 'Nilai siswa berhasil diperbarui.');
    }
}
