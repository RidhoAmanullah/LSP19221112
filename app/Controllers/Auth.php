<?php
namespace App\Controllers;
use App\Models\UserModel;
use App\Models\CalonModel;
use App\Models\PengujiModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            return $this->redirectDashboard();
        }
        return view('auth/login');
    }

    public function loginProcess()
    {
        $session = session();
        $role = $this->request->getVar('role');
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        
        if ($role === 'admin') {
            $model = new UserModel();
            $data = $model->where('username', $username)->first();
            
            if ($data) {
                $pass = $data['password'];
                $verify_pass = password_verify($password, $pass) || $password === $pass;
                
                if ($verify_pass) {
                    $ses_data = [
                        'id'        => $data['id'],
                        'username'  => $data['username'],
                        'role'      => 'admin',
                        'logged_in' => TRUE
                    ];
                    $session->set($ses_data);
                    return redirect()->to('/admin');
                } else {
                    $session->setFlashdata('error', 'Password Admin Salah');
                    return redirect()->to('/login');
                }
            } else {
                $session->setFlashdata('error', 'Username Admin tidak ditemukan');
                return redirect()->to('/login');
            }
        } 
        elseif ($role === 'penguji') {
            $model = new PengujiModel();
            $data = $model->where('nip', $username)->first();
            
            if ($data) {
                $verify_pass = password_verify($password, $data['password']) || $password === $data['password'];
                
                if ($verify_pass) {
                    $ses_data = [
                        'id'        => $data['id'],
                        'username'  => $data['nip'],
                        'nama'      => $data['nama'],
                        'role'      => 'penguji',
                        'logged_in' => TRUE
                    ];
                    $session->set($ses_data);
                    return redirect()->to('/penguji');
                } else {
                    $session->setFlashdata('error', 'Password Penguji Salah');
                    return redirect()->to('/login');
                }
            } else {
                $session->setFlashdata('error', 'NIP Penguji tidak ditemukan');
                return redirect()->to('/login');
            }
        } 
        else {
            // Calon Mahasiswa
            $model = new CalonModel();
            $data = $model->where('nomor_pendaftaran', $username)->first();
            
            if ($data) {
                $verify_pass = password_verify($password, $data['password']) 
                            || $password === $data['password'] 
                            || $password === $data['tanggal_lahir'] 
                            || $password === $data['nomor_pendaftaran'];
                
                if ($verify_pass) {
                    $ses_data = [
                        'id'        => $data['id'],
                        'username'  => $data['nomor_pendaftaran'],
                        'nama'      => $data['nama'],
                        'role'      => 'calon',
                        'logged_in' => TRUE
                    ];
                    $session->set($ses_data);
                    return redirect()->to('/calon');
                } else {
                    $session->setFlashdata('error', 'Password Salah (Default: tanggal lahir YYYY-MM-DD)');
                    return redirect()->to('/login');
                }
            } else {
                $session->setFlashdata('error', 'Nomor Pendaftaran tidak ditemukan');
                return redirect()->to('/login');
            }
        }
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            return $this->redirectDashboard();
        }
        
        $db = \Config\Database::connect();
        $prodi = $db->table('program_studi')->get()->getResultArray();
        
        return view('auth/register', ['prodi' => $prodi]);
    }

    public function registerProcess()
    {
        $session = session();
        $nama = $this->request->getVar('nama');
        $email = $this->request->getVar('email');
        $tanggal_lahir = $this->request->getVar('tanggal_lahir');
        $asal_sekolah = $this->request->getVar('asal_sekolah');
        $prodi_id = $this->request->getVar('prodi_id');
        $passwordInput = $this->request->getVar('password');

        $model = new CalonModel();
        
        // Generate nomor pendaftaran otomatis
        $db = \Config\Database::connect();
        $lastRow = $model->orderBy('id', 'DESC')->first();
        $nextId = $lastRow ? $lastRow['id'] + 1 : 1;
        $nomor_pendaftaran = 'PMB2026' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $password = !empty($passwordInput) ? password_hash($passwordInput, PASSWORD_DEFAULT) : password_hash($tanggal_lahir, PASSWORD_DEFAULT);

        $model->save([
            'nomor_pendaftaran' => $nomor_pendaftaran,
            'nama'              => $nama,
            'email'             => $email,
            'tanggal_lahir'     => $tanggal_lahir,
            'asal_sekolah'      => $asal_sekolah,
            'prodi_id'          => $prodi_id,
            'status_seleksi'    => 'pending',
            'password'          => $password
        ]);

        $calonId = $model->insertID();

        // Inisialisasi nilai untuk semua mata seleksi default
        $subjects = $db->table('mata_uji')->get()->getResultArray();
        foreach ($subjects as $sub) {
            $db->table('nilai_seleksi')->insert([
                'calon_id'     => $calonId,
                'mata_uji_id'  => $sub['id'],
                'nilai'        => 0
            ]);
        }

        $session->setFlashdata('success', 'Pendaftaran berhasil! Nomor Pendaftaran Anda: ' . $nomor_pendaftaran . '. Password default Anda adalah tanggal lahir (' . $tanggal_lahir . '). Silakan login.');
        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    private function redirectDashboard()
    {
        $role = session()->get('role');
        if ($role === 'admin') {
            return redirect()->to('/admin');
        } elseif ($role === 'penguji') {
            return redirect()->to('/penguji');
        } else {
            return redirect()->to('/calon');
        }
    }
}
