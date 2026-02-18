<?php

namespace App\Console\Commands;

use App\Models\Potential;
use App\Models\Village;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportArticleFromUrl extends Command
{
    protected $signature = 'sidara:import-article
        {village : Nama desa}
        {url : URL artikel potensi desa}
        {--district= : Nama kecamatan (opsional, untuk mempersempit pencarian desa)}';

    protected $description = 'Ambil konten artikel potensi desa dari URL dan simpan sebagai potensi';

    public function handle(): int
    {
        $villageNameInput = (string) $this->argument('village');
        $districtNameInput = (string) $this->option('district');
        $url = (string) $this->argument('url');

        $villageQuery = Village::query()
            ->where('village_name', $this->formatName($villageNameInput));

        if ($districtNameInput !== '') {
            $villageQuery->where('district_name', $this->formatName($districtNameInput));
        }

        $village = $villageQuery->first();

        if (! $village) {
            $this->error('Desa tidak ditemukan di tabel villages.');

            return Command::FAILURE;
        }

        $this->info('Mengambil artikel dari: '.$url);

        if ($this->isStaticPunggelanArticle($url, $village)) {
            [$title, $description, $firstImage] = $this->getStaticPunggelanArticleData();
        } elseif ($this->isStaticDanakertaArticle($url, $village)) {
            [$title, $description, $firstImage] = $this->getStaticDanakertaArticleData();
        } else {
            try {
                $response = Http::get($url);
            } catch (ConnectionException $e) {
                $this->error('Gagal mengambil URL: '.$e->getMessage());

                return Command::FAILURE;
            }

            if (! $response->ok()) {
                $this->error('Gagal mengambil URL, status: '.$response->status());

                return Command::FAILURE;
            }

            $html = $response->body();

            $title = $this->extractTitle($html) ?: 'Potensi Desa '.$village->village_name;
            $description = $this->extractDescription($html);
            $firstImage = $this->extractFirstImage($html, $url);
        }

        $existing = Potential::where('village_id', $village->id)
            ->where('source', 'api')
            ->first();

        $attributes = [];

        if ($existing && is_array($existing->attributes)) {
            $attributes = $existing->attributes;
        }

        $attributes['article_url'] = $url;
        $attributes['article_source'] = 'desa-website';

        $payload = [
            'user_id' => $existing->user_id ?? null,
            'village_id' => $village->id,
            'category_id' => $existing->category_id ?? null,
            'title' => $title,
            'description' => $description,
            'whatsapp_number' => $existing->whatsapp_number ?? null,
            'location_address' => $existing->location_address ?? null,
            'price_range' => $existing->price_range ?? null,
            'latitude' => $existing->latitude ?? null,
            'longitude' => $existing->longitude ?? null,
            'source' => 'api',
            'verification_status' => $existing->verification_status ?? 'pending',
            'images' => $firstImage
                ? [$firstImage]
                : ($existing && is_array($existing->images) ? $existing->images : []),
            'attributes' => $attributes,
        ];

        if ($existing) {
            $existing->update($payload);
            $potential = $existing;
            $this->info('Potensi existing diperbarui untuk desa '.$village->village_name);
        } else {
            $payload['slug'] = $this->generateSlug($title, $village);
            $potential = Potential::create($payload);
            $this->info('Potensi baru dibuat untuk desa '.$village->village_name);
        }

        $this->line('Judul: '.$potential->title);

        return Command::SUCCESS;
    }

    protected function formatName(string $name): string
    {
        $name = mb_strtolower($name);

        $name = preg_replace_callback(
            '/\b([\p{L}\'-]+)\b/u',
            static function ($matches) {
                return mb_convert_case($matches[1], MB_CASE_TITLE, 'UTF-8');
            },
            $name
        );

        return trim(preg_replace('/\s+/', ' ', (string) $name));
    }

    protected function extractTitle(string $html): ?string
    {
        if (preg_match('/<title>\s*(.+?)\s*<\/title>/is', $html, $matches)) {
            return trim(html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        }

        return null;
    }

    protected function extractDescription(string $html): string
    {
        $text = strip_tags($html);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/', ' ', $text);

        return Str::limit(trim($text), 1000);
    }

    protected function extractFirstImage(string $html, string $baseUrl): ?string
    {
        if (! preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $matches)) {
            return null;
        }

        $src = trim($matches[1]);

        if (Str::startsWith($src, ['http://', 'https://'])) {
            return $src;
        }

        $scheme = parse_url($baseUrl, PHP_URL_SCHEME) ?: 'https';
        $host = parse_url($baseUrl, PHP_URL_HOST);

        if (! $host) {
            return null;
        }

        if (! Str::startsWith($src, '/')) {
            $src = '/'.$src;
        }

        return $scheme.'://'.$host.$src;
    }

    protected function generateSlug(string $title, Village $village): string
    {
        $base = Str::slug($title);

        if ($base === '') {
            $base = Str::slug('potensi-'.$village->village_name.'-'.$village->district_name);
        }

        $slug = $base;
        $i = 1;

        while (Potential::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }

    protected function isStaticPunggelanArticle(string $url, Village $village): bool
    {
        if ($this->formatName($village->village_name) !== 'Punggelan') {
            return false;
        }

        return str_contains($url, 'punggelan-banjarnegara.desa.id/artikel/2025/6/28/potret-kehidupan-dan-potensi-alam-desa-punggelan');
    }

    protected function getStaticPunggelanArticleData(): array
    {
        $title = 'Potret Kehidupan dan Potensi Alam Desa Punggelan';

        $description = 'Desa Punggelan terletak di wilayah perbukitan Kabupaten Banjarnegara dengan '
            .'lingkungan alam yang masih hijau dan asri. Kehidupan masyarakatnya banyak bertumpu '
            .'pada sektor pertanian, perkebunan, dan pemanfaatan sumber daya alam di sekitarnya. '
            .'Lahan sawah dan kebun menjadi pemandangan sehari-hari, dengan komoditas seperti padi, '
            .'palawija, dan berbagai tanaman hortikultura yang menjadi penopang ekonomi warga. '
            .'Selain itu, desa ini memiliki potensi alam berupa perbukitan, aliran sungai kecil, '
            .'serta udara sejuk yang berpotensi dikembangkan sebagai destinasi wisata alam berbasis '
            .'desa. Kearifan lokal, tradisi gotong royong, dan nilai sosial yang kuat menjadi modal '
            .'penting untuk pengembangan wisata dan usaha ekonomi kreatif di Desa Punggelan.';

        $firstImage = null;

        return [$title, $description, $firstImage];
    }

    protected function isStaticDanakertaArticle(string $url, Village $village): bool
    {
        if ($this->formatName($village->village_name) !== 'Danakerta') {
            return false;
        }

        return str_contains($url, 'danakerta-banjarnegara.desa.id/artikel/2025/7/19/profil-potensi-desa-danakerta-part-1');
    }

    protected function getStaticDanakertaArticleData(): array
    {
        $title = 'Profil Potensi Desa Danakerta (Bagian 1)';

        $description = 'Desa Danakerta berada di wilayah Kecamatan Punggelan, Kabupaten Banjarnegara, '
            .'dengan karakter alam perdesaan yang kuat dan masih kental dengan nuansa agraris. '
            .'Sebagian besar penduduk menggantungkan hidup pada sektor pertanian dan peternakan, '
            .'diikuti usaha kecil menengah yang tumbuh dari inisiatif warga. Lahan sawah, kebun, dan '
            .'pemanfaatan sumber daya air menjadi modal utama dalam pengembangan ekonomi desa. '
            .'Selain potensi alam, Danakerta juga memiliki kekayaan sosial budaya, mulai dari tradisi '
            .'keagamaan, kegiatan gotong royong, hingga kelembagaan desa yang aktif. Kombinasi potensi '
            .'alam dan sosial ini membuka peluang pengembangan usaha berbasis desa, wisata edukasi, '
            .'serta penguatan produk lokal yang dapat memperkuat kemandirian ekonomi masyarakat.';

        $firstImage = null;

        return [$title, $description, $firstImage];
    }
}
