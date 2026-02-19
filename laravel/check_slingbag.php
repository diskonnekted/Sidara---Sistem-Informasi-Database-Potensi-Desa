<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Cari produk Slingbag Custom
$slingbag = App\Models\Potential::where('title', 'like', '%Slingbag%')->first();

if ($slingbag) {
    echo '=== PRODUK SLINGBAG CUSTOM ===' . "\n";
    echo 'ID: ' . $slingbag->id . "\n";
    echo 'Judul: ' . $slingbag->title . "\n";
    echo 'Deskripsi: ' . substr($slingbag->description, 0, 100) . '...' . "\n";
    echo 'Harga: ' . $slingbag->price . "\n";
    echo 'Status: ' . $slingbag->status . "\n";
    echo 'Gambar: ' . ($slingbag->image ? $slingbag->image : 'TIDAK ADA GAMBAR') . "\n";
    echo 'Village ID: ' . $slingbag->village_id . "\n";
    
    // Cek desa
    $village = App\Models\Village::find($slingbag->village_id);
    if ($village) {
        echo 'Desa: ' . $village->village_name . ', Kec: ' . $village->district_name . "\n";
    }
    
    // Cek apakah file gambar ada
    if ($slingbag->image) {
        $imagePath = public_path('storage/' . $slingbag->image);
        echo 'Path gambar: ' . $imagePath . "\n";
        echo 'File exists: ' . (file_exists($imagePath) ? 'YA' : 'TIDAK') . "\n";
    }
} else {
    echo 'Produk Slingbag Custom tidak ditemukan!' . "\n";
}

// Cek berapa banyak produk yang ada
$totalProducts = App\Models\Potential::count();
echo '\\n=== TOTAL PRODUK: ' . $totalProducts . ' ===' . "\n";

// Cek produk dengan gambar
$productsWithImages = App\Models\Potential::whereNotNull('image')->count();
echo 'Produk dengan gambar: ' . $productsWithImages . "\n";

// Cek beberapa produk terbaru
$recentProducts = App\Models\Potential::orderBy('id', 'desc')->take(5)->get();
echo '\\n=== 5 PRODUK TERBARU ===' . "\n";
foreach ($recentProducts as $product) {
    echo $product->id . ': ' . $product->title . ' - Gambar: ' . ($product->image ? 'YA' : 'TIDAK') . "\n";
}