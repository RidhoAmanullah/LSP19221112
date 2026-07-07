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
                <h4 class="mb-0 fw-bold text-primary"><i class="bi bi-shield-lock-fill"></i> Panel Administrator</h4>
                <small class="text-muted">Masuk sebagai: <strong><?= session()->get('username'); ?></strong> (Admin)</small>
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

        <!-- NAV TABS FOR EASY NAVIGATION -->
        <ul class="nav nav-pills mb-3 shadow-sm bg-white p-2 rounded" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-siswa-tab" data-bs-toggle="pill" data-bs-target="#pills-siswa" type="button" role="tab"><i class="bi bi-people-fill"></i> Data Siswa</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-guru-tab" data-bs-toggle="pill" data-bs-target="#pills-guru" type="button" role="tab"><i class="bi bi-person-workspace"></i> Data Guru</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-mapel-tab" data-bs-toggle="pill" data-bs-target="#pills-mapel" type="button" role="tab"><i class="bi bi-book-half"></i> Mata Pelajaran</button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <!-- TAB SISWA -->
            <div class="tab-pane fade show active" id="pills-siswa" role="tabpanel">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title fw-bold text-dark mb-0">Daftar Siswa Bimbel</h5>
                            <a href="/admin/siswa/create" class="btn btn-primary btn-sm"><i class="bi bi-person-plus-fill"></i> Tambah Siswa</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Email</th>
                                        <th>Tanggal Lahir</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach($siswa as $s) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $s['nis']; ?></td>
                                        <td class="fw-bold"><?= $s['nama']; ?></td>
                                        <td><span class="badge bg-secondary"><?= $s['kelas']; ?></span></td>
                                        <td><?= $s['email']; ?></td>
                                        <td><?= $s['tanggal_lahir']; ?></td>
                                        <td class="text-center">
                                            <a href="/admin/siswa/edit/<?= $s['id']; ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil-square"></i></a>
                                            <form action="/admin/siswa/delete/<?= $s['id']; ?>" method="post" class="d-inline">
                                                <?= csrf_field(); ?>
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini? Semua data nilai siswa juga akan dihapus.');"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; if(empty($siswa)) : ?>
                                        <tr><td colspan="7" class="text-center text-muted">Belum ada data siswa.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB GURU -->
            <div class="tab-pane fade" id="pills-guru" role="tabpanel">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title fw-bold text-dark mb-0">Daftar Guru Pengajar</h5>
                            <a href="/admin/guru/create" class="btn btn-primary btn-sm"><i class="bi bi-person-plus-fill"></i> Tambah Guru</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>NIP</th>
                                        <th>Nama Guru</th>
                                        <th>Email</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach($guru as $g) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $g['nip']; ?></td>
                                        <td class="fw-bold"><?= $g['nama']; ?></td>
                                        <td><?= $g['email']; ?></td>
                                        <td class="text-center">
                                            <a href="/admin/guru/edit/<?= $g['id']; ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil-square"></i></a>
                                            <form action="/admin/guru/delete/<?= $g['id']; ?>" method="post" class="d-inline">
                                                <?= csrf_field(); ?>
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus guru ini?');"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; if(empty($guru)) : ?>
                                        <tr><td colspan="5" class="text-center text-muted">Belum ada data guru.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB MAPEL -->
            <div class="tab-pane fade" id="pills-mapel" role="tabpanel">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title fw-bold text-dark mb-0">Daftar Mata Pelajaran</h5>
                            <a href="/admin/mapel/create" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle-fill"></i> Tambah Mapel</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Nama Mata Pelajaran</th>
                                        <th>Guru Pengajar</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach($mapel as $m) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td class="fw-bold"><?= $m['nama_mapel']; ?></td>
                                        <td><?= $m['nama_guru'] ?? '<span class="text-danger">Belum ditunjuk</span>'; ?></td>
                                        <td class="text-center">
                                            <a href="/admin/mapel/edit/<?= $m['id']; ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil-square"></i></a>
                                            <form action="/admin/mapel/delete/<?= $m['id']; ?>" method="post" class="d-inline">
                                                <?= csrf_field(); ?>
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus mapel ini?');"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; if(empty($mapel)) : ?>
                                        <tr><td colspan="4" class="text-center text-muted">Belum ada data mata pelajaran.</td></tr>
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
