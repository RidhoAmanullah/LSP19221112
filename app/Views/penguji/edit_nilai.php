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
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white py-3 rounded-top">
                        <h5 class="mb-0 fw-bold">Input / Edit Nilai Ujian Seleksi</h5>
                    </div>
                    <div class="card-body p-4 bg-white rounded-bottom">
                        <form action="/penguji/nilai/update/<?= $calon['id']; ?>/<?= $mata_uji['id']; ?>" method="post">
                            <?= csrf_field(); ?>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">Calon Mahasiswa</label>
                                <input type="text" class="form-control bg-light" value="<?= $calon['nama']; ?>" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">Nomor Pendaftaran / Asal Sekolah</label>
                                <input type="text" class="form-control bg-light" value="<?= $calon['nomor_pendaftaran']; ?> / Asal: <?= $calon['asal_sekolah']; ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Mata Uji Seleksi</label>
                                <input type="text" class="form-control bg-light" value="<?= $mata_uji['nama_ujian']; ?>" readonly>
                            </div>
                            
                            <div class="mb-4">
                                <label for="nilai" class="form-label fw-bold">Nilai Hasil Ujian (0 - 100)</label>
                                <input type="number" class="form-control form-control-lg text-center fw-bold text-primary border-primary" id="nilai" name="nilai" min="0" max="100" value="<?= $nilai; ?>" required autofocus>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="/penguji" class="btn btn-secondary">Batal / Kembali</a>
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
