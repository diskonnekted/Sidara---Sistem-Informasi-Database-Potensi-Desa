<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Cek file gambar untuk Slingbag Custom
$slingbag = App\Models\Potential::find(79);

echo '=== CEK FILE GAMBAR SLINGBAG CUSTOM ===' . "\n";

if ($slingbag && !empty($slingbag->images)) {
    $images = $slingbag->images;
    
    if (is_array($images)) {
        foreach ($images as $index => $imagePath) {
            echo 'Gambar ' . ($index + 1) . ': ' . $imagePath . "\n";
            
            // Cek di public/storage/
            $fullPath = public_path('storage/' . $imagePath);
            echo 'Lokasi: ' . $fullPath . "\n";
            echo 'File exists: ' . (file_exists($fullPath) ? '✅ YA' : '❌ TIDAK') . "\n";
            
            // Cek juga di public/ jika mungkin
            $publicPath = public_path($imagePath);
            if (file_exists($publicPath) && $publicPath !== $fullPath) {
                echo 'Juga ada di: ' . $publicPath . ' ✅' . "\n";
            }
            
            echo "---\n";
        }
    }
} else {
    echo 'Tidak ada gambar untuk produk ini' . "\n";
}

// Cek struktur folder storage
echo '\\n=== CEK STRUKTUR FOLDER STORAGE ===' . "\n";
$storagePath = public_path('storage');
echo 'Storage path: ' . $storagePath . "\n";
echo 'Storage exists: ' . (file_exists($storagePath) ? '✅ YA' : '❌ TIDAK') . "\n";

if (file_exists($storagePath)) {
    // Cek folder potentials
    $potentialsPath = public_path('storage/potentials');
    echo 'Potentials folder: ' . $potentialsPath . "\n";
    echo 'Potentials exists: ' . (file_exists($potentialsPath) ? '✅ YA' : '❌ TIDAK') . "\n";
    
    // List beberapa file di storage
    echo '\\nBeberapa file di storage:' . "\n";
    $files = glob(public_path('storage/*.{jpg,png,gif}'), GLOB_BRACE);
    $fileCount = count($files);
    echo 'Jumlah file gambar: ' . $fileCount . "\n";
    
    if ($fileCount > 0) {
        for ($i = 0; $i < min(5, $fileCount); $i++) {
            echo basename($files[$i]) . "\n";
        }
        if ($fileCount > 5) echo '... dan ' . ($fileCount - 5) . ' lebih' . "\n";
    }
}