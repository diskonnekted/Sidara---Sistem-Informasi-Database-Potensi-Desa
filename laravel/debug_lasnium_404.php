<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== DEBUG LASNIUM KREASI 404 ERROR ===' . "\n\n";

// Cari produk dengan slug yang diminta
$slug = 'lasnium-kreasi-pagentan';
$potential = App\Models\Potential::with('village')->where('slug', $slug)->first();

if (!$potential) {
    echo '❌ Produk dengan slug "' . $slug . '" tidak ditemukan!' . "\n";
    
    // Coba cari dengan pendekatan lain
    echo '\\nMencari produk Lasnium Kreasi dengan cara lain...' . "\n";
    $lasnium = App\Models\Potential::where('title', 'like', '%Lasnium Kreasi%')->first();
    
    if ($lasnium) {
        echo '✅ Ditemukan produk: ' . $lasnium->title . "\n";
        echo '   ID: ' . $lasnium->id . "\n";
        echo '   Slug: ' . ($lasnium->slug ?? 'NULL') . "\n";
        echo '   Status: ' . $lasnium->verification_status . "\n";
        
        // Cek apakah slug berbeda
        if ($lasnium->slug !== $slug) {
            echo '   ❌ Slug tidak match! Database: "' . $lasnium->slug . '" vs URL: "' . $slug . '"' . "\n";
        }
    } else {
        echo '❌ Produk Lasnium Kreasi tidak ditemukan sama sekali!' . "\n";
    }
    
} else {
    echo '✅ Produk ditemukan: ' . $potential->title . "\n";
    echo '   ID: ' . $potential->id . "\n";
    echo '   Slug: ' . $potential->slug . "\n";
    echo '   Status: ' . $potential->verification_status . "\n";
    echo '   Desa: ' . ($potential->village->village_name ?? 'NULL') . "\n";
    
    // Cek status verifikasi
    if ($potential->verification_status !== 'verified') {
        echo '   ⚠️  Produk belum diverifikasi! Status: ' . $potential->verification_status . "\n";
    }
}

// Cek juga produk Tempe untuk perbandingan
$tempeSlug = 'tempe-gorengmendoan-sijenggung';
$tempe = App\Models\Potential::with('village')->where('slug', $tempeSlug)->first();

if ($tempe) {
    echo '\\n=== PRODUK TEMPE (SEBAGAI PERBANDINGAN) ===' . "\n";
    echo '✅ Produk: ' . $tempe->title . "\n";
    echo '   ID: ' . $tempe->id . "\n";
    echo '   Slug: ' . $tempe->slug . "\n";
    echo '   Status: ' . $tempe->verification_status . "\n";
    echo '   Desa: ' . ($tempe->village->village_name ?? 'NULL') . "\n";
} else {
    echo '\\n❌ Produk Tempe tidak ditemukan dengan slug: ' . $tempeSlug . "\n";
}