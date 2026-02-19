<?php

namespace App\Console\Commands;

use App\Models\Village;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AddSembawaVillage extends Command
{
    protected $signature = 'sidara:add-sembawa';

    protected $description = 'Tambahkan Desa Sembawa dengan informasi marketplace ke database';

    public function handle(): int
    {
        $this->info('Menambahkan Desa Sembawa ke database...');

        // Data Desa Sembawa dengan informasi marketplace
        $villageData = [
            'district_name' => 'Kalibening',
            'village_name' => 'Sembawa',
            'slug' => Str::slug('Sembawa-Kalibening'),
            'website_url' => 'https://sembawa-banjarnegara.desa.id',
            'api_endpoint' => 'https://sembawa-banjarnegara.desa.id/lapak',
            'platform' => 'opensid',
            'has_active_website' => true,
            'population' => 2481,
            'source_meta' => [
                'source' => 'manual_entry',
                'last_checked_at' => now()->toDateTimeString(),
                'db_penduduk_status' => 'Belum Ada',
                'raw_population' => '2.481',
                'marketplace_status' => 'active',
                'marketplace_url' => 'https://sembawa-banjarnegara.desa.id/lapak',
                'marketplace_products' => true,
                'marketplace_note' => 'Memiliki marketplace aktif dengan produk digital',
            ],
        ];

        try {
            $village = Village::updateOrCreate(
                [
                    'district_name' => $villageData['district_name'],
                    'village_name' => $villageData['village_name'],
                ],
                $villageData
            );

            $this->info('✅ Desa Sembawa berhasil ditambahkan/diperbarui!');
            $this->info('   - ID: ' . $village->id);
            $this->info('   - Website: ' . $village->website_url);
            $this->info('   - Marketplace: ' . $village->source_meta['marketplace_url']);
            $this->info('   - Status: ' . $village->source_meta['marketplace_status']);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Gagal menambahkan Desa Sembawa: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}