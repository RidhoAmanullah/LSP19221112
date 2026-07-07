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
                <h4 class="mb-0 fw-bold text-primary"><i class="bi bi-person-fill"></i> Portal Siswa Bimbel</h4>
                <small class="text-muted">Masuk sebagai: <strong><?= session()->get('nama'); ?></strong> (NIS: <?= session()->get('username'); ?>)</small>
            </div>
            <div>
                <a href="/siswa/profil" class="btn btn-warning btn-sm me-1"><i class="bi bi-gear-fill"></i> Edit Profil</a>
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

        <!-- PROFILE DATA & ACADEMIC GRADES -->
        <div class="row">
            <!-- PROFILE CARD -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-info-circle-fill"></i> Profil Belajar</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless align-middle mb-0">
                            <tr>
                                <th style="width: 120px;">NIS</th>
                                <td class="text-dark fw-bold">: <?= $siswa['nis']; ?></td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>: <?= $siswa['nama']; ?></td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td>: <span class="badge bg-secondary"><?= $siswa['kelas']; ?></span></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>: <?= $siswa['email']; ?></td>
                            </tr>
                            <tr>
                                <th>Lahir</th>
                                <td>: <?= $siswa['tanggal_lahir']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- GRADES TABLE CARD -->
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-star-fill text-warning"></i> Transkrip Nilai Bimbel Anda</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Guru Pengajar</th>
                                        <th class="text-center" style="width: 120px;">Nilai Anda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach($myGrades as $mg) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td class="fw-bold text-dark"><?= $mg['nama_mapel']; ?></td>
                                        <td class="text-muted"><?= $mg['nama_guru']; ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-primary fs-6"><?= $mg['nilai']; ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; if(empty($myGrades)) : ?>
                                        <tr><td colspan="4" class="text-center text-muted">Belum ada mata pelajaran terdaftar.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
