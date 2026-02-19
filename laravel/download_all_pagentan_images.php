<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Mapping produk Pagentan dengan pola URL yang mungkin
echo '=== MENGUNDUH SEMUA GAMBAR PRODUK PAGENTAN ===' . "\n\n";

$productImageMap = [
    // Produk yang sudah kita ketahui URL-nya
    'Warung Mie Ayam dan Martabak Bang Amir' => 'https://pagentan-banjarnegara.desa.id/storage-desa?default=images%2F404-image-not-found.jpg&defaultDisk=assets&path=upload%2Fproduk%2FWhatsApp_Image_2021-09-05_at_18_45_00__sid__wvc7s3q.jpeg&signature=851a75f6ef9f5476df05d4eb55c0b4160bb89292f61afaa526fdc1cbf9caa153',
    'Kelinci Holand Lop' => 'https://pagentan-banjarnegara.desa.id/storage-desa?default=images%2F404-image-not-found.jpg&defaultDisk=assets&path=upload%2Fproduk%2FWhatsApp_Image_2021-08-31_at_10_20_54__sid__Y8n7yBE.jpeg&signature=91ccff5323be098013f3d94aa1ab8cce7a7409451afe51c09e1d9495554fc4ad',
    
    // Produk lainnya dengan pola yang sama (perlu disesuaikan)
    'Klotak' => 'https://pagentan-banjarnegara.desa.id/storage-desa?default=images%2F404-image-not-found.jpg&defaultDisk=assets&path=upload%2Fproduk%2Fklotak_image.jpg&signature=',
    'Sabun Multy Beauty' => 'https://pagentan-banjarnegara.desa.id/storage-desa?default=images%2F404-image-not-found.jpg&defaultDisk=assets&path=upload%2Fproduk%2Fsabun_multy_image.jpg&signature=',
    'Skincare NBS' => 'https://pagentan-banjarnegara.desa.id/storage-desa?default=images%2F404-image-not-found.jpg&defaultDisk=assets&path=upload%2Fproduk%2Fnbs_image.jpg&signature=',
    'Lasnium Kreasi' => 'https://pagentan-banjarnegara.desa.id/storage-desa?default=images%2F404-image-not-found.jpg&defaultDisk=assets&path=upload%2Fproduk%2Flasnium_image.jpg&signature=',
    'Scribble Art' => 'https://pagentan-banjarnegara.desa.id/storage-desa?default=images%2F404-image-not-found.jpg&defaultDisk=assets&path=upload%2Fproduk%2Fscribble_image.jpg&signature=',
    'Astra Motor Pagentan' => 'https://pagentan-banjarnegara.desa.id/storage-desa?default=images%2F404-image-not-found.jpg&defaultDisk=assets&path=upload%2Fproduk%2Fastra_image.jpg&signature=',
];

// Cari semua produk dari Desa Pagentan
$pagentanVillage = App\Models\Village::where('village_name', 'Pagentan')->first();

if (!$pagentanVillage) {
    echo '❌ Desa Pagentan tidak ditemukan!' . "\n";
    exit;
}

$products = App\Models\Potential::where('village_id', $pagentanVillage->id)->get();

echo 'Ditemukan ' . $products->count() . ' produk dari Desa Pagentan' . "\n\n";

foreach ($products as $product) {
    echo '📦 Memproses: ' . $product->title . "\n";
    echo '   ID: ' . $product->id . "\n";
    
    // Coba cari URL gambar berdasarkan nama produk
    $sourceUrl = null;
    foreach ($productImageMap as $productName => $url) {
        if (stripos($product->title, $productName) !== false) {
            $sourceUrl = $url;
            break;
        }
    }
    
    if (!$sourceUrl) {
        echo '   ❌ URL sumber tidak ditemukan untuk produk ini' . "\n\n";
        continue;
    }
    
    echo '   🔗 URL: ' . $sourceUrl . "\n";
    
    // Download gambar
    $imageData = @file_get_contents($sourceUrl);
    
    if ($imageData === false) {
        echo '   ❌ Gagal mengunduh gambar' . "\n\n";
        continue;
    }
    
    echo '   ✅ Berhasil mengunduh (' . strlen($imageData) . ' bytes)' . "\n";
    
    // Simpan gambar
    $storagePath = 'potentials/' . uniqid() . '_' . strtolower(str_replace(' ', '_', $productName)) . '.jpg';
    $fullPath = public_path('storage/' . $storagePath);
    
    // Pastikan folder potentials ada
    if (!file_exists(public_path('storage/potentials'))) {
        mkdir(public_path('storage/potentials'), 0755, true);
    }
    
    if (file_put_contents($fullPath, $imageData)) {
        echo '   💾 Disimpan: ' . $storagePath . "\n";
        
        // Update produk dengan gambar baru
        $currentImages = $product->images ?? [];
        if (!is_array($currentImages)) {
            $currentImages = [];
        }
        
        $currentImages[] = $storagePath;
        $product->images = $currentImages;
        $product->save();
        
        echo '   ✅ Produk diperbarui dengan gambar baru!' . "\n";
        echo '   🖼️  Total gambar: ' . count($currentImages) . "\n";
        
    } else {
        echo '   ❌ Gagal menyimpan gambar' . "\n";
    }
    
    echo "\n";
}

// Clear cache
\Illuminate\Support\Facades\Artisan::call('cache:clear');
echo '✅ Cache cleared' . "\n";

echo '\\n=== SELESAI ===' . "\n";
echo 'Semua gambar produk Pagentan telah diproses!' . "\n";