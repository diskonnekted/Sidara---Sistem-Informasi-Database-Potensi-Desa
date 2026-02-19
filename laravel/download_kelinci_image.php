<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// URL sumber gambar kelinci
$sourceUrl = 'https://pagentan-banjarnegara.desa.id/storage-desa?default=images%2F404-image-not-found.jpg&defaultDisk=assets&path=upload%2Fproduk%2FWhatsApp_Image_2021-08-31_at_10_20_54__sid__Y8n7yBE.jpeg&signature=91ccff5323be098013f3d94aa1ab8cce7a7409451afe51c09e1d9495554fc4ad';

// Cari produk Kelinci Holand Lop
$product = App\Models\Potential::where('title', 'like', '%Kelinci%')->orWhere('title', 'like', '%Holand Lop%')->first();

if (!$product) {
    echo '❌ Produk Kelinci Holand Lop tidak ditemukan!' . "\n";
    exit;
}

echo '=== MENGUNDUH GAMBAR UNTUK PRODUK KELINCI ===' . "\n";
echo 'Produk: ' . $product->title . "\n";
echo 'ID: ' . $product->id . "\n";
echo 'URL Sumber: ' . $sourceUrl . "\n\n";

// Download gambar
$imageData = @file_get_contents($sourceUrl);

if ($imageData === false) {
    echo '❌ Gagal mengunduh gambar dari URL sumber' . "\n";
    exit;
}

echo '✅ Berhasil mengunduh gambar (' . strlen($imageData) . ' bytes)' . "\n";

// Simpan gambar ke storage
$storagePath = 'potentials/' . uniqid() . '_kelinci_holand_lop.jpg';
$fullPath = public_path('storage/' . $storagePath);

// Pastikan folder potentials ada
if (!file_exists(public_path('storage/potentials'))) {
    mkdir(public_path('storage/potentials'), 0755, true);
}

// Simpan file
if (file_put_contents($fullPath, $imageData)) {
    echo '✅ Gambar berhasil disimpan: ' . $storagePath . "\n";
    echo 'Lokasi: ' . $fullPath . "\n";
    
    // Update produk dengan gambar baru
    $currentImages = $product->images ?? [];
    if (!is_array($currentImages)) {
        $currentImages = [];
    }
    
    // Tambahkan gambar baru ke array
    $currentImages[] = $storagePath;
    $product->images = $currentImages;
    $product->save();
    
    echo '✅ Produk berhasil diperbarui dengan gambar baru!' . "\n";
    echo 'Gambar sekarang: ' . print_r($currentImages, true) . "\n";
    
} else {
    echo '❌ Gagal menyimpan gambar' . "\n";
}

// Verifikasi file
echo '\\n=== VERIFIKASI ===' . "\n";
echo 'File exists: ' . (file_exists($fullPath) ? '✅ YA' : '❌ TIDAK') . "\n";
echo 'File size: ' . filesize($fullPath) . ' bytes' . "\n";

// Clear cache
\Illuminate\Support\Facades\Artisan::call('cache:clear');
echo '✅ Cache cleared' . "\n";