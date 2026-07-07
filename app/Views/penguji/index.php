<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <!-- Header Info -->
        <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white border rounded shadow-sm">
            <div>
                <h4 class="mb-0 fw-bold text-success"><i class="bi bi-person-badge-fill"></i> Portal Dosen Penguji PMB</h4>
                <small class="text-muted">Masuk sebagai: <strong><?= session()->get('nama'); ?></strong> (NIP: <?= session()->get('username'); ?>)</small>
            </div>
            <div>
                <a href="/logout" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
        </div>

        <!-- Flash messages -->
        <?php if(session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> <?= session()->getFlashdata('pesan'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('pesan_error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> <?= session()->getFlashdata('pesan_error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- MATA UJIAN YANG DIUJI -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-success text-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-file-earmark-text-fill"></i> Materi Ujian Seleksi Anda</h5>
            </div>
            <div class="card-body bg-white">
                <div class="row">
                    <?php if(!empty($mata_uji)) : foreach($mata_uji as $mu) : ?>
                        <div class="col-md-6 mb-2">
                            <div class="p-3 border rounded shadow-sm bg-light">
                                <h6 class="fw-bold mb-1 text-success"><?= $mu['nama_ujian']; ?></h6>
                                <small class="text-muted">Materi Uji ID: <?= $mu['id']; ?></small>
                            </div>
                        </div>
                    <?php endforeach; else : ?>
                        <div class="col-12"><div class="alert alert-warning mb-0">Anda belum ditugaskan untuk menguji materi seleksi apa pun. Silakan hubungi panitia PMB.</div></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- DAFTAR CALON MAHASISWA & INPUT NILAI -->
        <?php if(!empty($mata_uji)) : ?>
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-star-fill text-warning"></i> Penilaian Ujian Masuk Calon Mahasiswa</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>No. Daftar</th>
                                    <th>Nama Calon Mahasiswa</th>
                                    <th>Asal Sekolah</th>
                                    <th>Prodi Pilihan</th>
                                    <?php foreach($mata_uji as $mu) : ?>
                                        <th class="text-center"><?= $mu['nama_ujian']; ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($calon as $c) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><code class="fw-bold"><?= $c['nomor_pendaftaran']; ?></code></td>
                                    <td class="fw-bold text-dark"><?= $c['nama']; ?></td>
                                    <td><?= $c['asal_sekolah']; ?></td>
                                    <td><span class="badge bg-secondary"><?= $c['nama_prodi']; ?></span></td>
                                    <?php foreach($mata_uji as $mu) : ?>
                                        <td class="text-center">
                                            <span class="fw-bold fs-5 d-block text-primary"><?= $c['nilai'][$mu['id']]; ?></span>
                                            <a href="/penguji/nilai/edit/<?= $c['id']; ?>/<?= $mu['id']; ?>" class="btn btn-outline-success btn-xs py-0 px-2 mt-1" style="font-size: 11px;">
                                                <i class="bi bi-pencil-fill"></i> Input/Edit Nilai
                                            </a>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
