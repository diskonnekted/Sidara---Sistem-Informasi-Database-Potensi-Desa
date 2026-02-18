<?php

namespace App\Console\Commands;

use App\Models\Village;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class ImportVillages extends Command
{
    protected $signature = 'sidara:import-villages {--pages=4}';

    protected $description = 'Import daftar desa dari sid.clasnet.co.id ke tabel villages';

    public function handle(): int
    {
        $baseUrl = 'https://sid.clasnet.co.id/desa.php?page=';
        $totalPages = (int) $this->option('pages');

        for ($page = 1; $page <= $totalPages; $page++) {
            $this->info('Memproses halaman '.$page);

            $response = Http::get($baseUrl.$page);

            if (! $response->ok()) {
                $this->error('Gagal mengambil halaman '.$page.' (status '.$response->status().')');
                continue;
            }

            $crawler = new Crawler($response->body());

            $rows = $crawler->filter('table tbody tr');

            if (! $rows->count()) {
                $this->warn('Tidak ada baris pada halaman '.$page);
                continue;
            }

            $rows->each(function (Crawler $row) {
                $cells = $row->filter('td');

                if ($cells->count() < 3) {
                    return;
                }

                $rawDistrict = trim($cells->eq(1)->text());
                $districtName = $this->formatName(preg_replace('/^Kecamatan\s+/i', '', $rawDistrict) ?: $rawDistrict);

                $villageCell = $cells->eq(2);
                $rawVillageName = trim($villageCell->text());
                $villageName = $this->formatName(preg_replace('/^Desa\s+/i', '', $rawVillageName) ?: $rawVillageName);

                $websiteUrl = $this->extractWebsiteUrlFromRow($cells);

                $cekTerakhir = null;
                $rawPopulation = null;
                $population = null;
                $dbPendudukStatus = null;

                if ($cells->count() >= 7) {
                    $cekTerakhir = trim($cells->eq($cells->count() - 3)->text());
                    $rawPopulation = trim($cells->eq($cells->count() - 2)->text());
                    $dbPendudukStatus = trim($cells->eq($cells->count() - 1)->text());
                    $population = $this->parsePopulation($rawPopulation);
                }

                $platform = 'unknown';

                if ($websiteUrl && Str::contains($websiteUrl, ['desa.id', 'des.id', 'sid'])) {
                    $platform = 'opensid';
                }

                Village::updateOrCreate(
                    [
                        'district_name' => $districtName,
                        'village_name' => $villageName,
                    ],
                    [
                        'slug' => Str::slug($villageName.'-'.$districtName),
                        'website_url' => $websiteUrl,
                        'api_endpoint' => null,
                        'platform' => $platform,
                        'has_active_website' => (bool) $websiteUrl && $dbPendudukStatus === 'Sudah Ada',
                        'population' => $population,
                        'source_meta' => [
                            'source' => 'sid.clasnet.co.id/desa.php',
                            'last_checked_at' => $cekTerakhir,
                            'db_penduduk_status' => $dbPendudukStatus,
                            'raw_population' => $rawPopulation,
                        ],
                    ]
                );

                $this->info('Import '.$villageName.' ('.$districtName.')');
            });
        }

        $this->info('Import desa selesai');

        return Command::SUCCESS;
    }

    protected function extractWebsiteUrlFromRow(Crawler $cells): ?string
    {
        $websiteUrl = null;

        foreach ($cells as $cellElement) {
            $cell = new Crawler($cellElement);

            $linkNode = $cell->filter('a[href^="http"]');

            if ($linkNode->count()) {
                $websiteUrl = trim($linkNode->attr('href'));
                break;
            }

            $text = trim($cell->text());

            if ($text && Str::startsWith($text, ['http://', 'https://'])) {
                $websiteUrl = $text;
                break;
            }
        }

        return $websiteUrl ?: null;
    }

    protected function parsePopulation(?string $raw): ?int
    {
        if (! $raw) {
            return null;
        }

        $clean = str_replace(['.', ',', ' '], '', $raw);

        if (! ctype_digit($clean)) {
            return null;
        }

        return (int) $clean;
    }

    protected function formatName(string $name): string
    {
        $name = strtolower(trim($name));

        if ($name === '') {
            return $name;
        }

        return collect(explode(' ', $name))
            ->filter()
            ->map(function ($word) {
                return mb_strtoupper(mb_substr($word, 0, 1), 'UTF-8')
                    . mb_substr($word, 1);
            })
            ->implode(' ');
    }
}
