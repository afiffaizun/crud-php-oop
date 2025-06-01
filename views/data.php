<?php
session_start();
require_once '../config/database.php';
require_once '../models/balita.php';
require_once '../models/orangtua.php';

// Auth check
if (!isset($_SESSION['user_id'])) {
    header('Location: ../home.php');
    exit;
}

$model = new Bayi();
$dataBayi = [];
$dataOrtu = null;

try {
    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];
        $row = $model->getBayiById($id);

        if ($row) {
            $dataBayi = $row;

            // Get parent data if available
            $modelOrtu = new OrangTua();
            $orangTuaId = $row['orang_tua_id'] ?? null;
            if ($orangTuaId) {
                $dataOrtu = $modelOrtu->tampil_orangtua_with_id($orangTuaId);
            }
        } else {
            // Add this missing error handling
            $errorMessage = "Data bayi dengan ID $id tidak ditemukan";
        }
    } else {
        // Jika tidak ada ID, tampilkan pesan error
        $errorMessage = "ID bayi tidak ditemukan";
    }
} catch (Exception $e) {
    // Log the error
    error_log("Error in data.php: " . $e->getMessage());
    // Set error message to display to user
    $errorMessage = "Terjadi kesalahan saat mengambil data. Silakan coba lagi nanti.";
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Bayi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans min-h-screen p-6">
    <div class="max-w-5xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-blue-800">Data Bayi</h1>
                <div class="flex gap-2">
                    <a href="dashboard.php"
                        class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Error Message Display -->
        <?php if (isset($errorMessage)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                <p><?= htmlspecialchars($errorMessage) ?></p>
            </div>
        <?php endif; ?>

        <!-- Content Section -->
        <?php if (empty($dataBayi)): ?>
            <!-- Empty data message -->
            <div class="bg-white rounded-xl shadow-md p-12">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-xl text-gray-500">Tidak ada data bayi.</p>
                </div>
            </div>
        <?php else: ?>
            <!-- Two column layout for baby and parent data -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left column: Baby data -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-blue-800 mb-4">Data Bayi</h2>
                    <div class="space-y-4">
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Nama</span>
                            <span class="font-medium"><?= htmlspecialchars($dataBayi['nama'] ?? '-') ?></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Jenis Kelamin</span>
                            <span class="font-medium"><?= htmlspecialchars($dataBayi['jenisKelamin'] ?? '-') ?></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Tanggal Lahir</span>
                            <span class="font-medium"><?= htmlspecialchars($dataBayi['tanggalLahir'] ?? '-') ?></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Tinggi Badan</span>
                            <span class="font-medium"><?= htmlspecialchars($dataBayi['tinggi'] ?? '-') ?> cm</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Berat Badan</span>
                            <span class="font-medium"><?= htmlspecialchars($dataBayi['berat'] ?? '-') ?> kg</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Riwayat Penyakit</span>
                            <span class="font-medium"><?= htmlspecialchars($dataBayi['riwayat'] ?? '-') ?></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Catatan</span>
                            <span class="font-medium"><?= htmlspecialchars($dataBayi['catatan'] ?? '-') ?></span>
                        </div>
                    </div>
                </div>

                <!-- Right column: Parent data -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-blue-800 mb-4">Data Orang Tua</h2>
                    <?php if ($dataOrtu): ?>
                        <div class="space-y-4">
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-500">Nama</span>
                                <span class="font-medium"><?= htmlspecialchars($dataOrtu['nama'] ?? '-') ?></span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-500">Jenis Kelamin</span>
                                <span class="font-medium"><?= htmlspecialchars($dataOrtu['jenisKelamin'] ?? '-') ?></span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-500">Alamat</span>
                                <span class="font-medium"><?= htmlspecialchars($dataOrtu['alamat'] ?? '-') ?></span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-500">No. Telepon</span>
                                <span class="font-medium"><?= htmlspecialchars($dataOrtu['telepon'] ?? '-') ?></span>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-6">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <p class="text-gray-500">Data orang tua tidak tersedia</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex justify-center mt-6 gap-3">
                <a href="edit_bayi.php?id=<?= $dataBayi['id'] ?>"
                    class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Edit Data Bayi
                </a>
                <a href="dashboard.php?hapus=<?= $dataBayi['id'] ?>"
                    class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition flex items-center gap-2"
                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus Data
                </a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Add any JavaScript functionality here if needed
    </script>
</body>

</html>