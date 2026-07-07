<?php
namespace App\Controllers;
use App\Models\CalonModel;
use App\Models\ProdiModel;
use App\Models\NilaiModel;

class Calon extends BaseController
{
    protected $calonModel;
    protected $prodiModel;

    public function __construct()
    {
        $this->calonModel = new CalonModel();
        $this->prodiModel = new ProdiModel();
    }

    private function checkAuth()
    {
        if (session()->get('role') !== 'calon') {
            throw new \CodeIgniter\Router\Exceptions\RedirectException('/login');
        }
    }

    public function index()
    {
        $this->checkAuth();
        $id = session()->get('id');

        $calon = $this->calonModel->select('calon_mahasiswa.*, program_studi.nama_prodi')
                                  ->join('program_studi', 'program_studi.id = calon_mahasiswa.prodi_id', 'left')
                                  ->where('calon_mahasiswa.id', $id)
                                  ->first();
        
        $db = \Config\Database::connect();
        $subjects = $db->table('mata_uji')->get()->getResultArray();
        
        $grades = $db->table('nilai_seleksi')->where('calon_id', $id)->get()->getResultArray();
        
        $nilaiMap = [];
        foreach ($grades as $g) {
            $nilaiMap[$g['mata_uji_id']] = $g['nilai'];
        }

        $myGrades = [];
        foreach ($subjects as $sub) {
            $myGrades[] = [
                'nama_ujian' => $sub['nama_ujian'],
                'nilai'      => $nilaiMap[$sub['id']] ?? 0
            ];
        }

        $data = [
            'title'    => 'Dashboard Calon Mahasiswa - PMB STKIP Singkawang',
            'calon'    => $calon,
            'myGrades' => $myGrades
        ];

        return view('calon/index', $data);
    }

    public function profil()
    {
        $this->checkAuth();
        $id = session()->get('id');

        $data = [
            'title' => 'Edit Profil Pendaftaran Saya',
            'calon' => $this->calonModel->find($id),
            'prodi' => $this->prodiModel->findAll()
        ];
        return view('calon/profil', $data);
    }

    public function updateProfil()
    {
        $this->checkAuth();
        $id = session()->get('id');

        $dataUpdate = [
            'id'            => $id,
            'nama'          => $this->request->getVar('nama'),
            'asal_sekolah'  => $this->request->getVar('asal_sekolah'),
            'email'         => $this->request->getVar('email'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'prodi_id'      => $this->request->getVar('prodi_id')
        ];

        $passwordInput = $this->request->getVar('password');
        if (!empty($passwordInput)) {
            $dataUpdate['password'] = password_hash($passwordInput, PASSWORD_DEFAULT);
        }

        $this->calonModel->save($dataUpdate);
        
        session()->set('nama', $dataUpdate['nama']);

        return redirect()->to('/calon')->with('pesan', 'Profil pendaftaran Anda berhasil diperbarui.');
    }
}
