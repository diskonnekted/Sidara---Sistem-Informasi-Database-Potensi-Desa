<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== CEK DETAIL ASTRA MOTOR PAGENTAN ===' . "\n\n";

// 1. Cari produk Astra Motor Pagentan
$product = App\Models\Potential::where('slug', 'astra-motor-pagentan')->first();

if (!$product) {
    echo '❌ Produk Astra Motor Pagentan tidak ditemukan!' . "\n";
    exit;
}

echo '=== ' . $product->title . ' ===' . "\n";
echo 'Slug: ' . $product->slug . "\n";
echo 'ID: ' . $product->id . "\n";

// 2. Cek gambar di database
if (!empty($product->images)) {
    echo 'Gambar di database:' . "\n";
    foreach ($product->images as $index => $image) {
        echo '   ' . ($index + 1) . '. ' . $image . "\n";
        
        if (!filter_var($image, FILTER_VALIDATE_URL)) {
            $filePath = storage_path('app/public/' . $image);
            $exists = file_exists($filePath);
            echo '      ' . ($exists ? '✅ ADA' : '❌ TIDAK ADA') . ' di: ' . $filePath . "\n";
            
            if ($exists) {
                echo '      📏 Size: ' . filesize($filePath) . ' bytes' . "\n";
                echo '      🔗 URL: http://localhost:8000/storage/' . $image . "\n";
            }
        } else {
            echo '      🌐 EXTERNAL URL' . "\n";
        }
        echo "\n";
    }
} else {
    echo '❌ Tidak ada gambar di database' . "\n";
}

// 3. Cek file yang user coba akses (pagentan-astra-motor.jpg)
echo '=== CEK FILE YANG DICARI USER ===' . "\n";
$userFile = 'potentials/pagentan-astra-motor.jpg';
$userFilePath = storage_path('app/public/' . $userFile);

echo 'File: ' . $userFile . "\n";
echo 'Path: ' . $userFilePath . "\n";
echo 'Exists: ' . (file_exists($userFilePath) ? '✅ YES' : '❌ NO') . "\n";

if (file_exists($userFilePath)) {
    echo 'Size: ' . filesize($userFilePath) . ' bytes' . "\n";
    echo 'URL: http://localhost:8000/storage/' . $userFile . "\n";
} else {
    echo '💡 File ini tidak ada di sistem. Mungkin file lama yang sudah dihapus.' . "\n";
}

// 4. Cek semua file di folder potentials yang terkait Astra
echo "\n=== FILE ASTRA DI FOLDER STORAGE ===\n";
$storagePath = storage_path('app/public/potentials/');
if (is_dir($storagePath)) {
    $files = scandir($storagePath);
    $astraFiles = [];
    
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..' && stripos($file, 'astra') !== false) {
            $astraFiles[] = $file;
        }
    }
    
    if (!empty($astraFiles)) {
        echo 'File Astra ditemukan:' . "\n";
        foreach ($astraFiles as $file) {
            $filePath = $storagePath . $file;
            echo '   📄 ' . $file . ' (' . filesize($filePath) . ' bytes)' . "\n";
            echo '      🔗 http://localhost:8000/storage/potentials/' . $file . "\n";
        }
    } else {
        echo '❌ Tidak ada file Astra di folder' . "\n";
    }
}

// 5. Rekomendasi
echo "\n=== REKOMENDASI ===\n";
if (!empty($product->images)) {
    echo '✅ Produk sudah memiliki gambar yang valid di database\n';
    echo '🚀 Coba akses URL gambar yang benar:\n';
    foreach ($product->images as $image) {
        if (!filter_var($image, FILTER_VALIDATE_URL)) {
            echo '- http://localhost:8000/storage/' . $image . "\n";
        }
    }
} else {
    echo '❌ Produk tidak memiliki gambar. Perlu ditambahkan gambar.\n';
}