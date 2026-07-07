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
                    <div class="card-header bg-success text-white py-3">
                        <h5 class="mb-0 fw-bold">Input / Edit Nilai Belajar</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="/guru/nilai/update/<?= $siswa['id']; ?>/<?= $mapel['id']; ?>" method="post">
                            <?= csrf_field(); ?>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">Nama Siswa</label>
                                <input type="text" class="form-control bg-light" value="<?= $siswa['nama']; ?>" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">NIS / Kelas</label>
                                <input type="text" class="form-control bg-light" value="<?= $siswa['nis']; ?> / Kelas: <?= $siswa['kelas']; ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Mata Pelajaran</label>
                                <input type="text" class="form-control bg-light" value="<?= $mapel['nama_mapel']; ?>" readonly>
                            </div>
                            
                            <div class="mb-4">
                                <label for="nilai" class="form-label fw-bold">Nilai Siswa (0 - 100)</label>
                                <input type="number" class="form-control form-control-lg text-center fw-bold text-primary" id="nilai" name="nilai" min="0" max="100" value="<?= $nilai; ?>" required autofocus>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="/guru" class="btn btn-secondary">Batal / Kembali</a>
                                <button type="submit" class="btn btn-success px-4">Simpan Nilai</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
