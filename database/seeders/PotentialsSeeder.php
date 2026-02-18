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
                'latitude' => -7.12345,
                'longitude' => 109.12345,
                'source' => 'manual',
                'verification_status' => 'verified',
                'images' => [
                    'https://images.pexels.com/photos/2403207/pexels-photo-2403207.jpeg',
                ],
            ],
            [
                'title' => 'Kopi Arabika Dieng – UMKM Binaan Desa',
                'district_name' => 'Batur',
                'village_name' => 'Batur',
                'category_id' => 2,
                'description' => 'Produk kopi kemasan siap jual yang cocok untuk oleh-oleh khas pegunungan Dieng.',
                'price_range' => 'Rp 35.000 - 60.000',
                'latitude' => -7.2,
                'longitude' => 109.9,
                'source' => 'manual',
                'verification_status' => 'verified',
                'images' => [
                    'https://images.pexels.com/photos/3736397/pexels-photo-3736397.jpeg',
                ],
            ],
            [
                'title' => 'Lahan Pertanian Terintegrasi Hortikultura',
                'district_name' => 'Banjarnegara',
                'village_name' => 'Susukan',
                'category_id' => 3,
                'description' => 'Potensi kerja sama kemitraan untuk distribusi sayur dan buah segar skala besar.',
                'price_range' => null,
                'latitude' => -7.3,
                'longitude' => 109.7,
                'source' => 'manual',
                'verification_status' => 'verified',
                'images' => [
                    'https://images.pexels.com/photos/235725/pexels-photo-235725.jpeg',
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
                    'latitude' => $item['latitude'],
                    'longitude' => $item['longitude'],
                    'source' => $item['source'],
                    'verification_status' => $item['verification_status'],
                    'images' => $item['images'],
                ]
            );
        }
    }
}

