<?php
namespace App\Controllers;
use App\Models\CalonModel;
use App\Models\PengujiModel;
use App\Models\MataUjiModel;
use App\Models\NilaiModel;

class Penguji extends BaseController
{
    protected $calonModel;
    protected $pengujiModel;
    protected $mataUjiModel;
    protected $nilaiModel;

    public function __construct()
    {
        $this->calonModel = new CalonModel();
        $this->pengujiModel = new PengujiModel();
        $this->mataUjiModel = new MataUjiModel();
        $this->nilaiModel = new NilaiModel();
    }

    private function checkAuth()
    {
        if (session()->get('role') !== 'penguji') {
            throw new \CodeIgniter\Router\Exceptions\RedirectException('/login');
        }
    }

    public function index()
    {
        $this->checkAuth();
        $pengujiId = session()->get('id');

        // Cari mata uji yang diuji oleh penguji ini
        $db = \Config\Database::connect();
        $myMataUji = $this->mataUjiModel->where('penguji_id', $pengujiId)->findAll();
        
        $myMataUjiIds = array_column($myMataUji, 'id');

        $calon = [];
        if (!empty($myMataUjiIds)) {
            // Ambil semua calon mahasiswa
            $calon = $this->calonModel->select('calon_mahasiswa.*, program_studi.nama_prodi')
                                      ->join('program_studi', 'program_studi.id = calon_mahasiswa.prodi_id', 'left')
                                      ->findAll();

            // Ambil nilai untuk mata uji yang diuji oleh penguji ini
            $grades = $db->table('nilai_seleksi')
                           ->whereIn('mata_uji_id', $myMataUjiIds)
                           ->get()
                           ->getResultArray();

            // Petakan nilai berdasarkan calon_id dan mata_uji_id
            $nilaiMap = [];
            foreach ($grades as $g) {
                $nilaiMap[$g['calon_id']][$g['mata_uji_id']] = $g['nilai'];
            }

            foreach ($calon as &$c) {
                $c['nilai'] = [];
                foreach ($myMataUji as $m) {
                    $c['nilai'][$m['id']] = $nilaiMap[$c['id']][$m['id']] ?? 0;
                }
            }
        }

        $data = [
            'title'     => 'Dashboard Penguji PMB - STKIP Singkawang',
            'mata_uji'  => $myMataUji,
            'calon'     => $calon
        ];

        return view('penguji/index', $data);
    }

    public function editNilai($calonId, $mataUjiId)
    {
        $this->checkAuth();
        $pengujiId = session()->get('id');

        // Pastikan penguji ini memang menguji mata uji tersebut
        $mataUji = $this->mataUjiModel->where('id', $mataUjiId)->where('penguji_id', $pengujiId)->first();
        if (!$mataUji) {
            return redirect()->to('/penguji')->with('pesan_error', 'Akses ditolak: Anda tidak menguji mata uji ini.');
        }

        $calon = $this->calonModel->find($calonId);
        if (!$calon) {
            return redirect()->to('/penguji')->with('pesan_error', 'Calon mahasiswa tidak ditemukan.');
        }

        $db = \Config\Database::connect();
        $existing = $db->table('nilai_seleksi')
                       ->where('calon_id', $calonId)
                       ->where('mata_uji_id', $mataUjiId)
                       ->get()
                       ->getRowArray();

        $data = [
            'title'     => 'Input / Edit Nilai Ujian Calon Mahasiswa',
            'calon'     => $calon,
            'mata_uji'  => $mataUji,
            'nilai'     => $existing ? $existing['nilai'] : 0
        ];

        return view('penguji/edit_nilai', $data);
    }

    public function updateNilai($calonId, $mataUjiId)
    {
        $this->checkAuth();
        $pengujiId = session()->get('id');

        // Pastikan penguji ini memang menguji mata uji tersebut
        $mataUji = $this->mataUjiModel->where('id', $mataUjiId)->where('penguji_id', $pengujiId)->first();
        if (!$mataUji) {
            return redirect()->to('/penguji')->with('pesan_error', 'Akses ditolak: Anda tidak menguji mata uji ini.');
        }

        $nilaiVal = $this->request->getVar('nilai');

        $db = \Config\Database::connect();
        $existing = $db->table('nilai_seleksi')
                       ->where('calon_id', $calonId)
                       ->where('mata_uji_id', $mataUjiId)
                       ->get()
                       ->getRowArray();

        if ($existing) {
            $db->table('nilai_seleksi')
               ->where('id', $existing['id'])
               ->update(['nilai' => $nilaiVal]);
        } else {
            $db->table('nilai_seleksi')->insert([
                'calon_id'    => $calonId,
                'mata_uji_id' => $mataUjiId,
                'nilai'       => $nilaiVal
            ]);
        }

        return redirect()->to('/penguji')->with('pesan', 'Nilai seleksi calon mahasiswa berhasil diperbarui.');
    }
}
