<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== MEMBUAT ULANG ASTRA MOTOR PAGENTAN ===' . "\n\n";

// 1. Cari desa Pagentan
$pagentanVillage = App\Models\Village::where('village_name', 'like', '%pagentan%')->first();

if (!$pagentanVillage) {
    echo '❌ Desa Pagentan tidak ditemukan!' . "\n";
    exit;
}

echo 'Desa Pagentan ditemukan: ' . $pagentanVillage->village_name . ' (ID: ' . $pagentanVillage->id . ')' . "\n";

// 2. Data untuk Astra Motor Pagentan
$astraData = [
    'village_id' => $pagentanVillage->id,
    'title' => 'Astra Motor Pagentan',
    'slug' => 'astra-motor-pagentan',
    'description' => 'Bengkel resmi Astra Motor yang melayani service dan penjualan sparepart motor Honda di Pagentan. Teknisi berpengalaman dan menggunakan suku cadang original.',
    'whatsapp_number' => '628123456789',
    'location_address' => 'Jl. Raya Pagentan, Kec. Pagentan',
    'price_range' => 'Rp 50.000 - Rp 500.000',
    'latitude' => -7.4531,
    'longitude' => 109.7044,
    'verification_status' => 'verified',
    'source' => 'manual',
    'images' => [
        'potentials/6996a3a8e54e4_storage-desa.jpg',
        'potentials/6996a3a9409b7_storage-desa.jpg'
    ]
];

// 3. Cek apakah slug sudah ada
$existing = App\Models\Potential::where('slug', $astraData['slug'])->first();
if ($existing) {
    echo '❌ Produk dengan slug "' . $astraData['slug'] . '" sudah ada! (ID: ' . $existing->id . ')' . "\n";
    exit;
}

// 4. Buat produk baru
try {
    $newProduct = App\Models\Potential::create($astraData);
    
    echo '✅ PRODUK BERHASIL DIBUAT ULANG!' . "\n";
    echo 'ID: ' . $newProduct->id . "\n";
    echo 'Title: ' . $newProduct->title . "\n";
    echo 'Slug: ' . $newProduct->slug . "\n";
    echo 'Gambar: ' . count($newProduct->images) . ' foto' . "\n";
    
    echo "\n🔗 URL Publik: http://localhost:8000/potensi/" . $newProduct->slug . "\n";
    echo "🔗 Admin Edit: http://localhost:8000/admin/potensi/" . $newProduct->id . "/edit\n";
    
    // 5. Verifikasi file gambar
    echo "\n=== VERIFIKASI GAMBAR ===\n";
    foreach ($newProduct->images as $index => $image) {
        $filePath = storage_path('app/public/' . $image);
        $exists = file_exists($filePath);
        echo '   ' . ($exists ? '✅' : '❌') . ' ' . $image . "\n";
        if ($exists) {
            echo '      📏 Size: ' . filesize($filePath) . ' bytes' . "\n";
            echo '      🔗 URL: http://localhost:8000/storage/' . $image . "\n";
        }
    }
    
} catch (Exception $e) {
    echo '❌ GAGAL MEMBUAT PRODUK: ' . $e->getMessage() . "\n";
}

// 6. Update count produk Pagentan
echo "\n=== TOTAL PRODUK PAGENTAN SEKARANG ===\n";
$pagentanCount = App\Models\Potential::where('village_id', $pagentanVillage->id)->count();
echo 'Jumlah: ' . $pagentanCount . "\n";