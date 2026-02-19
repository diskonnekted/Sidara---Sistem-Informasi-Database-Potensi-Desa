<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== TEST FORM SUBMISSION ===' . "\n\n";

// Cek produk ID 81 (Kelinci Holand Lop)
$product = App\Models\Potential::find(81);

if (!$product) {
    echo '❌ Produk ID 81 tidak ditemukan!' . "\n";
    exit;
}

echo '✅ Produk ditemukan: ' . $product->title . "\n";
echo 'Slug: ' . $product->slug . "\n";
echo 'Gambar: ' . count($product->images ?? []) . "\n\n";

// Test validasi data
$testData = [
    'village_id' => $product->village_id,
    'title' => $product->title . ' TEST',
    'description' => $product->description,
    'verification_status' => 'verified',
    '_token' => csrf_token(),
    '_method' => 'PUT'
];

echo '=== TEST VALIDASI DATA ===' . "\n";

try {
    $request = new Illuminate\Http\Request();
    $request->replace($testData);
    
    $controller = new App\Http\Controllers\Admin\PotentialController();
    $validated = $controller->validateData($request, $product->id);
    
    echo '✅ Validasi berhasil!' . "\n";
    echo 'Data yang akan diupdate:' . "\n";
    print_r($validated);
    
} catch (Illuminate\Validation\ValidationException $e) {
    echo '❌ Validasi gagal:' . "\n";
    foreach ($e->errors() as $field => $errors) {
        echo '   ' . $field . ': ' . implode(', ', $errors) . "\n";
    }
} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
}

// Test handleImages
echo "\n=== TEST HANDLE IMAGES ===\n";

try {
    $request = new Illuminate\Http\Request();
    $images = $controller->handleImages($request, $product);
    
    echo '✅ Handle images berhasil!' . "\n";
    echo 'Jumlah gambar: ' . count($images) . "\n";
    if (!empty($images)) {
        echo 'Gambar: ' . implode(', ', $images) . "\n";
    }
    
} catch (Exception $e) {
    echo '❌ Error handle images: ' . $e->getMessage() . "\n";
}

// Test update method
echo "\n=== TEST UPDATE METHOD ===\n";

try {
    $request = new Illuminate\Http\Request();
    $request->replace(array_merge($testData, ['_token' => csrf_token()]));
    
    // Simulate update
    $data = $controller->validateData($request, $product->id);
    $images = $controller->handleImages($request, $product);
    $data['images'] = $images;
    
    echo '✅ Update simulation berhasil!' . "\n";
    echo 'Data yang akan diupdate:' . "\n";
    print_r($data);
    
} catch (Exception $e) {
    echo '❌ Error update: ' . $e->getMessage() . "\n";
}