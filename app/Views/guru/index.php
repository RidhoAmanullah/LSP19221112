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
                <h4 class="mb-0 fw-bold text-success"><i class="bi bi-person-workspace"></i> Portal Guru Pengajar</h4>
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

        <!-- MATA PELAJARAN YANG DIAJAR -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-success text-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-book"></i> Mata Pelajaran yang Anda Ajar</h5>
            </div>
            <div class="card-body bg-white">
                <div class="row">
                    <?php if(!empty($mapel)) : foreach($mapel as $m) : ?>
                        <div class="col-md-4 mb-2">
                            <div class="p-3 border rounded shadow-sm bg-light">
                                <h6 class="fw-bold mb-1 text-success"><?= $m['nama_mapel']; ?></h6>
                                <small class="text-muted">ID Pelajaran: <?= $m['id']; ?></small>
                            </div>
                        </div>
                    <?php endforeach; else : ?>
                        <div class="col-12"><div class="alert alert-warning mb-0">Anda belum ditugaskan untuk mengajar mata pelajaran apa pun. Silakan hubungi admin.</div></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- MANAJEMEN NILAI SISWA -->
        <?php if(!empty($mapel)) : ?>
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-star-fill text-warning"></i> Input & Edit Nilai Siswa</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <?php foreach($mapel as $m) : ?>
                                        <th class="text-center"><?= $m['nama_mapel']; ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($siswa as $s) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $s['nis']; ?></td>
                                    <td class="fw-bold text-dark"><?= $s['nama']; ?></td>
                                    <td><span class="badge bg-secondary"><?= $s['kelas']; ?></span></td>
                                    <?php foreach($mapel as $m) : ?>
                                        <td class="text-center">
                                            <span class="fw-bold fs-5 d-block text-primary"><?= $s['nilai'][$m['id']]; ?></span>
                                            <a href="/guru/nilai/edit/<?= $s['id']; ?>/<?= $m['id']; ?>" class="btn btn-outline-success btn-xs py-0 px-2 mt-1" style="font-size: 11px;">
                                                <i class="bi bi-pencil-fill"></i> Edit Nilai
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
