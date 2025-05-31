<?php
session_start();
require_once '../config/database.php';
require_once '../models/balita.php';

$model = new Bayi();
if (isset($_GET['id'])) {
    $row = $model->getBayiById((int)$_GET['id']);
    $dataBayi = $row ? [$row] : [];
} else {
    $dataBayi = $model->tampil_data();
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
                <a href="dashboard.php" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Content Section -->
        <?php if (empty($dataBayi)): ?>
            <div class="bg-white rounded-xl shadow-md p-12">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-xl text-gray-500">Tidak ada data bayi.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="grid md:grid-cols-2 gap-6">
                <?php foreach ($dataBayi as $row): ?>
                    <?php
                        $bayi = new Bayi();
                        $bayi->setId($row['id']);
                        $bayi->setNama($row['nama']);
                        $bayi->setTinggi($row['tinggi']);
                        $bayi->setBerat($row['berat']);
                        $bayi->setJenisKelamin($row['jenisKelamin']);
                        $bayi->setTanggalLahir($row['tanggalLahir']);
                        $bayi->setRiwayat($row['riwayat']);
                        $bayi->setCatatan($row['catatan']);
                        $bayi->setUserId($row['user_id']);
                    ?>
                    
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                        <!-- Header Card -->
                        <div class="bg-blue-50 p-4 border-b border-blue-100">
                            <h2 class="text-xl font-bold text-blue-800"><?= htmlspecialchars($bayi->getNama()) ?></h2>
                        </div>

                        <!-- Body Card -->
                        <div class="p-4 space-y-4">
                            <!-- Measurements -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <div class="text-sm text-gray-600">Tinggi Badan</div>
                                    <div class="text-lg font-semibold text-blue-700"><?= htmlspecialchars($bayi->getTinggi()) ?> cm</div>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <div class="text-sm text-gray-600">Berat Badan</div>
                                    <div class="text-lg font-semibold text-blue-700"><?= htmlspecialchars($bayi->getBerat()) ?> kg</div>
                                </div>
                            </div>

                            <!-- Basic Info -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <div class="text-sm text-gray-600">Jenis Kelamin</div>
                                    <div class="font-medium text-gray-800"><?= htmlspecialchars($bayi->getJenisKelamin()) ?></div>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <div class="text-sm text-gray-600">Tanggal Lahir</div>
                                    <div class="font-medium text-gray-800"><?= htmlspecialchars($bayi->getTanggalLahir()) ?></div>
                                </div>
                            </div>

                            <!-- Medical History -->
                            <div class="space-y-3">
                                <div>
                                    <div class="text-sm font-medium text-gray-600 mb-1">Riwayat Kesehatan</div>
                                    <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-800 min-h-[60px]">
                                        <?= nl2br(htmlspecialchars($bayi->getRiwayat())) ?: '<span class="text-gray-400">Tidak ada riwayat</span>' ?>
                                    </div>
                                </div>

                                <div>
                                    <div class="text-sm font-medium text-gray-600 mb-1">Catatan</div>
                                    <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-800 min-h-[60px]">
                                        <?= nl2br(htmlspecialchars($bayi->getCatatan())) ?: '<span class="text-gray-400">Tidak ada catatan</span>' ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Admin Info -->
                            <div class="border-t pt-3 mt-3">
                                <div class="text-xs text-gray-500">ID Admin Penginput</div>
                                <div class="text-sm font-medium text-gray-700"><?= htmlspecialchars($bayi->getUserId()) ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>