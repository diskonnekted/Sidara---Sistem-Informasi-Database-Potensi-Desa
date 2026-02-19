<?php

namespace App\Console\Commands;

use App\Models\Village;
use App\Models\Potential;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AddPagentanMarketplace extends Command
{
    protected $signature = 'sidara:add-pagentan-marketplace';
    protected $description = 'Tambahkan Desa Gumingsir, Pagentan dan semua produk marketplace mereka ke database SIDARA';

    public function handle(): int
    {
        $this->info('🚀 Memulai proses penambahan produk marketplace Kecamatan Pagentan...');

        // 1. Tambahkan Desa Gumingsir
        $gumingsirData = [
            'district_name' => 'Pagentan',
            'village_name' => 'Gumingsir',
            'slug' => Str::slug('Gumingsir-Pagentan'),
            'website_url' => 'https://gumingsir-banjarnegara.desa.id/',
            'api_endpoint' => 'https://gumingsir-banjarnegara.desa.id/lapak',
            'platform' => 'opensid',
            'has_active_website' => true,
            'population' => 2126,
            'source_meta' => [
                'source' => 'manual_entry',
                'last_checked_at' => now()->toDateTimeString(),
                'db_penduduk_status' => 'Sudah Ada',
                'raw_population' => '2.126',
                'marketplace_status' => 'active',
                'marketplace_url' => 'https://gumingsir-banjarnegara.desa.id/lapak',
                'marketplace_products' => true,
                'marketplace_note' => 'Memiliki marketplace aktif dengan produk Slingbag Custom',
            ],
        ];

        $gumingsirVillage = Village::updateOrCreate(
            ['district_name' => $gumingsirData['district_name'], 'village_name' => $gumingsirData['village_name']],
            $gumingsirData
        );

        $this->info('✅ Desa Gumingsir berhasil ditambahkan/diperbarui! ID: ' . $gumingsirVillage->id);

        // 2. Tambahkan produk Desa Gumingsir
        $gumingsirProduct = [
            'village_id' => $gumingsirVillage->id,
            'title' => 'Slingbag Custom',
            'slug' => Str::slug('Slingbag Custom Gumingsir'),
            'description' => 'Slingbag Custom, bisa sesuai keinginan, boleh tambah tulisan, gambar ataupun logo.',
            'price_range' => 'Rp 100.000,00 / pcs',
            'whatsapp_number' => null,
            'location_address' => 'Desa Gumingsir, Kecamatan Pagentan, Kabupaten Banjarnegara',
            'source' => 'manual',
            'verification_status' => 'verified',
            'images' => ['gumingsir-slingbag-custom.jpg'],
            'attributes' => [
                'seller_name' => 'TAUFIK HIDAYAT',
                'marketplace_url' => 'https://gumingsir-banjarnegara.desa.id/lapak',
                'product_category' => 'Fashion & Aksesoris',
                'product_type' => 'Custom Handmade',
                'customization' => 'Bisa tambah tulisan, gambar, atau logo',
                'unit' => 'pcs',
                'source_platform' => 'Desa.id',
            ],
        ];

        $gumingsirPotential = Potential::updateOrCreate(
            ['village_id' => $gumingsirVillage->id, 'slug' => $gumingsirProduct['slug']],
            $gumingsirProduct
        );

        $this->info('✅ Produk Slingbag Custom (Gumingsir) berhasil ditambahkan! ID: ' . $gumingsirPotential->id);

        // 3. Tambahkan Desa Pagentan
        $pagentanData = [
            'district_name' => 'Pagentan',
            'village_name' => 'Pagentan',
            'slug' => Str::slug('Pagentan-Pagentan'),
            'website_url' => 'https://pagentan-banjarnegara.desa.id/',
            'api_endpoint' => 'https://pagentan-banjarnegara.desa.id/lapak',
            'platform' => 'opensid',
            'has_active_website' => true,
            'population' => 5326,
            'source_meta' => [
                'source' => 'manual_entry',
                'last_checked_at' => now()->toDateTimeString(),
                'db_penduduk_status' => 'Sudah Ada',
                'raw_population' => '5.326',
                'marketplace_status' => 'active',
                'marketplace_url' => 'https://pagentan-banjarnegara.desa.id/lapak',
                'marketplace_products' => true,
                'marketplace_note' => 'Memiliki marketplace aktif dengan 8 produk berbeda',
                'marketplace_stats' => [
                    'total_products' => 8,
                    'categories' => ['Makanan', 'Hewan', 'Kecantikan', 'Kerajinan', 'Otomotif'],
                    'price_range' => 'Rp 8.000 - Rp 700.000',
                ],
            ],
        ];

        $pagentanVillage = Village::updateOrCreate(
            ['district_name' => $pagentanData['district_name'], 'village_name' => $pagentanData['village_name']],
            $pagentanData
        );

        $this->info('✅ Desa Pagentan berhasil ditambahkan/diperbarui! ID: ' . $pagentanVillage->id);

        // 4. Tambahkan semua produk Desa Pagentan
        $pagentanProducts = [
            [
                'title' => 'Warung Mie Ayam dan Martabak Bang Amir',
                'slug' => Str::slug('Warung Mie Ayam Martabak Bang Amir Pagentan'),
                'description' => 'Warung Mie Ayam dan Martabak Bang Amir, siap antar area Desa Pagentan dan Sekitarnya.',
                'price_range' => 'Rp 8.000,00',
                'seller_name' => 'ALIF AMIRUDIN',
                'category' => 'Makanan & Minuman',
                'delivery' => 'Siap antar area Desa Pagentan dan sekitarnya',
                'images' => ['pagentan-mie-ayam-martabak.jpg'],
            ],
            [
                'title' => 'Kelinci Holand Lop',
                'slug' => Str::slug('Kelinci Holand Lop Pagentan'),
                'description' => 'Kelamin Jantan umur 2 bulan',
                'price_range' => 'Rp 100.000,00',
                'seller_name' => 'NOFA MARDIYANTO',
                'category' => 'Hewan Peliharaan',
                'specifications' => 'Jantan, umur 2 bulan',
                'images' => ['pagentan-kelinci-holand.jpg'],
            ],
            [
                'title' => 'Klotak',
                'slug' => Str::slug('Klotak Pagentan'),
                'description' => 'Klotak Gurih, Pedas dan Renyah.',
                'price_range' => 'Rp 55.000,00',
                'seller_name' => 'APRILIA KHUSNUL KHOTIMAH',
                'category' => 'Makanan Ringan',
                'characteristics' => 'Gurih, Pedas, Renyah',
                'images' => ['pagentan-klotak.jpg'],
            ],
            [
                'title' => 'Sabun Multy Beauty',
                'slug' => Str::slug('Sabun Multy Beauty Pagentan'),
                'description' => 'Skincare bisa mengatasi semua masalah wajah seperti jerawat komedo flek di wajah. Bisa dipakai usia bayi balita dan dewasa karna herbal.',
                'price_range' => 'Rp 75.000,00',
                'seller_name' => 'DIAS EKA PUTRI',
                'category' => 'Kecantikan & Skincare',
                'benefits' => 'Mengatasi jerawat, komedo, flek, bruntusan',
                'age_range' => 'Bayi, balita, dewasa',
                'ingredients' => 'Herbal',
                'images' => ['pagentan-sabun-multy.jpg'],
            ],
            [
                'title' => 'Skincare NBS',
                'slug' => Str::slug('Skincare NBS Pagentan'),
                'description' => 'Skincare bisa mengatasi semua masalah wajah seperti jerawat komedo flek di wajah. Bisa dipakai usia bayi balita dan dewasa karna herbal.',
                'price_range' => 'Rp 190.000,00',
                'seller_name' => 'DIAS EKA PUTRI',
                'category' => 'Kecantikan & Skincare',
                'benefits' => 'Mengatasi jerawat, komedo, flek, bruntusan',
                'age_range' => 'Bayi, balita, dewasa',
                'ingredients' => 'Herbal',
                'images' => ['pagentan-skincare-nbs.jpg'],
            ],
            [
                'title' => 'Lasnium Kreasi',
                'slug' => Str::slug('Lasnium Kreasi Pagentan'),
                'description' => 'Spesialis Kusen Aluminium dan Besi, Menerima juga pengerjaan stainless steel, plafon pvc, dan baja ringan.',
                'price_range' => 'Rp 500.000,00',
                'seller_name' => 'AHMAD RISMANTO',
                'category' => 'Konstruksi & Bangunan',
                'services' => 'Kusen aluminium, besi, stainless steel, plafon PVC, baja ringan',
                'images' => ['pagentan-lasnium-kreasi.jpg'],
            ],
            [
                'title' => 'Scribble Art',
                'slug' => Str::slug('Scribble Art Pagentan'),
                'description' => 'Penjorangan Art - Produk-produk handmade cocok untuk kado anak, teman, pasangan atau hiasan kamar.',
                'price_range' => 'Rp 75.000,00',
                'seller_name' => 'TRI ISMAIL',
                'category' => 'Kerajinan & Seni',
                'product_type' => 'Handmade',
                'usage' => 'Kado, hiasan kamar',
                'social_media' => '@PenjoranganArt',
                'images' => ['pagentan-scribble-art.jpg'],
            ],
            [
                'title' => 'Astra Motor Pagentan',
                'slug' => Str::slug('Astra Motor Pagentan'),
                'description' => 'Melayani penjualan sepeda motor Honda baik cash, cash tempo dan kredit. Persyaratan mudah, proses cepat dibantu sampai ACC.',
                'price_range' => 'Rp 700.000,00',
                'seller_name' => 'FERRY FADHILLAH',
                'category' => 'Otomotif',
                'brand' => 'Honda',
                'services' => 'Penjualan motor cash, cash tempo, kredit',
                'promo' => 'BEAT SERIES promo DP=angsuran',
                'images' => ['pagentan-astra-motor.jpg'],
            ],
        ];

        $addedCount = 0;
        foreach ($pagentanProducts as $productData) {
            $product = [
                'village_id' => $pagentanVillage->id,
                'title' => $productData['title'],
                'slug' => $productData['slug'],
                'description' => $productData['description'],
                'price_range' => $productData['price_range'],
                'whatsapp_number' => null,
                'location_address' => 'Desa Pagentan, Kecamatan Pagentan, Kabupaten Banjarnegara',
                'source' => 'manual',
                'verification_status' => 'verified',
                'images' => $productData['images'],
                'attributes' => [
                    'seller_name' => $productData['seller_name'],
                    'marketplace_url' => 'https://pagentan-banjarnegara.desa.id/lapak',
                    'product_category' => $productData['category'],
                    'source_platform' => 'Desa.id',
                ],
            ];

            // Tambahkan atribut spesifik berdasarkan produk
            foreach ($productData as $key => $value) {
                if (!in_array($key, ['title', 'slug', 'description', 'price_range', 'seller_name', 'category', 'images'])) {
                    $product['attributes'][$key] = $value;
                }
            }

            $potential = Potential::updateOrCreate(
                ['village_id' => $pagentanVillage->id, 'slug' => $productData['slug']],
                $product
            );

            $addedCount++;
            $this->info('✅ Produk ' . $productData['title'] . ' berhasil ditambahkan!');
        }

        $this->info('🎉 SUKSES! Total ' . $addedCount . ' produk dari Desa Pagentan telah ditambahkan!');
        $this->info('📊 Total keseluruhan: 1 desa + 1 produk (Gumingsir) + 8 produk (Pagentan) = 10 entri baru');
        $this->info('🏆 Marketplace Kecamatan Pagentan telah berhasil diintegrasikan ke SIDARA!');

        return Command::SUCCESS;
    }
}