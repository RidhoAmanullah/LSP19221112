<?php
namespace App\Controllers;
use App\Models\CalonModel;
use App\Models\PengujiModel;
use App\Models\ProdiModel;
use App\Models\NilaiModel;

class Admin extends BaseController
{
    protected $calonModel;
    protected $pengujiModel;
    protected $prodiModel;

    public function __construct()
    {
        $this->calonModel = new CalonModel();
        $this->pengujiModel = new PengujiModel();
        $this->prodiModel = new ProdiModel();
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
            'title'     => 'Dashboard Panitia PMB - STKIP Singkawang',
            'calon'     => $this->calonModel->select('calon_mahasiswa.*, program_studi.nama_prodi')
                                            ->join('program_studi', 'program_studi.id = calon_mahasiswa.prodi_id', 'left')
                                            ->findAll(),
            'penguji'   => $this->pengujiModel->findAll(),
            'prodi'     => $this->prodiModel->findAll()
        ];
        return view('admin/index', $data);
    }

    // ==========================================
    // CRUD CALON MAHASISWA
    // ==========================================
    public function calonCreate()
    {
        $this->checkAuth();
        $data = [
            'title' => 'Tambah Calon Mahasiswa',
            'prodi' => $this->prodiModel->findAll()
        ];
        return view('admin/calon_create', $data);
    }

    public function calonStore()
    {
        $this->checkAuth();
        
        $nama = $this->request->getVar('nama');
        $email = $this->request->getVar('email');
        $tanggal_lahir = $this->request->getVar('tanggal_lahir');
        $asal_sekolah = $this->request->getVar('asal_sekolah');
        $prodi_id = $this->request->getVar('prodi_id');
        $status_seleksi = $this->request->getVar('status_seleksi') ?? 'pending';
        $passwordInput = $this->request->getVar('password');

        // Generate nomor pendaftaran otomatis
        $lastRow = $this->calonModel->orderBy('id', 'DESC')->first();
        $nextId = $lastRow ? $lastRow['id'] + 1 : 1;
        $nomor_pendaftaran = 'PMB2026' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $password = !empty($passwordInput) ? password_hash($passwordInput, PASSWORD_DEFAULT) : password_hash($tanggal_lahir, PASSWORD_DEFAULT);

        $this->calonModel->save([
            'nomor_pendaftaran' => $nomor_pendaftaran,
            'nama'              => $nama,
            'email'             => $email,
            'tanggal_lahir'     => $tanggal_lahir,
            'asal_sekolah'      => $asal_sekolah,
            'prodi_id'          => $prodi_id,
            'status_seleksi'    => $status_seleksi,
            'password'          => $password
        ]);

        $calonId = $this->calonModel->insertID();

        // Inisialisasi nilai mapel default
        $db = \Config\Database::connect();
        $subjects = $db->table('mata_uji')->get()->getResultArray();
        foreach ($subjects as $sub) {
            $db->table('nilai_seleksi')->insert([
                'calon_id'     => $calonId,
                'mata_uji_id'  => $sub['id'],
                'nilai'        => 0
            ]);
        }

        return redirect()->to('/admin')->with('pesan', 'Calon mahasiswa berhasil ditambahkan.');
    }

    public function calonEdit($id)
    {
        $this->checkAuth();
        $data = [
            'title' => 'Edit Calon Mahasiswa',
            'calon' => $this->calonModel->find($id),
            'prodi' => $this->prodiModel->findAll()
        ];
        return view('admin/calon_edit', $data);
    }

    public function calonUpdate($id)
    {
        $this->checkAuth();
        
        $dataUpdate = [
            'id'             => $id,
            'nomor_pendaftaran'=> $this->request->getVar('nomor_pendaftaran'),
            'nama'           => $this->request->getVar('nama'),
            'email'          => $this->request->getVar('email'),
            'tanggal_lahir'  => $this->request->getVar('tanggal_lahir'),
            'asal_sekolah'   => $this->request->getVar('asal_sekolah'),
            'prodi_id'       => $this->request->getVar('prodi_id'),
            'status_seleksi' => $this->request->getVar('status_seleksi')
        ];

        $passwordInput = $this->request->getVar('password');
        if (!empty($passwordInput)) {
            $dataUpdate['password'] = password_hash($passwordInput, PASSWORD_DEFAULT);
        }

        $this->calonModel->save($dataUpdate);
        return redirect()->to('/admin')->with('pesan', 'Data calon mahasiswa berhasil diubah.');
    }

    public function calonDelete($id)
    {
        $this->checkAuth();
        $this->calonModel->delete($id);
        return redirect()->to('/admin')->with('pesan', 'Calon mahasiswa berhasil dihapus.');
    }

    // ==========================================
    // CRUD PENGUJI
    // ==========================================
    public function pengujiCreate()
    {
        $this->checkAuth();
        $data = ['title' => 'Tambah Dosen Penguji'];
        return view('admin/penguji_create', $data);
    }

    public function pengujiStore()
    {
        $this->checkAuth();
        
        $nip = $this->request->getVar('nip');
        $nama = $this->request->getVar('nama');
        $email = $this->request->getVar('email');
        $passwordInput = $this->request->getVar('password');

        $password = !empty($passwordInput) ? password_hash($passwordInput, PASSWORD_DEFAULT) : password_hash('penguji123', PASSWORD_DEFAULT);

        $this->pengujiModel->save([
            'nip'      => $nip,
            'nama'     => $nama,
            'email'    => $email,
            'password' => $password
        ]);

        return redirect()->to('/admin')->with('pesan', 'Dosen penguji berhasil ditambahkan.');
    }

    public function pengujiEdit($id)
    {
        $this->checkAuth();
        $data = [
            'title'   => 'Edit Dosen Penguji',
            'penguji' => $this->pengujiModel->find($id)
        ];
        return view('admin/penguji_edit', $data);
    }

    public function pengujiUpdate($id)
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

        $this->pengujiModel->save($dataUpdate);
        return redirect()->to('/admin')->with('pesan', 'Data dosen penguji berhasil diubah.');
    }

    public function pengujiDelete($id)
    {
        $this->checkAuth();
        $this->pengujiModel->delete($id);
        return redirect()->to('/admin')->with('pesan', 'Dosen penguji berhasil dihapus.');
    }

    // ==========================================
    // CRUD PROGRAM STUDI
    // ==========================================
    public function prodiCreate()
    {
        $this->checkAuth();
        $data = ['title' => 'Tambah Program Studi'];
        return view('admin/prodi_create', $data);
    }

    public function prodiStore()
    {
        $this->checkAuth();
        
        $this->prodiModel->save([
            'nama_prodi' => $this->request->getVar('nama_prodi'),
            'jenjang'    => $this->request->getVar('jenjang') ?? 'S1'
        ]);

        return redirect()->to('/admin')->with('pesan', 'Program studi berhasil ditambahkan.');
    }

    public function prodiEdit($id)
    {
        $this->checkAuth();
        $data = [
            'title' => 'Edit Program Studi',
            'prodi' => $this->prodiModel->find($id)
        ];
        return view('admin/prodi_edit', $data);
    }

    public function prodiUpdate($id)
    {
        $this->checkAuth();

        $this->prodiModel->save([
            'id'         => $id,
            'nama_prodi' => $this->request->getVar('nama_prodi'),
            'jenjang'    => $this->request->getVar('jenjang')
        ]);

        return redirect()->to('/admin')->with('pesan', 'Program studi berhasil diubah.');
    }

    public function prodiDelete($id)
    {
        $this->checkAuth();
        $this->prodiModel->delete($id);
        return redirect()->to('/admin')->with('pesan', 'Program studi berhasil dihapus.');
    }
}
