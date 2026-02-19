<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check Gumingsir village
$gumingsir = App\Models\Village::where('village_name', 'Gumingsir')->first();
echo 'Gumingsir: ' . ($gumingsir ? $gumingsir->id : 'Not found') . "\n";

// Check Pagentan village  
$pagentan = App\Models\Village::where('village_name', 'Pagentan')->first();
echo 'Pagentan: ' . ($pagentan ? $pagentan->id : 'Not found') . "\n";

// Check products
if ($gumingsir) {
    echo 'Gumingsir products: ' . App\Models\Potential::where('village_id', $gumingsir->id)->count() . "\n";
}

if ($pagentan) {
    echo 'Pagentan products: ' . App\Models\Potential::where('village_id', $pagentan->id)->count() . "\n";
}

// Check total products
echo 'Total products: ' . App\Models\Potential::count() . "\n";

// Check if districts are available for filter
$districts = App\Models\Village::distinct('district_name')->orderBy('district_name')->pluck('district_name');
echo 'Available districts: ' . $districts->count() . "\n";
if ($districts->count() > 0) {
    echo 'Districts: ' . $districts->implode(', ') . "\n";
}