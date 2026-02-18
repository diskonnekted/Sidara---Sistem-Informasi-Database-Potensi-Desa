<?php

namespace App\Console\Commands;

use App\Models\Potential;
use App\Models\Village;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GeneratePotentialsFromVillages extends Command
{
    protected $signature = 'sidara:generate-potentials-from-villages 
        {--only-with-website=1 : Hanya desa yang memiliki URL website} 
        {--verification=pending : Status verifikasi default (pending/verified/rejected)}';

    protected $description = 'Buat satu potensi placeholder untuk setiap desa berdasarkan daftar desa SID (tabel villages)';

    public function handle(): int
    {
        $onlyWithWebsite = (bool) (int) $this->option('only-with-website');
        $verification = $this->option('verification');

        if (! in_array($verification, ['pending', 'verified', 'rejected'], true)) {
            $this->error('Opsi --verification harus salah satu dari: pending, verified, rejected');

            return Command::FAILURE;
        }

        $query = Village::query();

        if ($onlyWithWebsite) {
            $query->whereNotNull('website_url')
                ->where('website_url', '!=', '');
        }

        $villages = $query->orderBy('district_name')
            ->orderBy('village_name')
            ->get();

        if ($villages->isEmpty()) {
            $this->warn('Tidak ada desa yang ditemukan di tabel villages.');

            return Command::SUCCESS;
        }

        $this->info('Ditemukan '.$villages->count().' desa. Membuat potensi placeholder (satu per desa)...');

        $created = 0;
        $updated = 0;

        foreach ($villages as $village) {
            $baseTitle = 'Potensi Desa '.$village->village_name;
            $slug = $this->generateUniqueSlug($baseTitle.' '.$village->district_name);

            $payload = [
                'user_id' => null,
                'village_id' => $village->id,
                'category_id' => null,
                'title' => $baseTitle,
                'slug' => $slug,
                'description' => 'Entri awal potensi desa untuk '.$village->village_name.' ('.$village->district_name.'). Silakan perbarui data ini dari panel admin.',
                'whatsapp_number' => null,
                'location_address' => null,
                'price_range' => null,
                'latitude' => null,
                'longitude' => null,
                'source' => 'api',
                'verification_status' => $verification,
                'images' => [],
                'attributes' => [
                    'source' => 'sid.clasnet.co.id/desa.php',
                    'website_url' => $village->website_url,
                ],
            ];

            $existing = Potential::where('village_id', $village->id)
                ->where('source', 'api')
                ->first();

            if ($existing) {
                $existing->update($payload);
                $updated++;
                $this->line('• Update potensi untuk '.$village->village_name.' ('.$village->district_name.')');
            } else {
                Potential::create($payload);
                $created++;
                $this->line('• Buat potensi untuk '.$village->village_name.' ('.$village->district_name.')');
            }
        }

        $this->info('Selesai. Potensi dibuat: '.$created.', diperbarui: '.$updated);

        return Command::SUCCESS;
    }

    protected function generateUniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $suffix = 1;

        while (Potential::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }
}

