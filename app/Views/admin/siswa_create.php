<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-bold">Tambah Data Siswa</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="/admin/siswa/store" method="post">
                            <?= csrf_field(); ?>
                            
                            <div class="mb-3">
                                <label for="nis" class="form-label">NIS (Nomor Induk Siswa)</label>
                                <input type="text" class="form-control" id="nis" name="nis" required placeholder="Contoh: 20260002">
                            </div>
                            
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" required placeholder="Masukkan Nama Lengkap">
                            </div>
                            
                            <div class="mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" class="form-control" id="kelas" name="kelas" required placeholder="Contoh: 11-SMA">
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="Contoh: siswa@gmail.com">
                            </div>
                            
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                                <div class="form-text text-muted">Tanggal lahir akan menjadi password default siswa.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Kustom (Opsional)</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan untuk memakai tanggal lahir">
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="/admin" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Siswa</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
