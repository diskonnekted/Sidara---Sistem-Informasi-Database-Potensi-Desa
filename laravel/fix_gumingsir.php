<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Pindahkan produk dari Gumingsir Pagentan ke Gumingsir Wanadadi
$wrongProduct = App\Models\Potential::where('village_id', 195)->where('title', 'like', '%Slingbag%')->first();

if ($wrongProduct) {
    echo 'Produk yang akan dipindahkan: ' . $wrongProduct->title . "\n";
    echo 'Dari village_id: ' . $wrongProduct->village_id . "\n";
    
    // Update ke village_id yang benar (149)
    $wrongProduct->village_id = 149;
    $wrongProduct->save();
    
    echo 'Produk berhasil dipindahkan ke village_id 149\n';
} else {
    echo 'Produk tidak ditemukan\n';
}

// Verifikasi
$gumingsirWanadadi = App\Models\Village::find(149);
$gumingsirPagentan = App\Models\Village::find(195);

echo '\\nSetelah perbaikan:\n';
echo 'Gumingsir Wanadadi (149) produk: ' . App\Models\Potential::where('village_id', 149)->count() . "\n";
echo 'Gumingsir Pagentan (195) produk: ' . App\Models\Potential::where('village_id', 195)->count() . "\n";