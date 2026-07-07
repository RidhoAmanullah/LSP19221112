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
                        <h5 class="mb-0 fw-bold">Edit Profil Pendaftaran Saya</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="/calon/profil/update" method="post">
                            <?= csrf_field(); ?>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">Nomor Pendaftaran (Tidak bisa diubah)</label>
                                <input type="text" class="form-control bg-light" value="<?= $calon['nomor_pendaftaran']; ?>" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $calon['nama']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="asal_sekolah" class="form-label">Asal Sekolah (SMA/SMK/MA)</label>
                                <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" value="<?= $calon['asal_sekolah']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $calon['email']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $calon['tanggal_lahir']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="prodi_id" class="form-label">Pilihan Program Studi</label>
                                <select class="form-select" id="prodi_id" name="prodi_id" required>
                                    <?php foreach ($prodi as $pr) : ?>
                                        <option value="<?= $pr['id']; ?>" <?= ($pr['id'] == $calon['prodi_id']) ? 'selected' : ''; ?>>
                                            <?= $pr['jenjang']; ?> <?= $pr['nama_prodi']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru (Opsional)</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="/calon" class="btn btn-secondary">Kembali</a>
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
