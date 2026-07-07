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
                <h4 class="mb-0 fw-bold text-primary"><i class="bi bi-shield-lock-fill"></i> Panitia PMB STKIP Singkawang</h4>
                <small class="text-muted">Masuk sebagai: <strong><?= session()->get('username'); ?></strong> (Administrator)</small>
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

        <!-- NAV TABS -->
        <ul class="nav nav-pills mb-3 shadow-sm bg-white p-2 rounded" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-calon-tab" data-bs-toggle="pill" data-bs-target="#pills-calon" type="button" role="tab"><i class="bi bi-people-fill"></i> Pendaftar Calon Mahasiswa</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-penguji-tab" data-bs-toggle="pill" data-bs-target="#pills-penguji" type="button" role="tab"><i class="bi bi-person-badge-fill"></i> Dosen Penguji / Pewawancara</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-prodi-tab" data-bs-toggle="pill" data-bs-target="#pills-prodi" type="button" role="tab"><i class="bi bi-mortarboard-fill"></i> Program Studi</button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <!-- TAB CALON MAHASISWA -->
            <div class="tab-pane fade show active" id="pills-calon" role="tabpanel">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title fw-bold text-dark mb-0">Daftar Pendaftar PMB</h5>
                            <a href="/admin/calon/create" class="btn btn-primary btn-sm"><i class="bi bi-person-plus-fill"></i> Tambah Calon Mahasiswa</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>No. Daftar</th>
                                        <th>Nama Lengkap</th>
                                        <th>Asal Sekolah</th>
                                        <th>Prodi Pilihan</th>
                                        <th>Status Kelulusan</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
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
                                        <td>
                                            <?php if ($c['status_seleksi'] === 'lulus') : ?>
                                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Lulus</span>
                                            <?php elseif ($c['status_seleksi'] === 'tidak lulus') : ?>
                                                <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Tidak Lulus</span>
                                            <?php else : ?>
                                                <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Seleksi</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="/admin/calon/edit/<?= $c['id']; ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil-square"></i></a>
                                            <form action="/admin/calon/delete/<?= $c['id']; ?>" method="post" class="d-inline">
                                                <?= csrf_field(); ?>
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data calon mahasiswa ini?');"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; if(empty($calon)) : ?>
                                        <tr><td colspan="7" class="text-center text-muted">Belum ada data pendaftar.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB GURU / DOSEN PENGUJI -->
            <div class="tab-pane fade" id="pills-penguji" role="tabpanel">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title fw-bold text-dark mb-0">Daftar Dosen Penguji</h5>
                            <a href="/admin/penguji/create" class="btn btn-primary btn-sm"><i class="bi bi-person-plus-fill"></i> Tambah Penguji</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>NIP</th>
                                        <th>Nama Dosen Penguji</th>
                                        <th>Email</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach($penguji as $p) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $p['nip']; ?></td>
                                        <td class="fw-bold text-dark"><?= $p['nama']; ?></td>
                                        <td><?= $p['email']; ?></td>
                                        <td class="text-center">
                                            <a href="/admin/penguji/edit/<?= $p['id']; ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil-square"></i></a>
                                            <form action="/admin/penguji/delete/<?= $p['id']; ?>" method="post" class="d-inline">
                                                <?= csrf_field(); ?>
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data penguji ini?');"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; if(empty($penguji)) : ?>
                                        <tr><td colspan="5" class="text-center text-muted">Belum ada data penguji.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB PROGRAM STUDI -->
            <div class="tab-pane fade" id="pills-prodi" role="tabpanel">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title fw-bold text-dark mb-0">Daftar Program Studi STKIP</h5>
                            <a href="/admin/prodi/create" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle-fill"></i> Tambah Prodi</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Nama Program Studi</th>
                                        <th>Jenjang</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach($prodi as $pr) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td class="fw-bold text-dark"><?= $pr['nama_prodi']; ?></td>
                                        <td><span class="badge bg-info text-dark"><?= $pr['jenjang']; ?></span></td>
                                        <td class="text-center">
                                            <a href="/admin/prodi/edit/<?= $pr['id']; ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil-square"></i></a>
                                            <form action="/admin/prodi/delete/<?= $pr['id']; ?>" method="post" class="d-inline">
                                                <?= csrf_field(); ?>
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus prodi ini?');"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; if(empty($prodi)) : ?>
                                        <tr><td colspan="4" class="text-center text-muted">Belum ada data prodi.</td></tr>
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
