<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Siswa Baru - Bimbel Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-success text-white py-3 text-center">
                        <h4 class="mb-0 fw-bold">Pendaftaran Siswa Baru</h4>
                        <small>Silakan isi data untuk bergabung dengan Bimbel Online</small>
                    </div>
                    <div class="card-body p-4">
                        <?php if(session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <form action="/register/process" method="post">
                            <?= csrf_field(); ?>
                            
                            <div class="mb-3">
                                <label for="nis" class="form-label">NIS (Nomor Induk Siswa)</label>
                                <input type="text" class="form-control" id="nis" name="nis" required autofocus placeholder="Contoh: 20260001">
                            </div>
                            
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" required placeholder="Masukkan Nama Lengkap Siswa">
                            </div>
                            
                            <div class="mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" class="form-control" id="kelas" name="kelas" required placeholder="Contoh: 10-SMA, 9-SMP, dll">
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="Contoh: dani@siswa.com">
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                                <div class="form-text text-muted">Tanggal lahir ini akan menjadi password default Anda (format: YYYY-MM-DD).</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Kustom (Opsional)</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika ingin memakai tanggal lahir sebagai password">
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100 py-2 mb-3">Daftar Sekarang</button>
                            
                            <div class="text-center">
                                Sudah punya akun? <a href="/login" class="text-decoration-none">Login di sini</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
