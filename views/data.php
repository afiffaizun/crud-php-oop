<?php
session_start();
require_once '../config/database.php';
require_once '../models/balita.php';

$model = new Bayi();

// Cek apakah ada parameter id
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
<body class="bg-gray-50 font-sans min-h-screen flex items-center justify-center">
    <div class="w-full max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Data Bayi</h1>
            <a href="dashboard.php" class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">&larr; Kembali</a>
        </div>
        <?php if (empty($dataBayi)): ?>
            <div class="text-center py-10 text-gray-400">Tidak ada data bayi.</div>
        <?php else: ?>
            <div class="space-y-5">
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
                    ?>
                    <div class="border border-gray-200 rounded-lg p-5 shadow-sm hover:shadow-md transition bg-gray-50">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-lg font-bold text-blue-700"><?= htmlspecialchars($bayi->getNama()) ?></h2>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-2">
                            <div>
                                <div class="text-xs text-gray-500">Tinggi</div>
                                <div class="text-base font-medium text-gray-700"><?= htmlspecialchars($bayi->getTinggi()) ?> cm</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Berat</div>
                                <div class="text-base font-medium text-gray-700"><?= htmlspecialchars($bayi->getBerat()) ?> kg</div>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-2">
                            <div><span class="font-medium">Jenis Kelamin:</span> <?= htmlspecialchars($bayi->getJenisKelamin()) ?></div>
                            <div><span class="font-medium">Tanggal Lahir:</span> <?= htmlspecialchars($bayi->getTanggalLahir()) ?></div>
                        </div>
                        <div class="mt-2">
                            <div class="mb-1 font-medium text-gray-700">Riwayat:</div>
                            <div class="bg-white rounded p-2 text-xs text-gray-700 border border-gray-100"><?= nl2br(htmlspecialchars($bayi->getRiwayat())) ?></div>
                        </div>
                        <div class="mt-2">
                            <div class="mb-1 font-medium text-gray-700">Catatan:</div>
                            <div class="bg-white rounded p-2 text-xs text-gray-700 border border-gray-100"><?= nl2br(htmlspecialchars($bayi->getCatatan())) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>