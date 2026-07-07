<?php
namespace App\Controllers;
use App\Models\UserModel;
use App\Models\SiswaModel;
use App\Models\GuruModel;

class Auth extends BaseController
{
    public function login()
    {
        // Jika sudah login, arahkan ke dashboard masing-masing
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
        elseif ($role === 'guru') {
            $model = new GuruModel();
            $data = $model->where('nip', $username)->first();
            
            if ($data) {
                $verify_pass = password_verify($password, $data['password']) || $password === $data['password'];
                
                if ($verify_pass) {
                    $ses_data = [
                        'id'        => $data['id'],
                        'username'  => $data['nip'],
                        'nama'      => $data['nama'],
                        'role'      => 'guru',
                        'logged_in' => TRUE
                    ];
                    $session->set($ses_data);
                    return redirect()->to('/guru');
                } else {
                    $session->setFlashdata('error', 'Password Guru Salah');
                    return redirect()->to('/login');
                }
            } else {
                $session->setFlashdata('error', 'NIP Guru tidak ditemukan');
                return redirect()->to('/login');
            }
        } 
        else {
            // Siswa
            $model = new SiswaModel();
            $data = $model->where('nis', $username)->first();
            
            if ($data) {
                $verify_pass = password_verify($password, $data['password']) 
                            || $password === $data['password'] 
                            || $password === $data['tanggal_lahir'] 
                            || $password === $data['nis'];
                
                if ($verify_pass) {
                    $ses_data = [
                        'id'        => $data['id'],
                        'username'  => $data['nis'],
                        'nama'      => $data['nama'],
                        'role'      => 'siswa',
                        'logged_in' => TRUE
                    ];
                    $session->set($ses_data);
                    return redirect()->to('/siswa');
                } else {
                    $session->setFlashdata('error', 'Password Siswa Salah (Default: tanggal lahir YYYY-MM-DD)');
                    return redirect()->to('/login');
                }
            } else {
                $session->setFlashdata('error', 'NIS Siswa tidak ditemukan');
                return redirect()->to('/login');
            }
        }
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            return $this->redirectDashboard();
        }
        return view('auth/register');
    }

    public function registerProcess()
    {
        $session = session();
        $nis = $this->request->getVar('nis');
        $nama = $this->request->getVar('nama');
        $kelas = $this->request->getVar('kelas');
        $email = $this->request->getVar('email');
        $tanggal_lahir = $this->request->getVar('tanggal_lahir');
        $passwordInput = $this->request->getVar('password');

        $model = new SiswaModel();
        
        $existing = $model->where('nis', $nis)->first();
        if ($existing) {
            $session->setFlashdata('error', 'NIS sudah terdaftar.');
            return redirect()->to('/register');
        }

        $password = !empty($passwordInput) ? password_hash($passwordInput, PASSWORD_DEFAULT) : password_hash($tanggal_lahir, PASSWORD_DEFAULT);

        $model->save([
            'nis'           => $nis,
            'nama'          => $nama,
            'kelas'         => $kelas,
            'email'         => $email,
            'tanggal_lahir' => $tanggal_lahir,
            'password'      => $password
        ]);

        $siswaId = $model->insertID();

        // Inisialisasi nilai untuk semua mata pelajaran (default = 0)
        $db = \Config\Database::connect();
        $subjects = $db->table('matapelajaran')->get()->getResultArray();
        foreach ($subjects as $sub) {
            $db->table('nilai')->insert([
                'siswa_id'  => $siswaId,
                'mapel_id' => $sub['id'],
                'nilai'    => 0
            ]);
        }

        $session->setFlashdata('success', 'Pendaftaran Siswa berhasil! Password default Anda adalah tanggal lahir (' . $tanggal_lahir . '). Silakan login.');
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
        } elseif ($role === 'guru') {
            return redirect()->to('/guru');
        } else {
            return redirect()->to('/siswa');
        }
    }
}
