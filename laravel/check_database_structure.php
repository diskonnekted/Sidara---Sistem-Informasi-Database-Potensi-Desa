<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== CEK STRUKTUR DATABASE ===' . "\n\n";

// 1. Cek kolom yang ada di tabel potentials
$columns = Illuminate\Support\Facades\DB::select('SHOW COLUMNS FROM potentials');

echo 'KOLOM DI TABEL POTENTIALS:' . "\n";
foreach ($columns as $column) {
    echo '- ' . $column->Field . ' (' . $column->Type . ')' . "\n";
}

// 2. Cari produk Pagentan berdasarkan nama atau slug
echo "\n=== PRODUK PAGENTAN ===\n";
$pagentanProducts = App\Models\Potential::where('title', 'like', '%pagentan%')
    ->orWhere('slug', 'like', '%pagentan%')
    ->orWhere('title', 'like', '%Pagentan%')
    ->orWhere('slug', 'like', '%Pagentan%')
    ->get();

echo 'JUMLAH PRODUK PAGENTAN: ' . $pagentanProducts->count() . "\n\n";

foreach ($pagentanProducts as $product) {
    echo '=== ' . $product->title . ' ===' . "\n";
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
        }
    } else {
        echo '❌ TIDAK ADA GAMBAR' . "\n";
    }
    echo "\n";
}

// 3. Cek file di folder storage untuk Pagentan
echo '=== FILE PAGENTAN DI STORAGE ===' . "\n";
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
            $filePath = $storagePath . $file;
            echo '   📄 ' . $file . ' (' . filesize($filePath) . ' bytes)' . "\n";
        }
    } else {
        echo '❌ TIDAK ADA FILE PAGENTAN' . "\n";
        
        // Tampilkan semua file untuk referensi
        echo 'Semua file di folder potentials:' . "\n";
        $count = 0;
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                echo '   - ' . $file . "\n";
                $count++;
                if ($count >= 10) {
                    echo '   ... dan ' . (count($files) - 12) . ' file lainnya\n';
                    break;
                }
            }
        }
    }
} else {
    echo '❌ FOLDER POTENTIALS TIDAK ADA' . "\n";
}