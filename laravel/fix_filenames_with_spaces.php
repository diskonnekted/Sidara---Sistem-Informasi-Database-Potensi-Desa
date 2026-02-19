<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== MEMPERBAIKI NAMA FILE DENGAN SPASI ===' . "\n\n";

// 1. Cari semua file dengan spasi di folder potentials
$storagePath = public_path('storage/potentials/');
$files = scandir($storagePath);
$renamedCount = 0;

echo '=== FILE DENGAN SPASI YANG DITEMUKAN ===' . "\n";

foreach ($files as $file) {
    if ($file !== '.' && $file !== '..' && strpos($file, ' ') !== false) {
        echo "⚠️  Found: $file\n";
        
        // Ganti spasi dengan dash
        $newFilename = str_replace(' ', '-', $file);
        $oldFilePath = $storagePath . $file;
        $newFilePath = $storagePath . $newFilename;
        
        if (rename($oldFilePath, $newFilePath)) {
            echo "✅ Renamed: $file -> $newFilename\n";
            $renamedCount++;
            
            // Update database untuk semua produk yang menggunakan file ini
            $products = App\Models\Potential::where('images', 'like', '%' . $file . '%')->get();
            
            foreach ($products as $product) {
                $currentImages = $product->images ?? [];
                $updatedImages = [];
                $changed = false;
                
                foreach ($currentImages as $image) {
                    if (strpos($image, $file) !== false) {
                        $newImage = str_replace($file, $newFilename, $image);
                        $updatedImages[] = $newImage;
                        $changed = true;
                        echo "   🔄 Database: $image -> $newImage\n";
                    } else {
                        $updatedImages[] = $image;
                    }
                }
                
                if ($changed) {
                    $product->images = $updatedImages;
                    $product->save();
                    echo "   ✅ Updated product: " . $product->title . "\n";
                }
            }
        } else {
            echo "❌ Failed to rename: $file\n";
        }
        echo "\n";
    }
}

if ($renamedCount === 0) {
    echo "✅ Tidak ada file dengan spasi yang ditemukan\n";
} else {
    echo "🎉 $renamedCount file berhasil di-rename!\n";
}

// 2. Periksa file khusus yang disebutkan dalam error
echo "\n=== VERIFIKASI FILE YANG ERROR ===\n";
$problemFiles = [
    'sijenggung Tempe Goreng mendoan.jpeg',
    'pagentan-astra-motor.jpg'
];

foreach ($problemFiles as $filename) {
    $filePath = $storagePath . $filename;
    $fileExists = file_exists($filePath);
    
    echo "File: $filename\n";
    echo "Exists: " . ($fileExists ? '✅ YES' : '❌ NO') . "\n";
    
    if (!$fileExists) {
        // Cari file dengan nama yang mirip
        $similarFiles = [];
        foreach ($files as $f) {
            if ($f !== '.' && $f !== '..' && stripos($f, $filename) !== false) {
                $similarFiles[] = $f;
            }
        }
        
        if (!empty($similarFiles)) {
            echo "Similar files found: " . implode(', ', $similarFiles) . "\n";
        }
    }
    echo "\n";
}

// 3. Periksa file pagentan-astra-motor.jpg khusus
echo "=== CEK FILE PAGENTAN-ASTRA-MOTOR.JPG ===\n";
$astraFile = $storagePath . 'pagentan-astra-motor.jpg';
if (file_exists($astraFile)) {
    echo "✅ File exists: pagentan-astra-motor.jpg\n";
    echo "Size: " . filesize($astraFile) . " bytes\n";
} else {
    echo "❌ File NOT found: pagentan-astra-motor.jpg\n";
    
    // Cari file Astra Motor yang sebenarnya ada
    $astraFiles = [];
    foreach ($files as $f) {
        if ($f !== '.' && $f !== '..' && stripos($f, 'astra') !== false) {
            $astraFiles[] = $f;
        }
    }
    
    if (!empty($astraFiles)) {
        echo "Found Astra files: " . implode(', ', $astraFiles) . "\n";
    }
}

// Clear cache
Illuminate\Support\Facades\Artisan::call('cache:clear');
echo "\n🧹 Cache cleared\n";

echo "\n🚀 SILAKAN COBA AKSES LAGI!\n";
echo "Contoh: http://localhost:8000/storage/potentials/sijenggung-Tempe-Goreng-mendoan.jpeg\n";