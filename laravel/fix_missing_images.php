<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== MEMPERBAIKI GAMBAR YANG HILANG ===' . "\n\n";

// 1. Perbaiki semua path dari potensi/ ke potentials/
$products = App\Models\Potential::all();
$fixedCount = 0;

echo '=== MEMPERBAIKI PATH GAMBAR ===' . "\n";

foreach ($products as $product) {
    if (!empty($product->images)) {
        $currentImages = $product->images;
        $updatedImages = [];
        $changed = false;
        
        foreach ($currentImages as $image) {
            // Perbaiki path potensi/ -> potentials/
            if (strpos($image, 'potensi/') !== false) {
                $newImage = str_replace('potensi/', 'potentials/', $image);
                $updatedImages[] = $newImage;
                $changed = true;
                echo "🔄 $image -> $newImage\n";
            } 
            // Perbaiki path tanpa folder (tambahkan potentials/)
            elseif (!str_contains($image, '/') && !filter_var($image, FILTER_VALIDATE_URL)) {
                $newImage = 'potentials/' . $image;
                $updatedImages[] = $newImage;
                $changed = true;
                echo "🔄 $image -> $newImage\n";
            }
            else {
                $updatedImages[] = $image;
            }
        }
        
        if ($changed) {
            $product->images = $updatedImages;
            $product->save();
            $fixedCount++;
            echo "✅ Updated: " . $product->title . "\n";
        }
    }
}

echo "\\n✅ $fixedCount produk diperbarui!\n";

// 2. Pindahkan file dari public/potensi/ ke public/storage/potentials/
echo "\\n=== MEMINDAHKAN FILE GAMBAR ===\n";
$sourceDir = public_path('potensi/');
$targetDir = public_path('storage/potentials/');

// Pastikan folder target ada
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

if (is_dir($sourceDir)) {
    $files = scandir($sourceDir);
    $movedCount = 0;
    
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $sourceFile = $sourceDir . $file;
            $targetFile = $targetDir . $file;
            
            if (file_exists($sourceFile) && is_file($sourceFile)) {
                if (rename($sourceFile, $targetFile)) {
                    echo "✅ Dipindahkan: $file\n";
                    $movedCount++;
                } else {
                    echo "❌ Gagal memindahkan: $file\n";
                }
            }
        }
    }
    
    echo "\\n✅ $movedCount file dipindahkan dari potensi/ ke storage/potentials/\n";
} else {
    echo "⚠️  Folder source potensi/ tidak ditemukan\n";
}

// 3. Verifikasi kembali
echo "\\n=== VERIFIKASI SETELAH PERBAIKAN ===\n";
$allProducts = App\Models\Potential::all();
$missingCount = 0;

foreach ($allProducts as $product) {
    if (!empty($product->images)) {
        foreach ($product->images as $image) {
            // Skip external URLs
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                continue;
            }
            
            $filePath = public_path('storage/' . $image);
            if (!file_exists($filePath)) {
                echo "❌ MASIH HILANG: $image (" . $product->title . ")\n";
                $missingCount++;
            }
        }
    }
}

if ($missingCount === 0) {
    echo "🎉 SEMUA GAMBAR LOKAL TERSEDIA!\n";
} else {
    echo "⚠️  Masih ada $missingCount gambar yang hilang\n";
}

// Clear cache
Illuminate\Support\Facades\Artisan::call('cache:clear');
echo "\\n🧹 Cache cleared\n";

echo "\\n🚀 SILAKAN COBA AKSES PRODUK LAGI!\n";
echo "Contoh: http://localhost:8000/potensi/tempe-gorengmendoan-sijenggung\n";