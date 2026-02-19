<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== DEBUG MASALAH GAMBAR DAN ROUTING ===' . "\n\n";

// 1. Cek produk Tempe untuk melihat gambar yang seharusnya
$tempeProduct = App\Models\Potential::where('title', 'like', '%Tempe Goreng%')->first();

if ($tempeProduct) {
    echo '=== PRODUK TEMPE ===' . "\n";
    echo 'Title: ' . $tempeProduct->title . "\n";
    echo 'Slug: ' . $tempeProduct->slug . "\n";
    echo 'Images: ' . json_encode($tempeProduct->images, JSON_PRETTY_PRINT) . "\n";
    
    // Cek file gambar
    if (!empty($tempeProduct->images)) {
        echo '\\n=== CEK FILE GAMBAR ===' . "\n";
        foreach ($tempeProduct->images as $image) {
            $filePath = public_path('storage/' . $image);
            echo 'Image: ' . $image . "\n";
            echo 'Exists: ' . (file_exists($filePath) ? '✅ YES' : '❌ NO') . "\n";
            echo 'Path: ' . $filePath . "\n\\n";
        }
    }
}

// 2. Cek routing yang benar untuk produk Tempe
echo '=== URL YANG BENAR ===' . "\n";
echo 'Product URL: http://localhost:8000/potensi/' . $tempeProduct->slug . "\n";

// 3. Cek masalah direct image access
echo '\\n=== DIRECT IMAGE ACCESS ISSUE ===' . "\n";
echo 'Anda mencoba mengakses: http://localhost:8000/storage/pagentan-klotak.jpg' . "\n";
echo 'Ini SALAH karena gambar harus diakses melalui: http://localhost:8000/storage/potentials/nama-file.jpg' . "\n";

// 4. Cek file di storage/potentials
echo '\\n=== FILE DI STORAGE/POTENTIALS ===' . "\n";
$storagePath = public_path('storage/potentials/');
$files = scandir($storagePath);
foreach ($files as $file) {
    if ($file !== '.' && $file !== '..') {
        echo '- ' . $file . "\n";
    }
}

// 5. Cek apakah ada file dengan pattern pagentan
echo '\\n=== FILE PAGENTAN ===' . "\n";
foreach ($files as $file) {
    if ($file !== '.' && $file !== '..' && stripos($file, 'pagentan') !== false) {
        echo 'Found: ' . $file . "\n";
    }
}