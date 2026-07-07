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
                    <div class="card-header bg-warning text-dark py-3">
                        <h5 class="mb-0 fw-bold">Edit Profil Saya</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="/siswa/profil/update" method="post">
                            <?= csrf_field(); ?>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">NIS (Tidak bisa diubah)</label>
                                <input type="text" class="form-control bg-light" value="<?= $siswa['nis']; ?>" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $siswa['nama']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" class="form-control" id="kelas" name="kelas" value="<?= $siswa['kelas']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $siswa['email']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $siswa['tanggal_lahir']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru (Opsional)</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="/siswa" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-warning">Perbarui Profil</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
