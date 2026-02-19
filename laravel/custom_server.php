<?php

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Handle static files from storage first
if (strpos($uri, '/storage/') === 0) {
    $filePath = __DIR__ . '/storage/app/public' . substr($uri, 8);
    
    if (file_exists($filePath) && is_file($filePath)) {
        // Set proper content type based on file extension
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
        ];
        
        if (isset($mimeTypes[$extension])) {
            header('Content-Type: ' . $mimeTypes[$extension]);
        }
        
        // Serve the file directly
        readfile($filePath);
        exit;
    }
}

// Handle static files from public folder
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

// Fall back to Laravel routing
require_once __DIR__ . '/public/index.php';