<?php
require_once '../config/Database.php';
require_once '../models/balita.php';
session_start();

// Auth check
if (!isset($_SESSION['user_id'])) {
    header('Location: ../home.php');
    exit;
}

$bayiModel = new Bayi();
$alert = null;

// Ambil data bayi untuk edit
if (!isset($_GET['id'])) {
    $alert = ['type' => 'danger', 'message' => 'ID tidak ditemukan'];
} else {
    $id = (int)$_GET['id'];
    $dataBayi = $bayiModel->getBayiById($id);
    if (!$dataBayi) {
        $alert = ['type' => 'danger', 'message' => 'Data bayi tidak ditemukan'];
    }
}

// Proses update data
if (isset($dataBayi) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $bayiModel->setNama($_POST['nama']);
    $bayiModel->setTinggi($_POST['tinggi']);
    $bayiModel->setBerat($_POST['berat']);
    $bayiModel->setJenisKelamin($_POST['jenisKelamin']);
    $bayiModel->setTanggalLahir($_POST['tanggalLahir']);
    $bayiModel->setRiwayat($_POST['riwayat']);
    $bayiModel->setCatatan($_POST['catatan']);
    if ($bayiModel->update($id)) {
        $alert = ['type' => 'success', 'message' => 'Data bayi berhasil diperbarui'];
        // Refresh data setelah update
        $dataBayi = $bayiModel->getBayiById($id);
    } else {
        $alert = ['type' => 'danger', 'message' => 'Gagal memperbarui data bayi'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Balita</title>
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

        <h2>Edit Data Balita</h2>
        <br>

        <form action="" method="post">
            <input type="hidden" name="id" value="<?= $dataBayi['id'] ?>">

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-6">
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama..."
                        value="<?= htmlspecialchars($dataBayi['nama']) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-6">
                    <select name="jenisKelamin" class="form-control">
                        <option value="Laki-Laki" <?= ($dataBayi['jenisKelamin'] == 'Laki-Laki') ? 'selected' : '' ?>>
                            Laki-Laki</option>
                        <option value="Perempuan" <?= ($dataBayi['jenisKelamin'] == 'Perempuan') ? 'selected' : '' ?>>
                            Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Tinggi Badan (cm)</label>
                <div class="col-sm-6">
                    <input type="number" name="tinggi" class="form-control" placeholder="Tinggi badan..." step="0.01"
                        value="<?= $dataBayi['tinggi'] ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Berat Badan (kg)</label>
                <div class="col-sm-6">
                    <input type="number" name="berat" class="form-control" placeholder="Berat badan..." step="0.01"
                        value="<?= $dataBayi['berat'] ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-6">
                    <input type="date" name="tanggalLahir" class="form-control"
                        value="<?= date('Y-m-d', strtotime($dataBayi['tanggalLahir'])) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Riwayat Penyakit</label>
                <div class="col-sm-6">
                    <input type="text" name="riwayat" class="form-control" placeholder="Riwayat penyakit..."
                        value="<?= htmlspecialchars($dataBayi['riwayat']) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Catatan</label>
                <div class="col-sm-6">
                    <input type="text" name="catatan" class="form-control" placeholder="Catatan..."
                        value="<?= htmlspecialchars($dataBayi['catatan']) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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