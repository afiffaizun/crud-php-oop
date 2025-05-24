<?php
require_once 'config/Database.php';
require_once 'models/Model.php';

$model = new BayiModel();

// Cek apakah ada parameter id
if (isset($_GET['id'])) {
    $row = $model->getBayiById((int)$_GET['id']);
    $dataBayi = $row ? [$row] : [];
} else {
    $dataBayi = $model->getAllBayi();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Bayi</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans items-center flex justify-center items-center min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-5xl">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Data Bayi</h1>
        <a href="views/dashboard.php" class="inline-block mb-6 px-4 py-2 bg-red-500 text-white rounded hover:bg-blue-600 transition-colors duration-200">
            &larr; Kembali
        </a>
        
        <?php if (empty($dataBayi)): ?>
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-gray-500">Tidak ada data bayi.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($dataBayi as $row): ?>
                    <?php
                        $bayi = new BayiModel();
                        $bayi->setId($row['id']);
                        $bayi->setNama($row['nama']);
                        $bayi->setTinggi($row['tinggi']);
                        $bayi->setBerat($row['berat']);
                        $bayi->setJenisKelamin($row['jenisKelamin']);
                        $bayi->setTanggalLahir($row['tanggalLahir']);
                        $bayi->setRiwayat($row['riwayat']);
                        $bayi->setCatatan($row['catatan']);
                    ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="bg-blue-500 p-4">
                            <h2 class="text-xl font-bold text-white"><?= htmlspecialchars($bayi->getNama()) ?></h2>
                           
                        </div>
                        <div class="p-5">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="bg-blue-50 p-3 rounded">
                                    <p class="text-sm text-gray-500">Tinggi</p>
                                    <p class="text-lg font-semibold"><?= htmlspecialchars($bayi->getTinggi()) ?> cm</p>
                                </div>
                                <div class="bg-blue-50 p-3 rounded">
                                    <p class="text-sm text-gray-500">Berat</p>
                                    <p class="text-lg font-semibold"><?= htmlspecialchars($bayi->getBerat()) ?> kg</p>
                                </div>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center border-b border-gray-200 py-2">
                                    <span class="font-medium text-gray-700 w-1/3">Jenis Kelamin:</span>
                                    <span class="text-gray-800"><?= htmlspecialchars($bayi->getJenisKelamin()) ?></span>
                                </div>
                                
                                <div class="flex items-center border-b border-gray-200 py-2">
                                    <span class="font-medium text-gray-700 w-1/3">Tanggal Lahir:</span>
                                    <span class="text-gray-800"><?= htmlspecialchars($bayi->getTanggalLahir()) ?></span>
                                </div>
                                
                                <div class="py-2">
                                    <p class="font-medium text-gray-700 mb-1">Riwayat:</p>
                                    <p class="text-gray-800 bg-gray-50 p-3 rounded text-sm"><?= nl2br(htmlspecialchars($bayi->getRiwayat())) ?></p>
                                </div>
                                
                                <div class="py-2">
                                    <p class="font-medium text-gray-700 mb-1">Catatan:</p>
                                    <p class="text-gray-800 bg-gray-50 p-3 rounded text-sm"><?= nl2br(htmlspecialchars($bayi->getCatatan())) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
</body>
</html>