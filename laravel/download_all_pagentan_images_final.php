<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== MENGUNDUH SEMUA GAMBAR PRODUK PAGENTAN ===' . "\n\n";

// Mapping URL gambar ke produk berdasarkan pola nama file
$urlMappings = [
    // URL yang diberikan user
    'https://pagentan-banjarnegara.desa.id/storage-desa?default=images%2F404-image-not-found.jpg&defaultDisk=assets&path=upload%2Fproduk%2FWhatsApp_Image_2021-08-26_at_21_07_31__sid__0Iucs8p.jpeg&signature=9b77fcf7436806d67ce9bf8e0fe427fb4edb2f1766e35fc9d01b414af8970d4c' => 'Klotak',
    'https://pagentan-banjarnegara.desa.id/storage-desa?default=images%2F404-image-not-found.jpg&defaultDisk=assets&path=upload%2Fproduk%2Fb99fe4bbe31b49760b6a38d345ddbfb3__sid__Of85UPa.jpg&signature=127964e5d9cd68b080121346f487d1ea14a77fd2549f20d5fc7306df8f2fbb4b' => 'Sabun Multy Beauty',
    'https://pagentan-banjarnegara.desa.id/storage-desa?default=images%2F404-image-not-found.jpg&defaultDisk=assets&path=upload%2Fproduk%2FWhatsApp_Image_2021-08-26_at_21_26_47__sid__ifH04z3.jpeg&signature=c23081e7924a7f357099a1a1c9c1559ac10c68a3ec98b313cecda4d4a4cbfff1' => 'Skincare NBS',
    'https://pagentan-banjarnegara.desa.id/storage-desa?default=images%2F404-image-not-found.jpg&defaultDisk=assets&path=upload%2Fproduk%2FWhatsApp_Image_2021-08-26_at_21_04_02__sid__MXNdUPV.jpeg&signature=84b49dc72d1da969a4ddeeecee4883f5a45f4d69ceff0a2185db5758c76d5451' => 'Lasnium Kreasi',
    'https://pagentan-banjarnegara.desa.id/storage-desa?default=images%2F404-image-not-found.jpg&defaultDisk=assets&path=upload%2Fproduk%2FWhatsApp_Image_2021-08-26_at_21_04_04__sid__K1qu4CG.jpeg&signature=3fa688ce199640f51b94a28fa84b807d44d193e04e62b9137828e3802a7037e8' => 'Scribble Art',
    'https://pagentan-banjarnegara.desa.id/storage-desa?default=images%2F404-image-not-found.jpg&defaultDisk=assets&path=upload%2Fproduk%2FWhatsApp_Image_2021-08-26_at_19_47_19__sid__RlKHYtA.jpeg&signature=8c2ddf786576199e69c7a8429ff21488ab08111394151af018a972f488a82bec' => 'Astra Motor Pagentan',
    'https://pagentan-banjarnegara.desa.id/storage-desa?default=images%2F404-image-not-found.jpg&defaultDisk=assets&path=upload%2Fproduk%2FWhatsApp_Image_2021-08-26_at_19_47_18__sid__mrGS8cu.jpeg&signature=faef62b903f09d1c13087eed59e7773cf72b777304c2d1b6cc0a47cbcf2bec3e' => 'Astra Motor Pagentan', // mungkin gambar kedua
];

// Cari semua produk dari Desa Pagentan
$pagentanVillage = App\Models\Village::where('village_name', 'Pagentan')->first();

if (!$pagentanVillage) {
    echo '❌ Desa Pagentan tidak ditemukan!' . "\n";
    exit;
}

$products = App\Models\Potential::where('village_id', $pagentanVillage->id)->get();

echo 'Ditemukan ' . $products->count() . ' produk dari Desa Pagentan' . "\n\n";

$successCount = 0;
$totalUrls = count($urlMappings);

echo 'Memproses ' . $totalUrls . ' URL gambar...' . "\n\n";

foreach ($urlMappings as $url => $productNamePattern) {
    echo '🔗 Memproses URL: ' . $url . "\n";
    echo '   Mencocokkan dengan produk: ' . $productNamePattern . "\n";
    
    // Cari produk yang sesuai
    $product = null;
    foreach ($products as $p) {
        if (stripos($p->title, $productNamePattern) !== false) {
            $product = $p;
            break;
        }
    }
    
    if (!$product) {
        echo '   ❌ Produk "' . $productNamePattern . '" tidak ditemukan' . "\n\n";
        continue;
    }
    
    echo '   ✅ Ditemukan: ' . $product->title . ' (ID: ' . $product->id . ')' . "\n";
    
    // Download gambar
    $imageData = @file_get_contents($url);
    
    if ($imageData === false) {
        echo '   ❌ Gagal mengunduh gambar' . "\n\n";
        continue;
    }
    
    echo '   ✅ Berhasil mengunduh (' . strlen($imageData) . ' bytes)' . "\n";
    
    // Simpan gambar
    $fileName = basename(parse_url($url, PHP_URL_PATH));
    $storagePath = 'potentials/' . uniqid() . '_' . $fileName;
    $fullPath = public_path('storage/' . $storagePath);
    
    // Pastikan folder potentials ada
    if (!file_exists(public_path('storage/potentials'))) {
        mkdir(public_path('storage/potentials'), 0755, true);
    }
    
    if (file_put_contents($fullPath, $imageData)) {
        echo '   💾 Disimpan: ' . $storagePath . "\n";
        
        // Update produk dengan gambar baru
        $currentImages = $product->images ?? [];
        if (!is_array($currentImages)) {
            $currentImages = [];
        }
        
        $currentImages[] = $storagePath;
        $product->images = $currentImages;
        $product->save();
        
        echo '   ✅ Produk diperbarui dengan gambar baru!' . "\n";
        echo '   🖼️  Total gambar: ' . count($currentImages) . "\n";
        
        $successCount++;
        
    } else {
        echo '   ❌ Gagal menyimpan gambar' . "\n";
    }
    
    echo "\n";
}

// Clear cache
\Illuminate\Support\Facades\Artisan::call('cache:clear');
echo '✅ Cache cleared' . "\n";

echo '\\n=== HASIL AKHIR ===' . "\n";
echo '✅ Berhasil mengunduh ' . $successCount . ' dari ' . $totalUrls . ' gambar' . "\n";
echo '🎉 Semua gambar produk Pagentan telah diproses!' . "\n";

if ($successCount > 0) {
    echo '\\n📋 Produk yang berhasil diupdate:' . "\n";
    foreach ($products as $product) {
        if (is_array($product->images) && count($product->images) > 0) {
            echo '   - ' . $product->title . ' (' . count($product->images) . ' gambar)' . "\n";
        }
    }
}