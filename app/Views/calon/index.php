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
                <h4 class="mb-0 fw-bold text-primary"><i class="bi bi-person-fill"></i> Portal Calon Mahasiswa</h4>
                <small class="text-muted">No. Pendaftaran: <strong><?= session()->get('username'); ?></strong> | Pendaftar: <strong><?= session()->get('nama'); ?></strong></small>
            </div>
            <div>
                <a href="/calon/profil" class="btn btn-warning btn-sm me-1"><i class="bi bi-gear-fill"></i> Edit Profil</a>
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

        <!-- STATUS KELULUSAN / SELEKSI -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4 text-center">
                <h5 class="fw-bold mb-3 text-secondary">STATUS SELEKSI PENERIMAAN</h5>
                <?php if ($calon['status_seleksi'] === 'lulus') : ?>
                    <div class="alert alert-success py-4 mb-0" role="alert">
                        <i class="bi bi-check-circle-fill fs-1 d-block mb-2 text-success"></i>
                        <h4 class="alert-heading fw-bold">SELAMAT! ANDA DINYATAKAN LULUS SELEKSI</h4>
                        <p class="mb-0 fs-5 mt-2">Selamat bergabung sebagai mahasiswa baru di **STKIP Singkawang** pada program studi **<?= $calon['nama_prodi']; ?>**.</p>
                        <small class="text-muted d-block mt-3">Silakan lakukan pendaftaran ulang di loket sekretariat PMB kampus.</small>
                    </div>
                <?php elseif ($calon['status_seleksi'] === 'tidak lulus') : ?>
                    <div class="alert alert-danger py-4 mb-0" role="alert">
                        <i class="bi bi-x-circle-fill fs-1 d-block mb-2 text-danger"></i>
                        <h4 class="alert-heading fw-bold">MOHON MAAF, ANDA BELUM LULUS SELEKSI</h4>
                        <p class="mb-0 fs-5 mt-2">Anda dinyatakan belum memenuhi kriteria kelulusan penerimaan mahasiswa baru STKIP Singkawang tahun akademik ini.</p>
                        <small class="text-muted d-block mt-3">Terima kasih telah berpartisipasi dalam proses seleksi penerimaan kami.</small>
                    </div>
                <?php else : ?>
                    <div class="alert alert-warning py-4 mb-0" role="alert">
                        <i class="bi bi-hourglass-split fs-1 d-block mb-2 text-warning"></i>
                        <h4 class="alert-heading fw-bold">DATA SEDANG DALAM PROSES SELEKSI</h4>
                        <p class="mb-0 fs-5 mt-2">Berkas dan nilai hasil ujian masuk Anda sedang ditinjau oleh panitia PMB.</p>
                        <small class="text-muted d-block mt-3">Hasil kelulusan akan diumumkan secara berkala pada portal pendaftaran ini.</small>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <!-- PROFIL PENDAFTARAN -->
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-info-circle-fill"></i> Data Diri Calon Mahasiswa</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless align-middle mb-0">
                            <tr>
                                <th style="width: 140px;">No. Daftar</th>
                                <td class="text-dark fw-bold">: <code><?= $calon['nomor_pendaftaran']; ?></code></td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>: <?= $calon['nama']; ?></td>
                            </tr>
                            <tr>
                                <th>Sekolah Asal</th>
                                <td>: <?= $calon['asal_sekolah']; ?></td>
                            </tr>
                            <tr>
                                <th>Pilihan Prodi</th>
                                <td>: <span class="badge bg-secondary"><?= $calon['nama_prodi']; ?></span></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>: <?= $calon['email']; ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>: <?= $calon['tanggal_lahir']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TABEL NILAI SELEKSI -->
            <div class="col-md-7 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-award-fill text-warning"></i> Hasil Nilai Ujian Masuk Anda</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Materi Seleksi / Ujian</th>
                                        <th class="text-center" style="width: 120px;">Nilai Anda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach($myGrades as $mg) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td class="fw-bold text-dark"><?= $mg['nama_ujian']; ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-primary fs-6"><?= $mg['nilai']; ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; if(empty($myGrades)) : ?>
                                        <tr><td colspan="3" class="text-center text-muted">Belum ada nilai ujian masuk yang diinput.</td></tr>
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
