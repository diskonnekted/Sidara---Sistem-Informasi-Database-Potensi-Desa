<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== MEMPERBAIKI GAMBAR PAGENTAN ===' . "\n\n";

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
            // Hapus gambar lama yang tidak ada (pagentan-*.jpg)
            if (strpos($image, 'pagentan-') === 0 && strpos($image, '.jpg') !== false) {
                $filePath = storage_path('app/public/potentials/' . $image);
                if (!file_exists($filePath)) {
                    echo '   🗑️  HAPUS: ' . $image . ' (file tidak ada)' . "\n";
                    $changed = true;
                    continue; // Skip gambar ini
                }
            }
            
            $updatedImages[] = $image;
        }
        
        if ($changed) {
            $product->images = $updatedImages;
            $product->save();
            $fixedCount++;
            echo '   ✅ Database diperbarui!' . "\n";
        } else {
            echo '   ✅ Sudah benar' . "\n";
        }
        
        // Tampilkan gambar yang tersisa
        echo '   Gambar aktif: ' . "\n";
        foreach ($updatedImages as $image) {
            $filePath = storage_path('app/public/potentials/' . $image);
            $exists = file_exists($filePath);
            echo '      ' . ($exists ? '✅' : '❌') . ' ' . $image . "\n";
        }
    }
    echo "\n";
}

// 2. Verifikasi semua gambar Pagentan setelah perbaikan
echo '=== VERIFIKASI SETELAH PERBAIKAN ===' . "\n";
$allGood = true;

foreach ($pagentanProducts as $product) {
    if (!empty($product->images)) {
        foreach ($product->images as $image) {
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                continue; // Skip external URLs
            }
            
            $filePath = storage_path('app/public/potentials/' . $image);
            if (!file_exists($filePath)) {
                echo '❌ ' . $product->title . ': ' . $image . ' masih missing' . "\n";
                $allGood = false;
            }
        }
    }
}

if ($allGood) {
    echo '✅ SEMUA GAMBAR PAGENTAN VALID!' . "\n";
} else {
    echo '⚠️  Beberapa gambar masih missing' . "\n";
}

// 3. Clear cache
Illuminate\Support\Facades\Artisan::call('cache:clear');
echo "\n🧹 Cache cleared\n";

echo "\n🎉 $fixedCount produk Pagentan diperbarui!\n";
echo "🚀 Silakan refresh halaman produk Pagentan di browser\n";

// 4. Contoh URL produk Pagentan yang bisa diakses
echo "\n🔗 CONTOH URL PRODUK PAGENTAN:\n";
foreach ($pagentanProducts as $product) {
    echo '- http://localhost:8000/potensi/' . $product->slug . "\n";
}