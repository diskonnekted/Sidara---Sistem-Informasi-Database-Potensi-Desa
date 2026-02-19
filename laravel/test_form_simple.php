<?php
// Test sederhana untuk form submission
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\PotentialController;

// Test validasi data
$controller = new PotentialController();
$request = new Request([
    'village_id' => 1,
    'title' => 'Test Product',
    'description' => 'Test description',
    'verification_status' => 'pending'
]);

try {
    $data = $controller->validateData($request);
    echo "✅ Validasi berhasil!\n";
    print_r($data);
} catch (Exception $e) {
    echo "❌ Validasi gagal: " . $e->getMessage() . "\n";
}

// Test handleImages
$files = [];
try {
    $result = $controller->handleImages($request);
    echo "✅ Handle images berhasil!\n";
    print_r($result);
} catch (Exception $e) {
    echo "❌ Handle images gagal: " . $e->getMessage() . "\n";
}
?>