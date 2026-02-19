<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Cari produk Tempe Goreng
$tempeProduct = App\Models\Potential::where('title', 'like', '%Tempe Goreng%')->first();

if ($tempeProduct) {
    echo '=== INFORMASI PRODUK TEMPE GORENG ===' . "\n\n";
    echo 'ID: ' . $tempeProduct->id . "\n";
    echo 'Title: ' . $tempeProduct->title . "\n";
    echo 'Slug: ' . $tempeProduct->slug . "\n";
    echo 'Images: ' . json_encode($tempeProduct->images, JSON_PRETTY_PRINT) . "\n\n";
    
    echo '=== URL YANG BENAR ===' . "\n";
    echo '✅ URL Produk: http://localhost:8000/potensi/' . $tempeProduct->slug . "\n";
    
    if (!empty($tempeProduct->images)) {
        foreach ($tempeProduct->images as $image) {
            $filePath = public_path('storage/' . $image);
            echo '✅ URL Gambar: http://localhost:8000/storage/' . $image . "\n";
            echo '   File exists: ' . (file_exists($filePath) ? '✅ YES' : '❌ NO') . "\n";
        }
    }
} else {
    echo '❌ Produk Tempe Goreng tidak ditemukan' . "\n";
}

echo "\n=== CARA AKSES YANG BENAR ===\n";
echo '1. Akses PRODUK: http://localhost:8000/potensi/tempe-gorengmendoan-sijenggung' . "\n";
echo '2. Akses GAMBAR: http://localhost:8000/storage/potentials/sijenggung-Tempe-Goreng-mendoan.jpeg' . "\n";