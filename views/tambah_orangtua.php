<?php
require_once '../models/orangtua.php';
session_start();

// Auth check (optional, hapus jika tidak ingin login)
if (!isset($_SESSION['user_id'])) {
    header('Location: ../home.php');
    exit;
}

$alert = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orangtua = new OrangTua();
    $orangtua->setNama($_POST['nama']);
    $orangtua->setJenisKelamin($_POST['jenisKelamin']);
    $orangtua->setAlamat($_POST['alamat']);
    $orangtua->setTelepon($_POST['telepon']);
    if ($orangtua->tambah_ortu()) {
        $alert = ['type' => 'success', 'message' => 'Data orang tua berhasil ditambahkan'];
    } else {
        $alert = ['type' => 'danger', 'message' => 'Gagal menambah data orang tua'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Orang Tua</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <?php if ($alert): ?>
            <div class="alert alert-<?= $alert['type'] ?> alert-dismissible fade show" role="alert">
                <?= $alert['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <h2>Input Data Orang Tua</h2>
        <br>
        <form action="" method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-6">
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama..." required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-6">
                    <select name="jenisKelamin" class="form-control" required>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Alamat</label>
                <div class="col-sm-6">
                    <input type="text" name="alamat" class="form-control" placeholder="Alamat..." required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Telepon</label>
                <div class="col-sm-6">
                    <input type="text" name="telepon" class="form-control" placeholder="Nomor telepon..." required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
                <div class="col-sm-6">
                    <a href="dashboard.php" class="btn btn-outline-primary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>