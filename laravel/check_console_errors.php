<?php
// Script untuk membantu debug form yang tidak berfungsi
echo '=== DEBUG FORM TIDAK BISA DISIMPAN ===' . "\n\n";
echo 'Langkah-langkah troubleshooting:' . "\n";
echo '1. Buka browser dan buka http://localhost:8000/admin/potensi/81/edit' . "\n";
echo '2. Tekan F12 untuk membuka Developer Tools' . "\n";
echo '3. Pilih tab "Console"' . "\n";
echo '4. Lihat apakah ada error JavaScript (warna merah)' . "\n";
echo '5. Coba klik tombol simpan dan lihat error di console' . "\n\n";

echo '6. Jika tidak ada error JavaScript, cek tab "Network"' . "\n";
echo '7. Klik tombol simpan dan lihat request yang dikirim' . "\n";
echo '8. Perhatikan status response (harus 200 atau 302)' . "\n";
echo '9. Jika status 422, berarti ada validasi error' . "\n\n";

echo '10. Cek juga apakah ada pesan error di halaman:' . "\n";
echo '   - Session flash messages' . "\n";
echo '   - Validation errors' . "\n\n";

echo 'Common issues:' . "\n";
echo '- CSRF token mismatch' . "\n";
echo '- JavaScript validation error' . "\n";
echo '- File upload size too large' . "\n";
echo '- Server-side validation failing' . "\n";

// Cek konfigurasi upload
echo '=== PHP UPLOAD CONFIG ===' . "\n";
echo 'upload_max_filesize: ' . ini_get('upload_max_filesize') . "\n";
echo 'post_max_size: ' . ini_get('post_max_size') . "\n";
echo 'max_file_uploads: ' . ini_get('max_file_uploads') . "\n\n";

// Cek apakah session bekerja
echo '=== SESSION STATUS ===' . "\n";
if (session_status() === PHP_SESSION_ACTIVE) {
    echo 'Session aktif' . "\n";
} else {
    echo 'Session tidak aktif' . "\n";
}