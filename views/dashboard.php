<?php
require_once '../config/Database.php';
require_once '../models/balita.php';
session_start();

// Auth check (optional, hapus jika tidak ingin login)
if (!isset($_SESSION['user_id'])) {
    header('Location: ../home.php');
    exit;
}

// Proses hapus data
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $bayiModel = new Bayi();
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
$bayiModel = new Bayi();
if ($keyword !== '') {
    $dataBayi = $bayiModel->search($keyword);
} else {
    $dataBayi = $bayiModel->tampil_data();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Monitoring Balita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,.05);
        }
        .table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
            font-weight: 600;
        }
        .btn {
            border-radius: 6px;
            padding: 0.5rem 1rem;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
        }
        .search-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,.05);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Monitoring Balita</a>
            <div class="d-flex">
                <a href="../home.php?logout=1" class="btn btn-outline-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="fw-bold mb-0">Data Balita</h2>
                <p class="text-muted">Manajemen data balita dan perkembangannya</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="tambah_bayi.php" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Data
                </a>
            </div>
        </div>

        <div class="card search-box mb-4">
            <div class="card-body">
                <form action="dashboard.php" method="GET" class="row g-2">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Cari nama bayi..." value="<?= htmlspecialchars($keyword) ?>">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="px-4">No</th>
                                <th>Nama</th>
                                <th>Tinggi</th>
                                <th>Berat</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Riwayat</th>
                                <th>Catatan</th>
                                <th class="px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($dataBayi as $bayi): ?>
                                <tr>
                                    <td class="px-4"><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($bayi['nama']) ?></td>
                                    <td><?= $bayi['tinggi'] ?> cm</td>
                                    <td><?= $bayi['berat'] ?> kg</td>
                                    <td><?= $bayi['jenisKelamin'] ?></td>
                                    <td><?= $bayi['tanggalLahir'] ?></td>
                                    <td><?= htmlspecialchars($bayi['riwayat']) ?></td>
                                    <td><?= htmlspecialchars($bayi['catatan']) ?></td>
                                    <td class="px-4">
                                        <a href="data.php?id=<?= $bayi['id'] ?>" class="btn btn-info btn-sm text-white">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="edit_bayi.php?id=<?= $bayi['id'] ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="dashboard.php?hapus=<?= $bayi['id'] ?>" class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($dataBayi)): ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                            Tidak ada data
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>