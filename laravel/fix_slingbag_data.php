<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Cek data Slingbag Custom
$slingbag = App\Models\Potential::find(79);

if ($slingbag) {
    echo '=== DATA SLINGBAG CUSTOM ===' . "\n";
    echo 'ID: ' . $slingbag->id . "\n";
    echo 'Title: ' . $slingbag->title . "\n";
    echo 'Price Range: ' . ($slingbag->price_range ?: 'NULL') . "\n";
    echo 'Status: ' . $slingbag->verification_status . "\n";
    
    // Debug images data
    echo 'Images Data Type: ' . gettype($slingbag->images) . "\n";
    
    if (is_array($slingbag->images)) {
        echo 'Images (array): ' . print_r($slingbag->images, true) . "\n";
        echo 'Jumlah Gambar: ' . count($slingbag->images) . "\n";
    } elseif (is_string($slingbag->images)) {
        echo 'Images (string): ' . $slingbag->images . "\n";
        $decoded = json_decode($slingbag->images, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            echo 'Decoded Images: ' . print_r($decoded, true) . "\n";
        } else {
            echo 'JSON Decode Error: ' . json_last_error_msg() . "\n";
        }
    } else {
        echo 'Images is NULL or other type' . "\n";
    }
    
} else {
    echo 'Produk tidak ditemukan!' . "\n";
}

// Sekarang mari kita perbaiki data yang kurang
// 1. Tambahkan gambar jika belum ada
// 2. Pastikan harga sudah benar
// 3. Pastikan status verified

echo '\\n=== MEMPERBAIKI DATA SLINGBAG ===' . "\n";

if ($slingbag) {
    // Jika images kosong atau tidak valid, tambahkan gambar default
    if (empty($slingbag->images)) {
        $defaultImage = ['slingbag-default.jpg'];
        $slingbag->images = $defaultImage;
        echo '✓ Menambahkan gambar default' . "\n";
    }
    
    // Pastikan price_range sesuai
    if (empty($slingbag->price_range)) {
        $slingbag->price_range = 'Rp 100.000,00 / pcs';
        echo '✓ Memperbaiki price range' . "\n";
    }
    
    // Pastikan status verified
    if ($slingbag->verification_status !== 'verified') {
        $slingbag->verification_status = 'verified';
        echo '✓ Mengubah status menjadi verified' . "\n";
    }
    
    // Simpan perubahan
    $slingbag->save();
    echo '✓ Data berhasil disimpan!' . "\n";
    
    echo '\\nData setelah diperbaiki:' . "\n";
    echo 'Price Range: ' . $slingbag->price_range . "\n";
    echo 'Status: ' . $slingbag->verification_status . "\n";
    echo 'Images: ' . print_r($slingbag->images, true) . "\n";
    
} else {
    echo 'Tidak dapat memperbaiki data - produk tidak ditemukan' . "\n";
}