<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Cek isi kolom images untuk Slingbag Custom
$slingbag = App\Models\Potential::find(79);

if ($slingbag) {
    echo '=== DATA SLINGBAG CUSTOM ===' . "\n";
    echo 'ID: ' . $slingbag->id . "\n";
    echo 'Title: ' . $slingbag->title . "\n";
    echo 'Images: ' . ($slingbag->images ? $slingbag->images : 'NULL') . "\n";
    echo 'Price Range: ' . ($slingbag->price_range ? $slingbag->price_range : 'NULL') . "\n";
    echo 'Verification Status: ' . $slingbag->verification_status . "\n";
    
    // Decode images jika ada
    if ($slingbag->images) {
        $imageData = json_decode($slingbag->images, true);
        echo 'Decoded Images: ' . print_r($imageData, true) . "\n";
    }
} else {
    echo 'Produk tidak ditemukan!' . "\n";
}

// Cek beberapa produk lain untuk contoh images
$otherProducts = App\Models\Potential::whereNotNull('images')->take(3)->get();
echo '\\n=== CONTOH PRODUK LAIN DENGAN GAMBAR ===' . "\n";
foreach ($otherProducts as $product) {
    echo $product->id . ': ' . $product->title . "\n";
    echo 'Images: ' . $product->images . "\n";
    if ($product->images) {
        $images = json_decode($product->images, true);
        echo 'Decoded: ' . print_r($images, true) . "\n";
    }
    echo "---\n";
}