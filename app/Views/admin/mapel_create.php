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
                        <h5 class="mb-0 fw-bold">Tambah Mata Pelajaran</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="/admin/mapel/store" method="post">
                            <?= csrf_field(); ?>
                            
                            <div class="mb-3">
                                <label for="nama_mapel" class="form-label">Nama Mata Pelajaran</label>
                                <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" required placeholder="Contoh: Matematika Wajib">
                            </div>
                            
                            <div class="mb-3">
                                <label for="guru_id" class="form-label">Pilih Guru Pengajar</label>
                                <select class="form-select" id="guru_id" name="guru_id" required>
                                    <option value="" disabled selected>-- Pilih Guru --</option>
                                    <?php foreach ($guru as $g) : ?>
                                        <option value="<?= $g['id']; ?>"><?= $g['nama']; ?> (NIP: <?= $g['nip']; ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="/admin" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Mapel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
