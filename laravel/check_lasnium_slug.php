<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== MEMERIKSA SLUG PRODUK LASNIUM KREASI ===' . "\n\n";

// Cari produk Lasnium Kreasi
$lasnium = App\Models\Potential::where('title', 'like', '%Lasnium Kreasi%')->first();

if (!$lasnium) {
    echo '❌ Produk Lasnium Kreasi tidak ditemukan!' . "\n";
    exit;
}

echo 'Produk: ' . $lasnium->title . "\n";
echo 'ID: ' . $lasnium->id . "\n";
echo 'Slug: ' . ($lasnium->slug ?? 'NULL') . "\n";

// Cek juga produk lain untuk perbandingan
$tempe = App\Models\Potential::where('title', 'like', '%Tempe Goreng%')->first();
if ($tempe) {
    echo '\\n=== PRODUK TEMPE UNTUK PERBANDINGAN ===' . "\n";
    echo 'Produk: ' . $tempe->title . "\n";
    echo 'ID: ' . $tempe->id . "\n";
    echo 'Slug: ' . ($tempe->slug ?? 'NULL') . "\n";
}

// Cek semua produk Pagentan untuk melihat pola slug
$pagentanVillage = App\Models\Village::where('village_name', 'Pagentan')->first();
if ($pagentanVillage) {
    $pagentanProducts = App\Models\Potential::where('village_id', $pagentanVillage->id)->get();
    echo '\\n=== SLUG SEMUA PRODUK PAGENTAN ===' . "\n";
    foreach ($pagentanProducts as $product) {
        echo $product->id . ': ' . $product->title . ' -> ' . ($product->slug ?? 'NULL') . "\n";
    }
}

// Generate slug yang seharusnya
$slugService = new \App\Services\SlugService();
$expectedSlug = $slugService->createSlug($lasnium->title, 'potentials');
echo '\\nSlug yang diharapkan: ' . $expectedSlug . "\n";