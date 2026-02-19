<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Cek semua desa Gumingsir
$gumingsirVillages = App\Models\Village::where('village_name', 'like', '%Gumingsir%')->get();
echo 'Jumlah desa Gumingsir: ' . $gumingsirVillages->count() . "\n";

foreach ($gumingsirVillages as $village) {
    echo 'ID: ' . $village->id . ', Desa: ' . $village->village_name . ', Kec: ' . $village->district_name . "\n";
    echo 'Produk: ' . App\Models\Potential::where('village_id', $village->id)->count() . "\n\n";
}

// Cek produk dengan village_id 195
$products195 = App\Models\Potential::where('village_id', 195)->get();
echo 'Produk dengan village_id 195: ' . $products195->count() . "\n";
foreach ($products195 as $product) {
    echo 'ID: ' . $product->id . ', Judul: ' . $product->title . "\n";
}