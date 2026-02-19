<?php

namespace App\Console\Commands;

use App\Models\Village;
use App\Models\Potential;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AddPetambakanProduct extends Command
{
    protected $signature = 'sidara:add-petambakan';
    protected $description = 'Tambahkan Desa Petambakan dan produk marketplace Singkong Goreng Renyah ke database';

    public function handle(): int
    {
        // 1. Tambahkan atau update Desa Petambakan
        $villageData = [
            'district_name' => 'Madukara',
            'village_name' => 'Petambakan',
            'slug' => Str::slug('Petambakan-Madukara'),
            'website_url' => 'https://petambakan-madukara.webdeva.io/',
            'api_endpoint' => 'https://petambakan-madukara.webdeva.io/lapak',
            'platform' => 'webdeva',
            'has_active_website' => true,
            'population' => 3121,
            'source_meta' => [
                'source' => 'manual_entry',
                'last_checked_at' => now()->toDateTimeString(),
                'db_penduduk_status' => 'Sudah Ada',
                'raw_population' => '3.121',
                'marketplace_status' => 'active',
                'marketplace_url' => 'https://petambakan-madukara.webdeva.io/lapak',
                'marketplace_products' => true,
                'marketplace_note' => 'Memiliki marketplace aktif dengan produk Singkong Goreng Renyah',
            ],
        ];

        $village = Village::updateOrCreate(
            ['district_name' => $villageData['district_name'], 'village_name' => $villageData['village_name']],
            $villageData
        );

        $this->info('✅ Desa Petambakan berhasil ditambahkan/diperbarui! ID: ' . $village->id);

        // 2. Tambahkan produk Singkong Goreng Renyah
        $productData = [
            'village_id' => $village->id,
            'title' => 'Singkong Goreng Renyah',
            'slug' => Str::slug('Singkong Goreng Renyah Petambakan'),
            'description' => 'Singkong goreng renyah dengan hasil tanam sendiri. Ditanam dan dirawat sepenuh hati dengan kasih sayang, cinta, dan dedikasi tinggi. Menghasilkan singkong goreng yang mantap renyah dan nikmat ketika masuk mulut. Dan nyaman di lambung',
            'price_range' => 'Rp. 10.000,00',
            'whatsapp_number' => null,
            'location_address' => 'Desa Petambakan, Kecamatan Madukara, Kabupaten Banjarnegara',
            'source' => 'manual',
            'verification_status' => 'verified',
            'images' => ['petambakan-singkong-goreng.jpg'],
            'attributes' => [
                'seller_name' => 'ACHMAD MUSTAQIM',
                'marketplace_url' => 'https://petambakan-madukara.webdeva.io/lapak',
                'product_category' => 'Makanan Olahan',
                'production_method' => 'Hasil tanam sendiri',
                'quality_features' => 'Renyah, nikmat, nyaman di lambung',
                'source_platform' => 'Webdeva',
            ],
        ];

        $product = Potential::updateOrCreate(
            ['village_id' => $village->id, 'slug' => $productData['slug']],
            $productData
        );

        $this->info('✅ Produk Singkong Goreng Renyah berhasil ditambahkan! ID: ' . $product->id);
        $this->info('🎉 Proses selesai! Desa Petambakan dan produk marketplace telah ditambahkan ke SIDARA.');

        return Command::SUCCESS;
    }
}