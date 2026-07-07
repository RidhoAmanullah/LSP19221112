<?php
namespace App\Controllers;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\MatapelajaranModel;
use App\Models\NilaiModel;

class Admin extends BaseController
{
    protected $siswaModel;
    protected $guruModel;
    protected $mapelModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->guruModel = new GuruModel();
        $this->mapelModel = new MatapelajaranModel();
    }

    private function checkAuth()
    {
        if (session()->get('role') !== 'admin') {
            throw new \CodeIgniter\Router\Exceptions\RedirectException('/login');
        }
    }

    public function index()
    {
        $this->checkAuth();

        $data = [
            'title'     => 'Dashboard Admin - Bimbel Online',
            'siswa'     => $this->siswaModel->findAll(),
            'guru'      => $this->guruModel->findAll(),
            'mapel'     => $this->mapelModel->select('matapelajaran.*, guru.nama as nama_guru')
                                            ->join('guru', 'guru.id = matapelajaran.guru_id', 'left')
                                            ->findAll()
        ];
        return view('admin/index', $data);
    }

    // ==========================================
    // CRUD SISWA
    // ==========================================
    public function siswaCreate()
    {
        $this->checkAuth();
        $data = ['title' => 'Tambah Siswa'];
        return view('admin/siswa_create', $data);
    }

    public function siswaStore()
    {
        $this->checkAuth();
        
        $nis = $this->request->getVar('nis');
        $nama = $this->request->getVar('nama');
        $kelas = $this->request->getVar('kelas');
        $email = $this->request->getVar('email');
        $tanggal_lahir = $this->request->getVar('tanggal_lahir');
        $passwordInput = $this->request->getVar('password');

        $password = !empty($passwordInput) ? password_hash($passwordInput, PASSWORD_DEFAULT) : password_hash($tanggal_lahir, PASSWORD_DEFAULT);

        $this->siswaModel->save([
            'nis'           => $nis,
            'nama'          => $nama,
            'kelas'         => $kelas,
            'email'         => $email,
            'tanggal_lahir' => $tanggal_lahir,
            'password'      => $password
        ]);

        $siswaId = $this->siswaModel->insertID();

        // Inisialisasi nilai mapel default
        $db = \Config\Database::connect();
        $subjects = $this->mapelModel->findAll();
        foreach ($subjects as $sub) {
            $db->table('nilai')->insert([
                'siswa_id'  => $siswaId,
                'mapel_id' => $sub['id'],
                'nilai'    => 0
            ]);
        }

        return redirect()->to('/admin')->with('pesan', 'Siswa berhasil ditambahkan.');
    }

    public function siswaEdit($id)
    {
        $this->checkAuth();
        $data = [
            'title' => 'Edit Siswa',
            'siswa' => $this->siswaModel->find($id)
        ];
        return view('admin/siswa_edit', $data);
    }

    public function siswaUpdate($id)
    {
        $this->checkAuth();
        
        $dataUpdate = [
            'id'            => $id,
            'nis'           => $this->request->getVar('nis'),
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
        return redirect()->to('/admin')->with('pesan', 'Data siswa berhasil diubah.');
    }

    public function siswaDelete($id)
    {
        $this->checkAuth();
        $this->siswaModel->delete($id);
        return redirect()->to('/admin')->with('pesan', 'Siswa berhasil dihapus.');
    }

    // ==========================================
    // CRUD GURU
    // ==========================================
    public function guruCreate()
    {
        $this->checkAuth();
        $data = ['title' => 'Tambah Guru'];
        return view('admin/guru_create', $data);
    }

    public function guruStore()
    {
        $this->checkAuth();
        
        $nip = $this->request->getVar('nip');
        $nama = $this->request->getVar('nama');
        $email = $this->request->getVar('email');
        $passwordInput = $this->request->getVar('password');

        $password = !empty($passwordInput) ? password_hash($passwordInput, PASSWORD_DEFAULT) : password_hash('guru123', PASSWORD_DEFAULT);

        $this->guruModel->save([
            'nip'      => $nip,
            'nama'     => $nama,
            'email'    => $email,
            'password' => $password
        ]);

        return redirect()->to('/admin')->with('pesan', 'Guru berhasil ditambahkan.');
    }

    public function guruEdit($id)
    {
        $this->checkAuth();
        $data = [
            'title' => 'Edit Guru',
            'guru'  => $this->guruModel->find($id)
        ];
        return view('admin/guru_edit', $data);
    }

    public function guruUpdate($id)
    {
        $this->checkAuth();

        $dataUpdate = [
            'id'    => $id,
            'nip'   => $this->request->getVar('nip'),
            'nama'  => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email')
        ];

        $passwordInput = $this->request->getVar('password');
        if (!empty($passwordInput)) {
            $dataUpdate['password'] = password_hash($passwordInput, PASSWORD_DEFAULT);
        }

        $this->guruModel->save($dataUpdate);
        return redirect()->to('/admin')->with('pesan', 'Data guru berhasil diubah.');
    }

    public function guruDelete($id)
    {
        $this->checkAuth();
        $this->guruModel->delete($id);
        return redirect()->to('/admin')->with('pesan', 'Guru berhasil dihapus.');
    }

    // ==========================================
    // CRUD MATA PELAJARAN
    // ==========================================
    public function mapelCreate()
    {
        $this->checkAuth();
        $data = [
            'title' => 'Tambah Mata Pelajaran',
            'guru'  => $this->guruModel->findAll()
        ];
        return view('admin/mapel_create', $data);
    }

    public function mapelStore()
    {
        $this->checkAuth();
        
        $this->mapelModel->save([
            'nama_mapel' => $this->request->getVar('nama_mapel'),
            'guru_id'    => $this->request->getVar('guru_id')
        ]);

        $mapelId = $this->mapelModel->insertID();

        // Inisialisasi nilai siswa default untuk mapel baru ini
        $db = \Config\Database::connect();
        $students = $this->siswaModel->findAll();
        foreach ($students as $siswa) {
            $db->table('nilai')->insert([
                'siswa_id'  => $siswa['id'],
                'mapel_id' => $mapelId,
                'nilai'    => 0
            ]);
        }

        return redirect()->to('/admin')->with('pesan', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function mapelEdit($id)
    {
        $this->checkAuth();
        $data = [
            'title' => 'Edit Mata Pelajaran',
            'mapel' => $this->mapelModel->find($id),
            'guru'  => $this->guruModel->findAll()
        ];
        return view('admin/mapel_edit', $data);
    }

    public function mapelUpdate($id)
    {
        $this->checkAuth();

        $this->mapelModel->save([
            'id'         => $id,
            'nama_mapel' => $this->request->getVar('nama_mapel'),
            'guru_id'    => $this->request->getVar('guru_id')
        ]);

        return redirect()->to('/admin')->with('pesan', 'Mata pelajaran berhasil diubah.');
    }

    public function mapelDelete($id)
    {
        $this->checkAuth();
        $this->mapelModel->delete($id);
        return redirect()->to('/admin')->with('pesan', 'Mata pelajaran berhasil dihapus.');
    }
}
