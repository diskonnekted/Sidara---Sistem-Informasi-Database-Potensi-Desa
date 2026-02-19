<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== CEK GAMBAR DESA PAGENTAN ===' . "\n\n";

// 1. Cari semua produk dari desa Pagentan
$pagentanProducts = App\Models\Potential::where('village', 'like', '%pagentan%')->orWhere('village', 'like', '%Pagentan%')->get();

echo 'JUMLAH PRODUK PAGENTAN: ' . $pagentanProducts->count() . "\n\n";

$missingImages = [];

foreach ($pagentanProducts as $product) {
    echo '=== ' . $product->title . ' ===' . "\n";
    echo 'Desa: ' . ($product->village ?? 'NULL') . "\n";
    echo 'Slug: ' . $product->slug . "\n";
    
    if (!empty($product->images)) {
        echo 'Gambar: ' . "\n";
        foreach ($product->images as $image) {
            // Skip external URLs
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                echo '   🌐 EXTERNAL: ' . $image . "\n";
                continue;
            }
            
            $filePath = storage_path('app/public/' . $image);
            $exists = file_exists($filePath);
            
            echo '   ' . ($exists ? '✅' : '❌') . ' ' . $image . "\n";
            
            if (!$exists) {
                $missingImages[] = [
                    'product' => $product->title,
                    'image' => $image,
                    'path' => $filePath
                ];
            }
        }
    } else {
        echo '❌ TIDAK ADA GAMBAR' . "\n";
    }
    echo "\n";
}

// 2. Tampilkan gambar yang missing
echo '=== GAMBAR YANG MASIH MISSING ===' . "\n";
if (!empty($missingImages)) {
    foreach ($missingImages as $missing) {
        echo '❌ ' . $missing['product'] . "\n";
        echo '   Gambar: ' . $missing['image'] . "\n";
        echo '   Path: ' . $missing['path'] . "\n";
        
        // Coba cari file dengan nama yang mirip
        $imageDir = dirname($missing['path']);
        if (is_dir($imageDir)) {
            $files = scandir($imageDir);
            $similarFiles = [];
            
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && stripos($file, pathinfo($missing['image'], PATHINFO_FILENAME)) !== false) {
                    $similarFiles[] = $file;
                }
            }
            
            if (!empty($similarFiles)) {
                echo '   📂 File serupa ditemukan: ' . implode(', ', $similarFiles) . "\n";
            }
        }
        echo "\n";
    }
} else {
    echo '✅ SEMUA GAMBAR PAGENTAN ADA!' . "\n";
}

// 3. Cek folder potentials untuk file Pagentan
echo '=== FILE PAGENTAN DI FOLDER STORAGE ===' . "\n";
$storagePath = storage_path('app/public/potentials/');
if (is_dir($storagePath)) {
    $files = scandir($storagePath);
    $pagentanFiles = [];
    
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..' && stripos($file, 'pagentan') !== false) {
            $pagentanFiles[] = $file;
        }
    }
    
    if (!empty($pagentanFiles)) {
        echo 'File Pagentan ditemukan:' . "\n";
        foreach ($pagentanFiles as $file) {
            echo '   📄 ' . $file . "\n";
        }
    } else {
        echo '❌ TIDAK ADA FILE PAGENTAN DI FOLDER' . "\n";
    }
} else {
    echo '❌ FOLDER POTENTIALS TIDAK ADA' . "\n";
}

// 4. Rekomendasi
echo "\n=== REKOMENDASI ===\n";
if (!empty($missingImages)) {
    echo '⚠️  Beberapa gambar Pagentan masih missing\n';
    echo '💡 Solusi:\n';
    echo '1. Upload manual gambar ke folder: ' . $storagePath . "\n";
    echo '2. Update database dengan nama file yang benar\n';
    echo '3. Atau gunakan URL external untuk gambar yang missing\n';
} else {
    echo '✅ Semua gambar Pagentan sudah tersedia!\n';
    echo '🚀 Coba akses produk Pagentan melalui browser\n';
}