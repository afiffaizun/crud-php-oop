<?php
require_once '../config/database.php';
require_once '../models/balita.php';
require_once '../models/orangtua.php';
session_start();

// Auth check
if (!isset($_SESSION['user_id'])) {
    header('Location: ../home.php');
    exit;
}

// Initialize alert variable
$alert = null;

$orangTuaModel = new OrangTua();
$orangTuaList = $orangTuaModel->tampil_orangtua();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bayiModel = new Bayi();
    $bayiModel->setNama($_POST['nama']);
    $bayiModel->setTinggi($_POST['tinggi']);
    $bayiModel->setBerat($_POST['berat']);
    $bayiModel->setJenisKelamin($_POST['jenisKelamin']);
    $bayiModel->setTanggalLahir($_POST['tanggalLahir']);
    $bayiModel->setRiwayat($_POST['riwayat'] ?? '');
    $bayiModel->setCatatan($_POST['catatan'] ?? '');
    $bayiModel->setOrangTuaId($_POST['orang_tua_id']);

    if ($bayiModel->tambah()) {
        // Use consistent alert pattern for success message
        $alert = ['type' => 'success', 'message' => 'Data bayi berhasil ditambahkan'];
    } else {
        $alert = ['type' => 'danger', 'message' => 'Gagal menambah data bayi'];
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
        <?php if ($alert): ?>
            <div class="alert alert-<?= $alert['type'] ?> alert-dismissible fade show" role="alert">
                <?= $alert['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <h2>Tambah Data Balita</h2>
        <br>

        <form action="" method="post">

            <div class="row mb-3">
                <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-6">
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama..."
                        required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="orang_tua_id" class="col-sm-3 col-form-label">Orang Tua</label>
                <div class="col-sm-6">
                    <select name="orang_tua_id" id="orang_tua_id" class="form-control" required>
                        <option value="">-- Pilih Orang Tua --</option>
                        <?php foreach ($orangTuaList as $orangTua): ?>
                            <option value="<?= $orangTua['orangtua_id'] ?>"><?= htmlspecialchars($orangTua['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="jenisKelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-6">
                    <select name="jenisKelamin" id="jenisKelamin" class="form-control" required>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="tinggi" class="col-sm-3 col-form-label">Tinggi Badan (cm)</label>
                <div class="col-sm-6">
                    <input type="number" name="tinggi" id="tinggi" class="form-control" placeholder="Tinggi badan..."
                        step="0.01" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="berat" class="col-sm-3 col-form-label">Berat Badan (kg)</label>
                <div class="col-sm-6">
                    <input type="number" name="berat" id="berat" class="form-control" placeholder="Berat badan..."
                        step="0.01" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="tanggalLahir" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-6">
                    <input type="date" name="tanggalLahir" id="tanggalLahir" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="riwayat" class="col-sm-3 col-form-label">Riwayat Penyakit</label>
                <div class="col-sm-6">
                    <input type="text" name="riwayat" id="riwayat" class="form-control"
                        placeholder="Riwayat penyakit...">
                </div>
            </div>

            <div class="row mb-3">
                <label for="catatan" class="col-sm-3 col-form-label">Catatan</label>
                <div class="col-sm-6">
                    <input type="text" name="catatan" id="catatan" class="form-control" placeholder="Catatan...">
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
</body>

</html>