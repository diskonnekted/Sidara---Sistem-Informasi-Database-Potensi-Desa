<?php

namespace App\Console\Commands;

use App\Models\Potential;
use App\Models\Village;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportSijenggungLapak extends Command
{
    protected $signature = 'sidara:import-sijenggung-lapak';

    protected $description = 'Impor produk UMKM dari lapak Desa Sijenggung menjadi potensi';

    public function handle(): int
    {
        $village = Village::query()
            ->where('village_name', 'Sijenggung')
            ->where('district_name', 'Banjarmangu')
            ->first();

        if (! $village) {
            $this->error('Desa Sijenggung, Kecamatan Banjarmangu tidak ditemukan di tabel villages.');

            return Command::FAILURE;
        }

        $products = [
            [
                'name' => 'Bumboe Dapoer Makake',
                'seller' => 'RIZALDI SAPUTRA',
                'price' => 'Mulai Rp 1.000 s.d Rp 10.000',
                'description' => 'Bumbu serbaguna untuk masakan, tersedia kemasan 1/4 dan eceran sachet. Cocok untuk berbagai olahan rumahan.',
            ],
            [
                'name' => 'Pemasangan Jaringan WIFI Desa',
                'seller' => 'AJI RISTANTO',
                'price' => 'Mulai Rp 100.000/bulan',
                'description' => 'Layanan pemasangan internet fiber optik untuk area Desa Sijenggung dan sekitarnya dengan paket harga bulanan yang fleksibel.',
            ],
            [
                'name' => 'Piring Lidi',
                'seller' => 'SUWANTI',
                'price' => 'Hubungi pelapak',
                'description' => 'Piring ramah lingkungan dari bahan lidi, kuat dan tahan lama, cocok untuk sajian tradisional maupun dekorasi.',
            ],
            [
                'name' => 'AGRO INDEPENDENT',
                'seller' => 'TRIMA YUANA',
                'price' => 'Harga menyesuaikan jenis bibit',
                'description' => 'Menyediakan berbagai bibit tanaman (durian, alpukat, kelapa genjah, pisang, dan lainnya), pupuk organik, serta bibit ikan air tawar beserta pakannya.',
            ],
            [
                'name' => 'Tempe Goreng/mendoan',
                'seller' => 'MIDIN',
                'price' => 'Hubungi pelapak',
                'description' => 'Tempe goreng dan mendoan dari kedelai pilihan dengan resep turun temurun, nikmat disajikan hangat.',
            ],
            [
                'name' => 'Karagku dan karonku',
                'seller' => 'AJI RISTANTO',
                'price' => 'Hubungi pelapak',
                'description' => 'Nasi kering siap saji berbahan dasar jagung dan ketela, praktis untuk stok pangan harian.',
            ],
            [
                'name' => 'Nasi Jagung',
                'seller' => 'SARTINAH',
                'price' => 'Rp 2.500 per paket',
                'description' => 'Nasi berbahan jagung dengan porsi per tangkep, alternatif makanan pokok yang lebih sehat.',
            ],
            [
                'name' => 'Nasi Ketela/Tumpeng',
                'seller' => 'MIDIN',
                'price' => 'Rp 2.500 per bungkus',
                'description' => 'Nasi dari ketela pohon sebagai solusi makanan sehat, dikemas per bungkus/tangkep.',
            ],
            [
                'name' => 'Fashion',
                'seller' => 'TANIA IDA RAHAYU',
                'price' => 'Hubungi pelapak',
                'description' => 'Berbagai tas dan aksesori wanita, katalog dan harga akan diinformasikan ketika ada pesanan.',
            ],
            [
                'name' => 'Independent Accessories',
                'seller' => 'TRIMA YUANA',
                'price' => 'Hubungi pelapak',
                'description' => 'Menjual berbagai mainan anak dan aksesori, dengan layanan antar ke lokasi pembeli di hari yang sama.',
            ],
        ];

        $created = 0;
        $updated = 0;

        foreach ($products as $product) {
            $title = trim($product['name']);

            $imagePath = $this->resolveImagePath($title);

            $payload = [
                'village_id' => $village->id,
                'title' => $title,
                'description' => $this->buildDescription($product),
                'price_range' => $product['price'],
                'location_address' => 'Desa Sijenggung, Kecamatan Banjarmangu, Kabupaten Banjarnegara',
                'source' => 'api',
                'verification_status' => 'pending',
                'images' => $imagePath ? [$imagePath] : [],
                'attributes' => [
                    'village_website' => 'https://sijenggung-banjarnegara.desa.id/lapak',
                    'seller_name' => $product['seller'],
                    'raw_price' => $product['price'],
                    'raw_description' => $product['description'],
                    'category' => 'umkm',
                    'image_path' => $imagePath,
                ],
            ];

            $existing = Potential::query()
                ->where('village_id', $village->id)
                ->where('title', $title)
                ->where('source', 'api')
                ->first();

            if ($existing) {
                $existing->update($payload);
                $updated++;
                $this->line('• Update potensi: '.$title);
            } else {
                $payload['slug'] = $this->generateUniqueSlug($title.' '.$village->village_name);
                Potential::create($payload);
                $created++;
                $this->line('• Buat potensi: '.$title);
            }
        }

        $this->info('Selesai. Potensi dibuat: '.$created.', diperbarui: '.$updated);

        return Command::SUCCESS;
    }

    protected function buildDescription(array $product): string
    {
        $name = $product['name'];
        $seller = $product['seller'];
        $price = $product['price'];
        $desc = $product['description'];

        $text = 'Produk/layanan UMKM Desa Sijenggung: '.$name.'. ';
        $text .= $desc.' ';
        $text .= 'Pelapak: '.$seller.'. ';
        $text .= 'Harga: '.$price.'. ';
        $text .= 'Data diambil dari halaman lapak resmi Desa Sijenggung.';

        return $text;
    }

    protected function resolveImagePath(string $title): ?string
    {
        $safeTitle = preg_replace('/[\/\\\\]+/', ' ', $title);
        $safeTitle = preg_replace('/\s+/', ' ', $safeTitle);
        $safeTitle = trim($safeTitle);

        $candidates = [
            'potensi/sijenggung '.$safeTitle.'.jpg',
            'potensi/sijenggung '.$safeTitle.'.jpeg',
            'potensi/sijenggung '.$safeTitle.'.png',
            'potensi/sijenggung '.$safeTitle.'.webp',
            'potensi/sijenggung '.$title.'.jpg',
            'potensi/sijenggung '.$title.'.jpeg',
            'potensi/sijenggung '.$title.'.png',
            'potensi/sijenggung '.$title.'.webp',
        ];

        foreach ($candidates as $relative) {
            if (file_exists(public_path($relative))) {
                return $relative;
            }
        }

        return null;
    }

    protected function generateUniqueSlug(string $baseTitle): string
    {
        $base = Str::slug($baseTitle);

        if ($base === '') {
            $base = Str::slug('potensi-sijenggung-umkm');
        }

        $slug = $base;
        $i = 1;

        while (Potential::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
