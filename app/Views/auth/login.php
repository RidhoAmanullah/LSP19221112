<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Bimbel Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm mt-5">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0 fw-bold">BIMBEL ONLINE</h4>
                        <small>Pusat Belajar Siswa & Manajemen Nilai</small>
                    </div>
                    <div class="card-body p-4">
                        <?php if(session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(session()->getFlashdata('success')) : ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success'); ?>
                            </div>
                        <?php endif; ?>

                        <form action="/login/process" method="post">
                            <?= csrf_field(); ?>
                            
                            <div class="mb-3">
                                <label for="role" class="form-label">Login Sebagai</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="siswa">Siswa</option>
                                    <option value="guru">Guru (Pengajar)</option>
                                    <option value="admin">Admin (Pengelola)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label" id="usernameLabel">NIS / Nomor Induk Siswa</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Nomor Induk" required autofocus>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
                                <div class="form-text text-muted" id="passwordHelp">
                                    *Password default siswa adalah tanggal lahir Anda (format: YYYY-MM-DD, contoh: 2010-10-10).
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 py-2 mb-3">Masuk Sistem</button>
                            
                            <div class="text-center" id="registerHelp">
                                Siswa belum punya akun? <a href="/register" class="text-decoration-none">Daftar Akun Baru</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const roleSelect = document.getElementById('role');
        const usernameLabel = document.getElementById('usernameLabel');
        const passwordHelp = document.getElementById('passwordHelp');
        const registerHelp = document.getElementById('registerHelp');
        const usernameInput = document.getElementById('username');
        
        roleSelect.addEventListener('change', function() {
            if (this.value === 'siswa') {
                usernameLabel.textContent = 'NIS / Nomor Induk Siswa';
                usernameInput.placeholder = 'Contoh: 20260001';
                passwordHelp.style.display = 'block';
                passwordHelp.textContent = '*Password default siswa adalah tanggal lahir Anda (format: YYYY-MM-DD, contoh: 2010-10-10).';
                registerHelp.style.display = 'block';
            } else if (this.value === 'guru') {
                usernameLabel.textContent = 'NIP / Nomor Induk Pegawai';
                usernameInput.placeholder = 'Contoh: 19800101';
                passwordHelp.style.display = 'block';
                passwordHelp.textContent = '*Password default guru: guru123';
                registerHelp.style.display = 'none';
            } else {
                usernameLabel.textContent = 'Username Admin';
                usernameInput.placeholder = 'Masukkan username admin';
                passwordHelp.style.display = 'none';
                registerHelp.style.display = 'none';
            }
        });

        // Trigger change event to set correct initial state
        roleSelect.dispatchEvent(new Event('change'));
    </script>
</body>
</html>
