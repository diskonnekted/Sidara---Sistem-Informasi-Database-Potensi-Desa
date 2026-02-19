<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== MEMPERBAIKI NAMA FILE GAMBAR ===' . "\n\n";

// Daftar file yang perlu diperbaiki
$filesToFix = [
    '6996a3a73d221_storage-desa',
    '6996a3a785ff4_storage-desa', 
    '6996a3a7c9ba3_storage-desa',
    '6996a3a837bd1_storage-desa',
    '6996a3a898055_storage-desa',
    '6996a3a8e54e4_storage-desa',
    '6996a3a9409b7_storage-desa'
];

$storagePath = public_path('storage/potentials/');
$fixedCount = 0;

foreach ($filesToFix as $filename) {
    $filePath = $storagePath . $filename;
    
    // Cek jika file ada
    if (file_exists($filePath)) {
        // Deteksi tipe MIME untuk menentukan ekstensi yang benar
        $mime = mime_content_type($filePath);
        $extension = '';
        
        switch ($mime) {
            case 'image/jpeg':
                $extension = '.jpg';
                break;
            case 'image/png':
                $extension = '.png';
                break;
            case 'image/webp':
                $extension = '.webp';
                break;
            default:
                $extension = '.jpg'; // default ke jpg
        }
        
        $newFilename = $filename . $extension;
        $newFilePath = $storagePath . $newFilename;
        
        // Rename file
        if (rename($filePath, $newFilePath)) {
            echo "✅ Berhasil memperbaiki: $filename -> $newFilename ($mime)" . "\n";
            $fixedCount++;
            
            // Update database untuk mengganti referensi file
            $products = App\Models\Potential::where('images', 'like', '%' . $filename . '%')->get();
            foreach ($products as $product) {
                $currentImages = $product->images ?? [];
                $updatedImages = [];
                
                foreach ($currentImages as $image) {
                    if (strpos($image, $filename) !== false) {
                        $updatedImages[] = str_replace($filename, $newFilename, $image);
                    } else {
                        $updatedImages[] = $image;
                    }
                }
                
                $product->images = $updatedImages;
                $product->save();
                echo "   📦 Updated product: " . $product->title . "\n";
            }
        } else {
            echo "❌ Gagal memperbaiki: $filename" . "\n";
        }
    } else {
        echo "⚠️  File tidak ditemukan: $filename" . "\n";
    }
}

echo "\n🎉 Selesai! $fixedCount file berhasil diperbaiki." . "\n";

// Clear cache
Illuminate\Support\Facades\Artisan::call('cache:clear');
echo "🧹 Cache cleared" . "\n";