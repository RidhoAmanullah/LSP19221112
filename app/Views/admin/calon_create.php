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
                        <h5 class="mb-0 fw-bold">Tambah Calon Mahasiswa (Manual)</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="/admin/calon/store" method="post">
                            <?= csrf_field(); ?>
                            
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" required placeholder="Masukkan Nama Lengkap">
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="Contoh: calon@gmail.com">
                            </div>
                            
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                                <div class="form-text text-muted">Tanggal lahir akan menjadi password default calon mahasiswa.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="asal_sekolah" class="form-label">Asal Sekolah (SMA/SMK/MA)</label>
                                <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" required placeholder="Contoh: SMAN 2 Singkawang">
                            </div>

                            <div class="mb-3">
                                <label for="prodi_id" class="form-label">Program Studi</label>
                                <select class="form-select" id="prodi_id" name="prodi_id" required>
                                    <option value="" disabled selected>-- Pilih Prodi --</option>
                                    <?php foreach ($prodi as $pr) : ?>
                                        <option value="<?= $pr['id']; ?>"><?= $pr['jenjang']; ?> <?= $pr['nama_prodi']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="status_seleksi" class="form-label">Status Seleksi</label>
                                <select class="form-select" id="status_seleksi" name="status_seleksi" required>
                                    <option value="pending">Pending / Proses Seleksi</option>
                                    <option value="lulus">Lulus Seleksi</option>
                                    <option value="tidak lulus">Tidak Lulus Seleksi</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Kustom (Opsional)</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan untuk memakai tanggal lahir">
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="/admin" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Calon Mahasiswa</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
