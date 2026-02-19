<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Cek struktur tabel potentials
$columns = \Illuminate\Support\Facades\DB::select('DESCRIBE potentials');

echo '=== STRUKTUR TABEL POTENTIALS ===' . "\n";
foreach ($columns as $column) {
    echo $column->Field . ' | ' . $column->Type . ' | ' . ($column->Null === 'YES' ? 'NULL' : 'NOT NULL') . "\n";
}

// Cek apakah ada kolom untuk gambar
echo '\\n=== CEK KOLOM GAMBAR ===' . "\n";
$hasImageColumn = false;
foreach ($columns as $column) {
    if (in_array($column->Field, ['image', 'gambar', 'photo', 'foto'])) {
        echo '✅ Ditemukan kolom gambar: ' . $column->Field . "\n";
        $hasImageColumn = true;
        break;
    }
}

if (!$hasImageColumn) {
    echo '❌ TIDAK ADA kolom untuk gambar! Perlu migration.' . "\n";
}

// Cek source_meta untuk kemungkinan gambar disimpan di JSON
echo '\\n=== CEK SOURCE_META UNTUK GAMBAR ===' . "\n";
$slingbag = App\Models\Potential::find(79);
if ($slingbag && $slingbag->source_meta) {
    $meta = json_decode($slingbag->source_meta, true);
    echo 'Source Meta: ' . print_r($meta, true) . "\n";
    
    if (isset($meta['image']) || isset($meta['gambar'])) {
        echo '✅ Gambar mungkin disimpan di source_meta!' . "\n";
    }
} else {
    echo '❌ Tidak ada source_meta atau produk tidak ditemukan' . "\n";
}