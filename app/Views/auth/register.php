<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Calon Mahasiswa - STKIP Singkawang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white py-3 text-center rounded-top">
                        <h4 class="mb-0 fw-bold">Pendaftaran Siswa Baru (PMB)</h4>
                        <small>Formulir Online Calon Mahasiswa STKIP Singkawang</small>
                    </div>
                    <div class="card-body p-4 bg-white rounded-bottom">
                        <?php if(session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <form action="/register/process" method="post">
                            <?= csrf_field(); ?>
                            
                            <div class="mb-3">
                                <label for="nama" class="form-label fw-bold">Nama Lengkap Anda</label>
                                <input type="text" class="form-control" id="nama" name="nama" required placeholder="Masukkan nama lengkap sesuai ijazah">
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Alamat Email</label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="Contoh: rian@gmail.com">
                            </div>
                            
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                                <div class="form-text text-muted">Tanggal lahir akan digunakan sebagai password default masuk sistem.</div>
                            </div>

                            <div class="mb-3">
                                <label for="asal_sekolah" class="form-label fw-bold">Sekolah Asal (SMA/SMK/MA)</label>
                                <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" required placeholder="Contoh: SMA Negeri 1 Singkawang">
                            </div>

                            <div class="mb-3">
                                <label for="prodi_id" class="form-label fw-bold">Pilih Program Studi Pilihan</label>
                                <select class="form-select" id="prodi_id" name="prodi_id" required>
                                    <option value="" disabled selected>-- Pilih Program Studi --</option>
                                    <?php foreach ($prodi as $pr) : ?>
                                        <option value="<?= $pr['id']; ?>"><?= $pr['jenjang']; ?> <?= $pr['nama_prodi']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Password Kustom (Opsional)</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika ingin memakai tanggal lahir">
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100 py-2 mb-3">Daftar PMB Sekarang</button>
                            
                            <div class="text-center">
                                Sudah memiliki Akun Pendaftaran? <a href="/login" class="text-decoration-none fw-bold">Login di sini</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
