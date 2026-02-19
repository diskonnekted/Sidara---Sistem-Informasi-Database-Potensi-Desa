<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== DEBUG STORAGE ACCESS ===' . "\n\n";

// 1. Periksa file di filesystem
$filename = 'sijenggung-Tempe-Goreng-mendoan.jpeg';
$storagePath = public_path('storage/potentials/');
$filePath = $storagePath . $filename;

echo 'File: ' . $filename . "\n";
echo 'Full path: ' . $filePath . "\n";
echo 'File exists: ' . (file_exists($filePath) ? '✅ YES' : '❌ NO') . "\n";

if (file_exists($filePath)) {
    echo 'File size: ' . filesize($filePath) . " bytes\n";
    echo 'File permissions: ' . substr(sprintf('%o', fileperms($filePath)), -4) . "\n";
}

// 2. Periksa symlink storage
echo "\n=== STORAGE SYMLINK CHECK ===\n";
$symlinkPath = public_path('storage');
echo 'Symlink path: ' . $symlinkPath . "\n";
echo 'Symlink exists: ' . (file_exists($symlinkPath) ? '✅ YES' : '❌ NO') . "\n";

if (file_exists($symlinkPath)) {
    echo 'Is symlink: ' . (is_link($symlinkPath) ? '✅ YES' : '❌ NO') . "\n";
    echo 'Symlink target: ' . (is_link($symlinkPath) ? readlink($symlinkPath) : 'N/A') . "\n";
}

// 3. Periksa apakah file bisa diakses via URL path
$urlPath = '/storage/potentials/' . $filename;
$publicFilePath = public_path($urlPath);

echo "\n=== PUBLIC URL ACCESS CHECK ===\n";
echo 'URL path: ' . $urlPath . "\n";
echo 'Public file path: ' . $publicFilePath . "\n";
echo 'Public file exists: ' . (file_exists($publicFilePath) ? '✅ YES' : '❌ NO') . "\n";

// 4. List files di folder potentials
echo "\n=== FILES IN POTENTIALS FOLDER ===\n";
if (is_dir($storagePath)) {
    $files = scandir($storagePath);
    $imageFiles = [];
    
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..' && stripos($file, 'tempe') !== false) {
            $imageFiles[] = $file;
        }
    }
    
    if (!empty($imageFiles)) {
        echo 'Tempe-related files found:' . "\n";
        foreach ($imageFiles as $file) {
            echo ' - ' . $file . "\n";
        }
    } else {
        echo 'No Tempe-related files found' . "\n";
        echo 'All files in potentials folder:' . "\n";
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                echo ' - ' . $file . "\n";
            }
        }
    }
} else {
    echo '❌ potentials folder does not exist' . "\n";
}

// 5. Coba akses file via different paths
echo "\n=== ALTERNATIVE ACCESS PATHS ===\n";
$alternativePaths = [
    public_path('storage/potentials/' . $filename),
    storage_path('app/public/potentials/' . $filename),
    public_path('potentials/' . $filename)
];

foreach ($alternativePaths as $path) {
    echo 'Path: ' . $path . "\n";
    echo 'Exists: ' . (file_exists($path) ? '✅ YES' : '❌ NO') . "\n\n";
}

echo "🚀 Coba akses: http://localhost:8000/storage/potentials/" . urlencode($filename) . "\n";