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
                        <h5 class="mb-0 fw-bold">Tambah Program Studi STKIP</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="/admin/prodi/store" method="post">
                            <?= csrf_field(); ?>
                            
                            <div class="mb-3">
                                <label for="nama_prodi" class="form-label">Nama Program Studi</label>
                                <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" required placeholder="Contoh: Pendidikan Geografi">
                            </div>
                            
                            <div class="mb-3">
                                <label for="jenjang" class="form-label">Jenjang Pendidikan</label>
                                <select class="form-select" id="jenjang" name="jenjang" required>
                                    <option value="S1">S1 (Sarjana)</option>
                                    <option value="D3">D3 (Diploma III)</option>
                                    <option value="S2">S2 (Magister)</option>
                                </select>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="/admin" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Prodi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
