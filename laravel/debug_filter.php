<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Simulasikan controller index method
$request = new Illuminate\Http\Request();
$controller = new App\Http\Controllers\Admin\PotentialController();

// Test districts query
$districts = App\Models\Village::distinct('district_name')
    ->orderBy('district_name')
    ->pluck('district_name');

echo 'Districts count: ' . $districts->count() . "\n";
echo 'Districts: ' . $districts->implode(', ') . "\n";

// Test if districts is empty or has issues
if ($districts->count() === 0) {
    echo "ERROR: No districts found in database!\n";
} else {
    echo "Districts query is working correctly\n";
}