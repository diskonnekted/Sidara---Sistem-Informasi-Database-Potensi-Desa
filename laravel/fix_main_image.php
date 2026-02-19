<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Perbaiki gambar utama Slingbag Custom
$slingbag = App\Models\Potential::find(79);

echo '=== MEMPERBAIKI GAMBAR UTAMA SLINGBAG CUSTOM ===' . "\n";

if ($slingbag && !empty($slingbag->images)) {
    $images = $slingbag->images;
    
    // Hapus referensi gambar utama yang tidak ada
    if (is_array($images)) {
        $newImages = array();
        
        foreach ($images as $imagePath) {
            $fullPath = public_path('storage/' . $imagePath);
            
            // Hanya simpan gambar yang benar-benar ada
            if (file_exists($fullPath)) {
                $newImages[] = $imagePath;
                echo '✓ Menyimpan gambar: ' . $imagePath . "\n";
            } else {
                echo '✗ Menghapus gambar tidak ada: ' . $imagePath . "\n";
            }
        }
        
        // Jika tidak ada gambar sama sekali, tambahkan default
        if (empty($newImages)) {
            $newImages = ['default-product.jpg'];
            echo '⚠ Menambahkan gambar default' . "\n";
        }
        
        // Update images array
        $slingbag->images = $newImages;
        $slingbag->save();
        
        echo '\\n✅ DATA TELAH DIPERBAIKI!' . "\n";
        echo 'Gambar yang tersedia sekarang: ' . print_r($newImages, true) . "\n";
        echo 'Jumlah gambar: ' . count($newImages) . "\n";
        
    }
} else {
    echo 'Tidak dapat memperbaiki - produk atau gambar tidak ditemukan' . "\n";
}

// Clear cache untuk memastikan perubahan terlihat
echo '\\n=== MEMBERSIHKAN CACHE ===' . "\n";
try {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    echo '✓ Cache cleared' . "\n";
    
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    echo '✓ View cache cleared' . "\n";
    
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    echo '✓ Config cache cleared' . "\n";
    
} catch (Exception $e) {
    echo '⚠ Error clearing cache: ' . $e->getMessage() . "\n";
}