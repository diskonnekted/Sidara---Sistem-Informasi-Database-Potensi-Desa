<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Cek data lengkap Slingbag Custom
$slingbag = App\Models\Potential::find(79);

if ($slingbag) {
    echo '=== DATA LENGKAP SLINGBAG CUSTOM ===' . "\n";
    echo 'ID: ' . $slingbag->id . "\n";
    echo 'Title: ' . $slingbag->title . "\n";
    echo 'Description: ' . substr($slingbag->description, 0, 100) . '...' . "\n";
    echo 'Price Range: ' . ($slingbag->price_range ?: 'NULL') . "\n";
    echo 'Verification Status: ' . $slingbag->verification_status . "\n";
    echo 'Images: ' . ($slingbag->images ? 'ADA DATA' : 'NULL') . "\n";
    
    // Decode images jika ada
    if ($slingbag->images) {
        $imageData = json_decode($slingbag->images, true);
        echo 'Jumlah Gambar: ' . count($imageData) . "\n";
        echo 'Gambar: ' . print_r($imageData, true) . "\n";
    }
    
    echo 'WhatsApp: ' . ($slingbag->whatsapp_number ?: 'NULL') . "\n";
    echo 'Status: ' . $slingbag->verification_status . "\n";
    
} else {
    echo 'Produk tidak ditemukan!' . "\n";
}

// Cek struktur data images yang benar
$sampleProduct = App\Models\Potential::whereNotNull('images')->first();
if ($sampleProduct) {
    echo '\\n=== CONTOH STRUKTUR IMAGES YANG BENAR ===' . "\n";
    echo 'Product: ' . $sampleProduct->title . "\n";
    $images = json_decode($sampleProduct->images, true);
    echo 'Images Structure: ' . print_r($images, true) . "\n";
}