<?php
require_once '../config/Database.php';
require_once '../models/Model.php';
session_start();

// Auth check (optional, hapus jika tidak ingin login)
if (!isset($_SESSION['user_id'])) {
    header('Location: ../home.php');
    exit;
}

// Proses hapus data
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $bayiModel = new BayiModel();
    if ($bayiModel->hapus($id)) {
        echo "<script>alert('Data bayi berhasil dihapus');window.location='dashboard.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menghapus data bayi');window.location='dashboard.php';</script>";
        exit;
    }
}

// Proses pencarian dan Tampilkan data
$keyword = $_GET['keyword'] ?? '';
$bayiModel = new BayiModel();
if ($keyword !== '') {
    $dataBayi = $bayiModel->search($keyword);
} else {
    $dataBayi = $bayiModel->tampil_data();
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Data Balita</h2>
        <a href="tambah_bayi.php" class="btn btn-success mb-3">+ Tambah Data</a>
        <a href="../home.php?logout=1" class="btn btn-danger mb-3">Logout</a>

        <div class="mb-3">
            <form action="dashboard.php" method="GET" class="d-flex" style="max-width: 350px;">
                <input type="text" name="keyword" class="form-control me-2" placeholder="Cari nama bayi..." value="<?= htmlspecialchars($keyword) ?>">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>

        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tinggi</th>
                    <th>Berat</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Riwayat</th>
                    <th>Catatan</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($dataBayi as $bayi): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($bayi['nama']) ?></td>
                        <td><?= $bayi['tinggi'] ?> cm</td>
                        <td><?= $bayi['berat'] ?> kg</td>
                        <td><?= $bayi['jenisKelamin'] ?></td>
                        <td><?= $bayi['tanggalLahir'] ?></td>
                        <td><?= htmlspecialchars($bayi['riwayat']) ?></td>
                        <td><?= htmlspecialchars($bayi['catatan']) ?></td>
                        <td>
                            <a href="../data.php?id=<?= $bayi['id'] ?>" class="btn btn-info btn-sm">Lihat</a>
                            <a href="edit_bayi.php?id=<?= $bayi['id'] ?>"
                                class="btn btn-warning btn-sm">Edit</a>
                            <a href="dashboard.php?hapus=<?= $bayi['id'] ?>"
                                class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($dataBayi)): ?>
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>