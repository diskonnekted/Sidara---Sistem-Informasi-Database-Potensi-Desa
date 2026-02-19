<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== LARAVEL STRUCTURE CHECK ===' . "\n\n";

// 1. Check basic Laravel structure
echo '=== BASIC STRUCTURE ===' . "\n";
$paths = [
    'bootstrap/app.php',
    'public/index.php', 
    'routes/web.php',
    'app/Http/Controllers',
    'storage/app/public',
    'public/storage'
];

foreach ($paths as $path) {
    $fullPath = __DIR__ . '/' . $path;
    echo "$path: " . (file_exists($fullPath) ? '✅ EXISTS' : '❌ MISSING') . "\n";
}

// 2. Check storage symlink specifically
echo "\n=== STORAGE SYMLINK DETAILED ===\n";
$symlinkPath = public_path('storage');
$targetPath = storage_path('app/public');

echo 'Symlink: ' . $symlinkPath . "\n";
echo 'Target: ' . $targetPath . "\n";
echo 'Symlink exists: ' . (file_exists($symlinkPath) ? '✅ YES' : '❌ NO') . "\n";
echo 'Is link: ' . (is_link($symlinkPath) ? '✅ YES' : '❌ NO') . "\n";
echo 'Target exists: ' . (file_exists($targetPath) ? '✅ YES' : '❌ NO') . "\n";

if (is_link($symlinkPath)) {
    $actualTarget = readlink($symlinkPath);
    echo 'Actual target: ' . $actualTarget . "\n";
    echo 'Target resolves: ' . (file_exists($actualTarget) ? '✅ YES' : '❌ NO') . "\n";
}

// 3. Check file access from different perspectives
echo "\n=== FILE ACCESS TEST ===\n";
$filename = 'sijenggung-Tempe-Goreng-mendoan.jpeg';

// Test paths
$testPaths = [
    'via_symlink' => $symlinkPath . '/potentials/' . $filename,
    'direct_target' => $targetPath . '/potentials/' . $filename,
    'public_direct' => public_path('storage/potentials/' . $filename),
    'relative_web' => $_SERVER['DOCUMENT_ROOT'] . '/storage/potentials/' . $filename
];

foreach ($testPaths as $type => $path) {
    echo "$type: $path\n";
    echo "Exists: " . (file_exists($path) ? '✅ YES' : '❌ NO') . "\n";
    if (file_exists($path)) {
        echo "Readable: " . (is_readable($path) ? '✅ YES' : '❌ NO') . "\n";
        echo "Size: " . filesize($path) . " bytes\n";
    }
    echo "\n";
}

// 4. Check web server document root
echo "=== WEB SERVER CONFIG ===\n";
echo 'DOCUMENT_ROOT: ' . ($_SERVER['DOCUMENT_ROOT'] ?? 'NOT SET') . "\n";
echo 'SCRIPT_FILENAME: ' . ($_SERVER['SCRIPT_FILENAME'] ?? 'NOT SET') . "\n";
echo 'PHP_SELF: ' . ($_SERVER['PHP_SELF'] ?? 'NOT SET') . "\n";

// 5. Check if file is accessible via HTTP test
echo "\n=== HTTP ACCESS SIMULATION ===\n";
$webPath = '/storage/potentials/' . $filename;
$fullWebPath = public_path($webPath);

echo 'Web path: ' . $webPath . "\n";
echo 'Full web path: ' . $fullWebPath . "\n";
echo 'File exists at web path: ' . (file_exists($fullWebPath) ? '✅ YES' : '❌ NO') . "\n";

// 6. Test if we can read the file contents
echo "\n=== FILE CONTENT TEST ===\n";
if (file_exists($testPaths['via_symlink'])) {
    $content = file_get_contents($testPaths['via_symlink']);
    echo 'File content size: ' . strlen($content) . " bytes\n";
    echo 'First 100 bytes: ' . bin2hex(substr($content, 0, 100)) . "\n";
    
    // Check if it's a valid JPEG
    if (strpos(bin2hex(substr($content, 0, 4)), 'ffd8') === 0) {
        echo '✅ Valid JPEG file detected\n';
    } else {
        echo '❌ Not a valid JPEG file\n';
    }
} else {
    echo '❌ Cannot test file content - file not found\n';
}

// 7. Final recommendation
echo "\n=== RECOMMENDATION ===\n";
if (file_exists($testPaths['via_symlink']) && file_exists($testPaths['public_direct'])) {
    echo '✅ File exists in both locations\n';
    echo '🚀 Try accessing: http://localhost:8000/storage/potentials/sijenggung-Tempe-Goreng-mendoan.jpeg\n';
    echo '📋 If still not working, the issue may be with PHP built-in server routing\n';
} else {
    echo '❌ File missing from expected locations\n';
    echo '💡 Check if the file was moved or deleted\n';
}

echo "\n💡 Try temporary solution: Copy file to public folder\n";
$tempPath = public_path('temp-images/' . $filename);
if (!file_exists(dirname($tempPath))) {
    mkdir(dirname($tempPath), 0755, true);
}

if (file_exists($testPaths['via_symlink']) && copy($testPaths['via_symlink'], $tempPath)) {
    echo '✅ Temporary copy created: ' . $tempPath . "\n";
    echo '🔗 Access via: http://localhost:8000/temp-images/sijenggung-Tempe-Goreng-mendoan.jpeg\n';
} else {
    echo '❌ Could not create temporary copy\n';
}