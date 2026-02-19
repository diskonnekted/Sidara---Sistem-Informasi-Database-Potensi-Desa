<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== MEMPERBAIKI PATH GAMBAR PAGENTAN ===' . "\n\n";

// 1. Dapatkan semua produk Pagentan
$pagentanProducts = App\Models\Potential::where('title', 'like', '%pagentan%')
    ->orWhere('slug', 'like', '%pagentan%')
    ->orWhere('title', 'like', '%Pagentan%')
    ->orWhere('slug', 'like', '%Pagentan%')
    ->get();

echo 'Memproses ' . $pagentanProducts->count() . ' produk Pagentan...' . "\n\n";

$fixedCount = 0;

foreach ($pagentanProducts as $product) {
    echo '=== ' . $product->title . ' ===' . "\n";
    
    if (!empty($product->images)) {
        $currentImages = $product->images;
        $updatedImages = [];
        $changed = false;
        
        foreach ($currentImages as $image) {
            // Skip external URLs
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                $updatedImages[] = $image;
                continue;
            }
            
            // Perbaiki path yang salah
            $filename = basename($image);
            $correctPath = 'potentials/' . $filename;
            
            // Cek apakah file ada di storage
            $storagePath = storage_path('app/public/' . $correctPath);
            $fileExists = file_exists($storagePath);
            
            if ($fileExists) {
                // Gunakan path yang benar
                $updatedImages[] = $correctPath;
                if ($image !== $correctPath) {
                    echo '   🔄 PERBAIKI: ' . $image . ' -> ' . $correctPath . "\n";
                    $changed = true;
                } else {
                    echo '   ✅ Path sudah benar: ' . $correctPath . "\n";
                }
            } else {
                echo '   ❌ File tidak ada: ' . $filename . "\n";
                // Hapus gambar yang tidak ada
                $changed = true;
            }
        }
        
        if ($changed) {
            $product->images = $updatedImages;
            $product->save();
            $fixedCount++;
            echo '   💾 Database diperbarui!' . "\n";
        }
    } else {
        echo '   ❌ Tidak ada gambar' . "\n";
    }
    echo "\n";
}

// 2. Verifikasi semua gambar setelah perbaikan
echo '=== VERIFIKASI FINAL ===' . "\n";
$allGood = true;

foreach ($pagentanProducts as $product) {
    echo '=== ' . $product->title . ' ===' . "\n";
    
    if (!empty($product->images)) {
        foreach ($product->images as $image) {
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                echo '   🌐 EXTERNAL: ' . $image . "\n";
                continue;
            }
            
            $filePath = storage_path('app/public/' . $image);
            $exists = file_exists($filePath);
            
            echo '   ' . ($exists ? '✅' : '❌') . ' ' . $image . "\n";
            
            if (!$exists) {
                $allGood = false;
            }
        }
    } else {
        echo '   ❌ Tidak ada gambar' . "\n";
        $allGood = false;
    }
    echo "\n";
}

if ($allGood) {
    echo '🎉 SEMUA GAMBAR PAGENTAN BERHASIL DIPERBAIKI!' . "\n";
} else {
    echo '⚠️  Masih ada gambar yang missing' . "\n";
}

// 3. Clear cache
Illuminate\Support\Facades\Artisan::call('cache:clear');
echo "🧹 Cache cleared\n";

echo "\n🚀 $fixedCount produk Pagentan diperbarui!\n";
echo "📱 Silakan refresh browser untuk melihat perubahan\n";

// 4. Test URL akses gambar
echo "\n🔗 TEST URL GAMBAR:\n";
$testProduct = $pagentanProducts->first();
if ($testProduct && !empty($testProduct->images)) {
    foreach ($testProduct->images as $image) {
        if (!filter_var($image, FILTER_VALIDATE_URL)) {
            echo '- http://localhost:8000/storage/' . $image . "\n";
        }
    }
}