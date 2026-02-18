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

                $districtName = trim($cells->eq(1)->text());
                $villageCell = $cells->eq(2);
                $villageName = trim($villageCell->text());

                $linkNode = $villageCell->filter('a');
                $websiteUrl = null;

                if ($linkNode->count()) {
                    $websiteUrl = trim($linkNode->attr('href'));
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
                        'website_url' => $websiteUrl,
                        'api_endpoint' => null,
                        'platform' => $platform,
                        'has_active_website' => (bool) $websiteUrl,
                    ]
                );

                $this->info('Import '.$villageName.' ('.$districtName.')');
            });
        }

        $this->info('Import desa selesai');

        return Command::SUCCESS;
    }
}

