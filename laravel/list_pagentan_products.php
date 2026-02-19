<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Cari semua produk dari Desa Pagentan
echo '=== PRODUK-PRODUK DESA PAGENTAN ===' . "\n";

$pagentanVillage = App\Models\Village::where('village_name', 'Pagentan')->first();

if (!$pagentanVillage) {
    echo '❌ Desa Pagentan tidak ditemukan!' . "\n";
    exit;
}

echo 'Desa: ' . $pagentanVillage->village_name . ', Kec: ' . $pagentanVillage->district_name . "\n";
echo 'ID: ' . $pagentanVillage->id . "\n\n";

// Ambil semua produk dari desa Pagentan
$products = App\Models\Potential::where('village_id', $pagentanVillage->id)->get();

echo 'Jumlah produk: ' . $products->count() . "\n\n";

foreach ($products as $product) {
    echo 'ID: ' . $product->id . "\n";
    echo 'Judul: ' . $product->title . "\n";
    echo 'Gambar: ' . (is_array($product->images) ? count($product->images) . ' gambar' : 'Tidak ada gambar') . "\n";
    
    if (is_array($product->images) && !empty($product->images)) {
        echo '  - ' . implode("\n  - ", $product->images) . "\n";
    }
    echo "---\n";
}

// Juga tampilkan produk dari Gumingsir (karena Pagentan district)
echo '\\n=== PRODUK DARI KECAMATAN PAGENTAN (GUMINGSIR) ===' . "\n";
$gumingsirVillage = App\Models\Village::where('village_name', 'Gumingsir')->where('district_name', 'Pagentan')->first();

if ($gumingsirVillage) {
    $gumingsirProducts = App\Models\Potential::where('village_id', $gumingsirVillage->id)->get();
    echo 'Jumlah produk Gumingsir: ' . $gumingsirProducts->count() . "\n";
    
    foreach ($gumingsirProducts as $product) {
        echo 'ID: ' . $product->id . ', Judul: ' . $product->title . "\n";
    }
} else {
    echo 'Tidak ada produk dari Gumingsir Pagentan' . "\n";
}