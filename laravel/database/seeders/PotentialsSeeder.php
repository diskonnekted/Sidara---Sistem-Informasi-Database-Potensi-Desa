<?php

namespace Database\Seeders;

use App\Models\Potential;
use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PotentialsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Wisata Curug Pletuk',
                'district_name' => 'Banjarnegara',
                'village_name' => 'Pagedongan',
                'category_id' => 1,
                'description' => 'Curug dengan panorama hijau dan akses yang mudah dijangkau dari jalan utama.',
                'price_range' => 'Rp 10.000',
                'whatsapp_number' => '6281234567890',
                'location_address' => 'Dusun Pletuk, RT 02 / RW 01',
                'latitude' => -7.12345,
                'longitude' => 109.12345,
                'source' => 'manual',
                'verification_status' => 'verified',
                'images' => [
                    'https://images.pexels.com/photos/2403207/pexels-photo-2403207.jpeg',
                ],
                'attributes' => [
                    'category_slug' => 'wisata',
                    'htm' => 5000,
                    'parkir' => 2000,
                    'jam_operasional' => '07.00 - 17.00',
                    'akses_jalan' => 'mobil',
                    'fasilitas' => ['toilet', 'mushola', 'warung_makan'],
                    'sinyal_hp' => 'susah',
                    'waktu_terbaik' => 'Pagi hari untuk menikmati suasana segar',
                ],
            ],
            [
                'title' => 'Kopi Arabika Dieng – UMKM Binaan Desa',
                'district_name' => 'Batur',
                'village_name' => 'Batur',
                'category_id' => 2,
                'description' => 'Produk kopi kemasan siap jual yang cocok untuk oleh-oleh khas pegunungan Dieng.',
                'price_range' => 'Rp 35.000 - 60.000',
                'whatsapp_number' => '6282233344455',
                'location_address' => 'Dusun Krajan, RT 01 / RW 03',
                'latitude' => -7.2,
                'longitude' => 109.9,
                'source' => 'manual',
                'verification_status' => 'verified',
                'images' => [
                    'https://images.pexels.com/photos/3736397/pexels-photo-3736397.jpeg',
                ],
                'attributes' => [
                    'category_slug' => 'umkm',
                    'stock_status' => 'ready',
                    'legalitas' => ['PIRT', 'Halal'],
                    'opsi_pengiriman' => ['cod', 'ekspedisi'],
                    'masa_kadaluarsa_hari' => 365,
                ],
            ],
            [
                'title' => 'Lahan Pertanian Terintegrasi Hortikultura',
                'district_name' => 'Banjarnegara',
                'village_name' => 'Susukan',
                'category_id' => 3,
                'description' => 'Potensi kerja sama kemitraan untuk distribusi sayur dan buah segar skala besar.',
                'price_range' => null,
                'whatsapp_number' => '628567889900',
                'location_address' => 'Blok Sawah Utara, RT 04 / RW 02',
                'latitude' => -7.3,
                'longitude' => 109.7,
                'source' => 'manual',
                'verification_status' => 'verified',
                'images' => [
                    'https://images.pexels.com/photos/235725/pexels-photo-235725.jpeg',
                ],
                'attributes' => [
                    'category_slug' => 'pertanian',
                    'stock_status' => 'musiman',
                    'masa_kadaluarsa_hari' => null,
                ],
            ],
        ];

        foreach ($items as $item) {
            $village = Village::where('district_name', $item['district_name'])
                ->where('village_name', $item['village_name'])
                ->first();

            if (! $village) {
                continue;
            }

            Potential::updateOrCreate(
                [
                    'slug' => Str::slug($item['title']),
                ],
                [
                    'user_id' => null,
                    'village_id' => $village->id,
                    'category_id' => $item['category_id'],
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'price_range' => $item['price_range'],
                    'whatsapp_number' => $item['whatsapp_number'] ?? null,
                    'location_address' => $item['location_address'] ?? null,
                    'latitude' => $item['latitude'],
                    'longitude' => $item['longitude'],
                    'source' => $item['source'],
                    'verification_status' => $item['verification_status'],
                    'images' => $item['images'],
                    'attributes' => $item['attributes'] ?? null,
                ]
            );
        }
    }
}
