<?php

namespace Database\Seeders;

use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VillagesSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'district_name' => 'Banjarnegara',
                'village_name' => 'Pagedongan',
                'website_url' => 'https://pagedongan-banjarnegara.desa.id',
                'api_endpoint' => null,
                'platform' => 'opensid',
                'has_active_website' => true,
                'population' => 0,
                'last_scraped_at' => now(),
                'source_meta' => null,
            ],
            [
                'district_name' => 'Banjarnegara',
                'village_name' => 'Susukan',
                'website_url' => 'https://susukan-banjarnegara.desa.id',
                'api_endpoint' => null,
                'platform' => 'opensid',
                'has_active_website' => true,
                'population' => 0,
                'last_scraped_at' => now(),
                'source_meta' => null,
            ],
            [
                'district_name' => 'Batur',
                'village_name' => 'Batur',
                'website_url' => 'https://batur.desa.id',
                'api_endpoint' => null,
                'platform' => 'opensid',
                'has_active_website' => true,
                'population' => 0,
                'last_scraped_at' => now(),
                'source_meta' => null,
            ],
        ];

        foreach ($data as $village) {
            $village['slug'] = Str::slug($village['village_name'] . '-' . $village['district_name']);

            Village::updateOrCreate(
                [
                    'district_name' => $village['district_name'],
                    'village_name' => $village['village_name'],
                ],
                $village
            );
        }
    }
}

