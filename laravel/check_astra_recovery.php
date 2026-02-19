<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== CEK STATUS ASTRA MOTOR PAGENTAN ===' . "\n\n";

// 1. Cari produk Astra Motor Pagentan di database
$product = App\Models\Potential::where('title', 'like', '%astra%')
    ->orWhere('slug', 'like', '%astra%')
    ->orWhere('title', 'like', '%Astra%')
    ->orWhere('slug', 'like', '%Astra%')
    ->first();

if ($product) {
    echo '✅ PRODUK DITEMUKAN!' . "\n";
    echo 'ID: ' . $product->id . "\n";
    echo 'Title: ' . $product->title . "\n";
    echo 'Slug: ' . $product->slug . "\n";
    echo 'Status: ' . $product->verification_status . "\n";
    
    if (!empty($product->images)) {
        echo 'Gambar: ' . "\n";
        foreach ($product->images as $index => $image) {
            echo '   ' . ($index + 1) . '. ' . $image . "\n";
        }
    } else {
        echo '❌ Tidak ada gambar' . "\n";
    }
    
    echo "\n🔗 URL: http://localhost:8000/potensi/" . $product->slug . "\n";
    echo "🔗 Admin: http://localhost:8000/admin/potensi/" . $product->id . "/edit\n";
} else {
    echo '❌ PRODUK TIDAK DITEMUKAN!' . "\n";
    echo 'Mari kita cek di soft deleted records...' . "\n";
    
    // Cek apakah model menggunakan SoftDeletes
    if (method_exists('App\Models\Potential', 'withTrashed')) {
        $deletedProduct = App\Models\Potential::withTrashed()
            ->where('title', 'like', '%astra%')
            ->orWhere('slug', 'like', '%astra%')
            ->first();
            
        if ($deletedProduct && $deletedProduct->trashed()) {
            echo '✅ PRODUK DITEMUKAN DI TRASH!' . "\n";
            echo 'ID: ' . $deletedProduct->id . "\n";
            echo 'Title: ' . $deletedProduct->title . "\n";
            echo 'Deleted at: ' . $deletedProduct->deleted_at . "\n";
            echo "\n🚀 Jalankan perintah ini untuk restore:\n";
            echo 'App\Models\Potential::withTrashed()->find(' . $deletedProduct->id . ')->restore();' . "\n";
        } else {
            echo '❌ Produk tidak ditemukan bahkan di trash' . "\n";
            echo 'Mungkin perlu dibuat ulang atau restore dari backup' . "\n";
        }
    } else {
        echo '❌ Model Potential tidak menggunakan SoftDeletes' . "\n";
        echo 'Produk mungkin terhapus permanen' . "\n";
    }
}

// 2. Cek semua produk Pagentan untuk memastikan
echo "\n=== SEMUA PRODUK PAGENTAN ===\n";
$pagentanProducts = App\Models\Potential::where('title', 'like', '%pagentan%')
    ->orWhere('slug', 'like', '%pagentan%')
    ->get();

echo 'Jumlah: ' . $pagentanProducts->count() . "\n";
foreach ($pagentanProducts as $prod) {
    echo '- ' . $prod->title . ' (ID: ' . $prod->id . ', Slug: ' . $prod->slug . ')' . "\n";
}