<?php

namespace App\Console\Commands;

use App\Models\Village;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportDataWilayahVillages extends Command
{
    protected $signature = 'sidara:import-datawilayah-villages 
        {--kabupaten=BANJARNEGARA : Nama kabupaten (huruf bebas, akan dibandingkan tanpa peka huruf besar-kecil)} 
        {--source=https://raw.githubusercontent.com/luffynas/Data-Wilayah/master/Data%20Desa.json : URL sumber Data Desa.json}';

    protected $description = 'Import data desa untuk satu kabupaten dari dataset Data-Wilayah (GitHub luffynas)';

    public function handle(): int
    {
        $kabupatenTarget = mb_strtoupper(trim($this->option('kabupaten')));
        $sourceUrl = $this->option('source');

        $this->info('Mengambil data desa dari: '.$sourceUrl);

        try {
            $response = Http::get($sourceUrl);
        } catch (\Throwable $e) {
            $this->error('Gagal mengakses URL sumber: '.$e->getMessage());
            return Command::FAILURE;
        }

        if (! $response->ok()) {
            $this->error('HTTP error saat mengambil data (status '.$response->status().')');
            return Command::FAILURE;
        }

        $data = json_decode($response->body(), true);

        if (! is_array($data)) {
            $this->error('Format JSON tidak valid atau tidak sesuai harapan.');
            return Command::FAILURE;
        }

        $countTotal = 0;
        $countImported = 0;

        foreach ($data as $row) {
            if (! is_array($row)) {
                continue;
            }

            $rawKabupaten = $this->extractValue($row, ['Nama_Kabupaten', 'kabupaten', 'Kabupaten', 'nama_kabupaten']);
            $namaKabupaten = mb_strtoupper(trim($rawKabupaten));

            if ($namaKabupaten === '') {
                continue;
            }

            $namaKabupatenNormal = $this->normalizeKabupatenName($namaKabupaten);
            $targetNormal = $this->normalizeKabupatenName($kabupatenTarget);

            if ($namaKabupatenNormal !== $targetNormal) {
                continue;
            }

            $countTotal++;

            $namaKecamatan = trim($this->extractValue($row, ['Nama_Kecamatan', 'kecamatan', 'Kecamatan', 'nama_kecamatan']));
            $namaDesa = trim($this->extractValue($row, ['Nama_Desa', 'desa', 'Desa', 'nama_desa']));

            if ($namaDesa === '' || $namaKecamatan === '') {
                continue;
            }

            $districtName = $this->formatName($namaKecamatan);
            $villageName = $this->formatName($namaDesa);

            $kodeDesa = $row['Kode_Desa'] ?? $row['kode_desa'] ?? null;
            $kodeKecamatan = $row['Kode_Kecamatan'] ?? $row['kode_kecamatan'] ?? null;
            $kodeKabupaten = $row['Kode_Kabupaten'] ?? $row['kode_kabupaten'] ?? null;
            $kodeProvinsi = $row['Kode_Provinsi'] ?? $row['kode_provinsi'] ?? null;
            $kodePos = $row['Kode_Pos'] ?? $row['kode_pos'] ?? null;

            $slug = Str::slug($villageName.'-'.$districtName);

            Village::updateOrCreate(
                [
                    'district_name' => $districtName,
                    'village_name' => $villageName,
                ],
                [
                    'slug' => $slug,
                    'website_url' => null,
                    'api_endpoint' => null,
                    'platform' => 'data-wilayah',
                    'has_active_website' => false,
                    'population' => null,
                    'last_scraped_at' => null,
                    'source_meta' => [
                        'kode_desa' => $kodeDesa,
                        'kode_kecamatan' => $kodeKecamatan,
                        'kode_kabupaten' => $kodeKabupaten,
                        'kode_provinsi' => $kodeProvinsi,
                        'kode_pos' => $kodePos,
                        'source' => 'luffynas/Data-Wilayah',
                    ],
                ]
            );

            $countImported++;

            $this->line('• '.$villageName.' ('.$districtName.')');
        }

        $this->info('Total baris untuk kabupaten '.$kabupatenTarget.': '.$countTotal);
        $this->info('Desa yang diinsert/update: '.$countImported);

        return Command::SUCCESS;
    }

    protected function extractValue(array $row, array $keys): ?string
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $row) && $row[$key] !== null && $row[$key] !== '') {
                return (string) $row[$key];
            }
        }

        return null;
    }

    protected function normalizeKabupatenName(string $name): string
    {
        $name = mb_strtoupper($name);
        $name = preg_replace('/\b(KAB\.?|KABUPATEN)\b/u', '', $name);
        $name = preg_replace('/\s+/', ' ', (string) $name);

        return trim($name);
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
