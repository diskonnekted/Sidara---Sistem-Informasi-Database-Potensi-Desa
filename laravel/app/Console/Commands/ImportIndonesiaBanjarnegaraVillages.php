<?php

namespace App\Console\Commands;

use App\Models\Village;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportIndonesiaBanjarnegaraVillages extends Command
{
    protected $signature = 'sidara:import-indonesia-banjarnegara-villages 
        {--city-id=3304 : ID kota/kabupaten Banjarnegara di dataset laravolt/indonesia}';

    protected $description = 'Import seluruh desa di Kabupaten Banjarnegara dari dataset laravolt/indonesia (CSV) ke tabel villages';

    public function handle(): int
    {
        $this->info('Mengambil data desa Banjarnegara dari CSV laravolt/indonesia (Jawa Tengah)');

        $villagesCsv = base_path('vendor/laravolt/indonesia/resources/csv/villages/33.csv');
        $districtsCsv = base_path('vendor/laravolt/indonesia/resources/csv/districts.csv');

        if (! file_exists($villagesCsv) || ! file_exists($districtsCsv)) {
            $this->error('File CSV laravolt/indonesia tidak ditemukan. Pastikan paket laravolt/indonesia sudah ter-install.');

            return Command::FAILURE;
        }

        $banjarnegaraCityCode = '3304';

        $districtNames = $this->loadBanjarnegaraDistrictNames($districtsCsv, $banjarnegaraCityCode);

        $countTotal = 0;
        $countImported = 0;

        $handle = fopen($villagesCsv, 'r');

        if (! $handle) {
            $this->error('Gagal membuka file: '.$villagesCsv);

            return Command::FAILURE;
        }

        while (($line = fgets($handle)) !== false) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            $parts = str_getcsv($line);

            if (count($parts) < 6) {
                continue;
            }

            $villageCode = $parts[0];
            $districtCode = $parts[1];
            $villageNameRaw = $parts[2];
            $latitude = $parts[3];
            $longitude = $parts[4];
            $postalCode = $parts[5];

            if (substr($districtCode, 0, 4) !== $banjarnegaraCityCode) {
                continue;
            }

            $countTotal++;

            $districtNameRaw = $districtNames[$districtCode] ?? null;

            if (! $districtNameRaw) {
                continue;
            }

            $districtName = $this->formatName($districtNameRaw);
            $villageName = $this->formatName($villageNameRaw);

            Village::updateOrCreate(
                [
                    'district_name' => $districtName,
                    'village_name' => $villageName,
                ],
                [
                    'slug' => Str::slug($villageName.'-'.$districtName),
                    'website_url' => null,
                    'api_endpoint' => null,
                    'platform' => 'unknown',
                    'has_active_website' => false,
                    'population' => null,
                    'last_scraped_at' => null,
                    'source_meta' => [
                        'source' => 'laravolt/indonesia',
                        'province_code' => 33,
                        'city_code' => (int) $banjarnegaraCityCode,
                        'district_code' => $districtCode,
                        'village_code' => $villageCode,
                        'postal_code' => $postalCode,
                    ],
                ]
            );

            $countImported++;

            $this->line('• '.$villageName.' ('.$districtName.')');
        }

        fclose($handle);

        $this->info('Total baris desa Banjarnegara (CSV): '.$countTotal);
        $this->info('Desa yang diinsert/update ke tabel villages: '.$countImported);

        return Command::SUCCESS;
    }

    protected function loadBanjarnegaraDistrictNames(string $districtsCsv, string $banjarnegaraCityCode): array
    {
        $map = [];

        $handle = fopen($districtsCsv, 'r');

        if (! $handle) {
            return $map;
        }

        while (($line = fgets($handle)) !== false) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            $parts = str_getcsv($line);

            if (count($parts) < 3) {
                continue;
            }

            $districtCode = $parts[0];
            $cityCode = $parts[1];
            $districtName = $parts[2];

            if ((string) $cityCode !== (string) $banjarnegaraCityCode) {
                continue;
            }

            $map[$districtCode] = $districtName;
        }

        fclose($handle);

        return $map;
    }

    protected function formatName(string $name): string
    {
        $name = mb_strtolower($name);

        $name = preg_replace_callback(
            '/\b([\p{L}\'-]+)\b/u',
            function ($matches) {
                return mb_convert_case($matches[1], MB_CASE_TITLE, 'UTF-8');
            },
            $name
        );

        return trim(preg_replace('/\s+/', ' ', (string) $name));
    }
}
