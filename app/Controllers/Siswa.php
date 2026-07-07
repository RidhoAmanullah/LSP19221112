<?php
namespace App\Controllers;
use App\Models\SiswaModel;
use App\Models\MatapelajaranModel;
use App\Models\NilaiModel;

class Siswa extends BaseController
{
    protected $siswaModel;
    protected $mapelModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->mapelModel = new MatapelajaranModel();
    }

    private function checkAuth()
    {
        if (session()->get('role') !== 'siswa') {
            throw new \CodeIgniter\Router\Exceptions\RedirectException('/login');
        }
    }

    public function index()
    {
        $this->checkAuth();
        $id = session()->get('id');

        $siswa = $this->siswaModel->find($id);
        
        $db = \Config\Database::connect();
        $subjects = $this->mapelModel->select('matapelajaran.*, guru.nama as nama_guru')
                                      ->join('guru', 'guru.id = matapelajaran.guru_id', 'left')
                                      ->findAll();

        $grades = $db->table('nilai')->where('siswa_id', $id)->get()->getResultArray();
        
        $nilaiMap = [];
        foreach ($grades as $g) {
            $nilaiMap[$g['mapel_id']] = $g['nilai'];
        }

        $myGrades = [];
        foreach ($subjects as $sub) {
            $myGrades[] = [
                'nama_mapel' => $sub['nama_mapel'],
                'nama_guru'  => $sub['nama_guru'] ?? 'Belum ada guru',
                'nilai'      => $nilaiMap[$sub['id']] ?? 0
            ];
        }

        $data = [
            'title'    => 'Dashboard Siswa - Bimbel Online',
            'siswa'    => $siswa,
            'myGrades' => $myGrades
        ];

        return view('siswa/index', $data);
    }

    public function profil()
    {
        $this->checkAuth();
        $id = session()->get('id');

        $data = [
            'title' => 'Edit Profil Saya',
            'siswa' => $this->siswaModel->find($id)
        ];
        return view('siswa/profil', $data);
    }

    public function updateProfil()
    {
        $this->checkAuth();
        $id = session()->get('id');

        $dataUpdate = [
            'id'            => $id,
            'nama'          => $this->request->getVar('nama'),
            'kelas'         => $this->request->getVar('kelas'),
            'email'         => $this->request->getVar('email'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir')
        ];

        $passwordInput = $this->request->getVar('password');
        if (!empty($passwordInput)) {
            $dataUpdate['password'] = password_hash($passwordInput, PASSWORD_DEFAULT);
        }

        $this->siswaModel->save($dataUpdate);
        
        session()->set('nama', $dataUpdate['nama']);

        return redirect()->to('/siswa')->with('pesan', 'Profil Anda berhasil diperbarui.');
    }
}
