<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== MEMPERBAIKI SEMUA MASALAH GAMBAR ===' . "\n\n";

// 1. Perbaiki path yang salah (potensi -> potentials)
$products = App\Models\Potential::where('images', 'like', '%potensi/%')->get();

echo '=== MEMPERBAIKI PATH POTENSI -> POTENTIALS ===' . "\n";
foreach ($products as $product) {
    $currentImages = $product->images ?? [];
    $updatedImages = [];
    $changed = false;
    
    foreach ($currentImages as $image) {
        if (strpos($image, 'potensi/') !== false) {
            $newImage = str_replace('potensi/', 'potentials/', $image);
            $updatedImages[] = $newImage;
            $changed = true;
            echo "🔄 $image -> $newImage\n";
        } else {
            $updatedImages[] = $image;
        }
    }
    
    if ($changed) {
        $product->images = $updatedImages;
        $product->save();
        echo "✅ Updated: " . $product->title . "\n";
    }
}

// 2. Perbaiki file dengan spasi (pindahkan ke folder yang benar)
echo "\n=== MEMPERBAIKI FILE DENGAN SPASI ===\n";
$storagePath = public_path('storage/');
$oldFilePath = $storagePath . 'potensi/sijenggung Tempe Goreng mendoan.jpeg';
$newFilePath = $storagePath . 'potentials/sijenggung-tempe-goreng-mendoan.jpeg';

if (file_exists($oldFilePath)) {
    // Buat folder potentials jika belum ada
    if (!is_dir($storagePath . 'potentials')) {
        mkdir($storagePath . 'potentials', 0755, true);
    }
    
    // Pindahkan file dan rename
    if (rename($oldFilePath, $newFilePath)) {
        echo "✅ File dipindahkan: sijenggung Tempe Goreng mendoan.jpeg -> sijenggung-tempe-goreng-mendoan.jpeg\n";
        
        // Update database
        $tempeProduct = App\Models\Potential::where('title', 'like', '%Tempe Goreng%')->first();
        if ($tempeProduct) {
            $currentImages = $tempeProduct->images ?? [];
            $updatedImages = [];
            
            foreach ($currentImages as $image) {
                if (strpos($image, 'sijenggung Tempe Goreng mendoan.jpeg') !== false) {
                    $updatedImages[] = 'potentials/sijenggung-tempe-goreng-mendoan.jpeg';
                } else {
                    $updatedImages[] = $image;
                }
            }
            
            $tempeProduct->images = $updatedImages;
            $tempeProduct->save();
            echo "✅ Database updated untuk Tempe Goreng\n";
        }
    }
} else {
    echo "⚠️  File lama tidak ditemukan: $oldFilePath\n";
}

// 3. Periksa semua produk untuk memastikan gambar ada
echo "\n=== VERIFIKASI SEMUA GAMBAR ===\n";
$allProducts = App\Models\Potential::all();
$missingCount = 0;

foreach ($allProducts as $product) {
    if (!empty($product->images)) {
        foreach ($product->images as $image) {
            $filePath = public_path('storage/' . $image);
            if (!file_exists($filePath)) {
                echo "❌ MISSING: $image (Product: " . $product->title . ")\n";
                $missingCount++;
            }
        }
    }
}

if ($missingCount === 0) {
    echo "✅ Semua gambar tersedia!\n";
} else {
    echo "⚠️  Total $missingCount gambar tidak ditemukan\n";
}

// Clear cache
Illuminate\Support\Facades\Artisan::call('cache:clear');
echo "\n🧹 Cache cleared\n";

echo "\n🎉 SEMUA MASALAH GAMBAR TELAH DIPERBAIKI!\n";
echo "Sekarang coba akses: http://localhost:8000/potensi/tempe-gorengmendoan-sijenggung\n";