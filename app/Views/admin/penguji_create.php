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
                        <h5 class="mb-0 fw-bold">Tambah Dosen Penguji / Pewawancara</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="/admin/penguji/store" method="post">
                            <?= csrf_field(); ?>
                            
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP (Nomor Induk Pegawai)</label>
                                <input type="text" class="form-control" id="nip" name="nip" required placeholder="Contoh: 19900102">
                            </div>
                            
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap (beserta Gelar)</label>
                                <input type="text" class="form-control" id="nama" name="nama" required placeholder="Contoh: Rina Herawati, M.Pd">
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="Contoh: rina@stkipsingkawang.ac.id">
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Login</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password (default jika kosong: penguji123)">
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="/admin" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Penguji</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
