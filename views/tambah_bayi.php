<?php
require_once '../config/Database.php';
require_once '../models/balita.php';
session_start();

// Auth check (optional, hapus jika tidak ingin login)
if (!isset($_SESSION['user_id'])) {
    header('Location: ../home.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bayiModel = new Bayi();
    $bayiModel->setNama($_POST['nama']);
    $bayiModel->setTinggi($_POST['tinggi']);
    $bayiModel->setBerat($_POST['berat']);
    $bayiModel->setJenisKelamin($_POST['jenisKelamin']);
    $bayiModel->setTanggalLahir($_POST['tanggalLahir']);
    $bayiModel->setRiwayat($_POST['riwayat'] ?? '');
    $bayiModel->setCatatan($_POST['catatan'] ?? '');
    
    if ($bayiModel->tambah()) {
        header('Location: dashboard.php');
        exit;
    } else {
        $errorMessage = 'Gagal menambah data bayi';
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Balita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container my-5">
        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger alert-dismissible fade show"
                role="alert">
                <?= $errorMessage ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <h2>Tambah Data Balita</h2>
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
                <label class="col-sm-3 col-form-label">Tinggi Badan (cm)</label>
                <div class="col-sm-6">
                    <input type="number" name="tinggi" class="form-control" placeholder="Tinggi badan..." step="0.01"
                        required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Berat Badan (kg)</label>
                <div class="col-sm-6">
                    <input type="number" name="berat" class="form-control" placeholder="Berat badan..." step="0.01"
                        required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-6">
                    <input type="date" name="tanggalLahir" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Riwayat Penyakit</label>
                <div class="col-sm-6">
                    <input type="text" name="riwayat" class="form-control" placeholder="Riwayat penyakit...">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Catatan</label>
                <div class="col-sm-6">
                    <input type="text" name="catatan" class="form-control" placeholder="Catatan...">
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