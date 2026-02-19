<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== DETAILED SYMLINK CHECK ===' . "\n\n";

// 1. Check symlink status
$symlinkPath = public_path('storage');
$targetPath = storage_path('app/public');

echo 'Symlink path: ' . $symlinkPath . "\n";
echo 'Target path: ' . $targetPath . "\n";
echo 'Symlink exists: ' . (file_exists($symlinkPath) ? '✅ YES' : '❌ NO') . "\n";
echo 'Is symlink: ' . (is_link($symlinkPath) ? '✅ YES' : '❌ NO') . "\n";

if (is_link($symlinkPath)) {
    echo 'Symlink target: ' . readlink($symlinkPath) . "\n";
    echo 'Target exists: ' . (file_exists(readlink($symlinkPath)) ? '✅ YES' : '❌ NO') . "\n";
}

// 2. Check the specific file
$filename = 'sijenggung-Tempe-Goreng-mendoan.jpeg';
$filePaths = [
    'via_symlink' => $symlinkPath . '/potentials/' . $filename,
    'direct' => $targetPath . '/potentials/' . $filename,
    'public_direct' => public_path('storage/potentials/' . $filename)
];

echo "\n=== FILE EXISTENCE CHECK ===\n";
foreach ($filePaths as $type => $path) {
    echo "$type: $path\n";
    echo "Exists: " . (file_exists($path) ? '✅ YES' : '❌ NO') . "\n";
    if (file_exists($path)) {
        echo "Size: " . filesize($path) . " bytes\n";
    }
    echo "\n";
}

// 3. Check if potentials folder exists in both locations
$potentialDirs = [
    'symlink_potentials' => $symlinkPath . '/potentials',
    'target_potentials' => $targetPath . '/potentials'
];

echo "=== POTENTIALS FOLDER CHECK ===\n";
foreach ($potentialDirs as $type => $dir) {
    echo "$type: $dir\n";
    echo "Exists: " . (file_exists($dir) ? '✅ YES' : '❌ NO') . "\n";
    echo "Is dir: " . (is_dir($dir) ? '✅ YES' : '❌ NO') . "\n";
    
    if (is_dir($dir)) {
        $files = scandir($dir);
        $imageFiles = array_filter($files, function($file) {
            return $file !== '.' && $file !== '..' && 
                   (stripos($file, 'tempe') !== false || stripos($file, 'sijenggung') !== false);
        });
        
        if (!empty($imageFiles)) {
            echo "Relevant files: " . implode(', ', $imageFiles) . "\n";
        }
    }
    echo "\n";
}

// 4. Server routing check - test if server.php is handling static files correctly
echo "=== SERVER ROUTING CHECK ===\n";
echo 'Current working directory: ' . getcwd() . "\n";
echo 'Public path: ' . public_path() . "\n";

// 5. Test URL encoding
echo "=== URL ENCODING TEST ===\n";
$testUrl = '/storage/potentials/sijenggung-Tempe-Goreng-mendoan.jpeg';
echo 'Test URL: ' . $testUrl . "\n";
echo 'URL encoded: ' . urlencode($testUrl) . "\n";
echo 'Raw URL: ' . rawurlencode($testUrl) . "\n";

// 6. Manual test - try to access the file directly via PHP
echo "=== MANUAL FILE ACCESS TEST ===\n";
$manualPath = public_path('storage/potentials/sijenggung-Tempe-Goreng-mendoan.jpeg');
if (file_exists($manualPath)) {
    echo "✅ File can be accessed manually via PHP\n";
    echo "MIME type: " . mime_content_type($manualPath) . "\n";
    
    // Try to read first few bytes to verify it's a valid image
    $handle = fopen($manualPath, 'rb');
    if ($handle) {
        $header = fread($handle, 4);
        fclose($handle);
        echo "File header: " . bin2hex($header) . "\n";
        
        // Check if it's a JPEG (starts with FF D8 FF)
        if (bin2hex($header) === 'ffd8ffe0' || strpos(bin2hex($header), 'ffd8ff') === 0) {
            echo "✅ Valid JPEG image\n";
        } else {
            echo "⚠️  Not a standard JPEG file\n";
        }
    }
} else {
    echo "❌ Cannot access file manually\n";
}

echo "\n🚀 Coba akses dengan: http://localhost:8000/storage/potentials/" . rawurlencode('sijenggung-Tempe-Goreng-mendoan.jpeg') . "\n";