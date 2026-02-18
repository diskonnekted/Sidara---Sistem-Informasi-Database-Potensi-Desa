<?php

namespace App\Console\Commands;

use App\Models\Potential;
use App\Models\Village;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportMedayuLapak extends Command
{
    protected $signature = 'sidara:import-medayu-lapak';

    protected $description = 'Impor produk UMKM dari lapak Desa Medayu menjadi potensi (1 produk 1 potensi)';

    public function handle(): int
    {
        $village = Village::query()
            ->where('village_name', 'Medayu')
            ->where('district_name', 'Wanadadi')
            ->first();

        if (! $village) {
            $this->error('Desa Medayu, Kecamatan Wanadadi tidak ditemukan di tabel villages.');

            return Command::FAILURE;
        }

        $products = [
            [
                'name' => 'SALE PISANG DAN SERIPING PISANG KAROMAH',
                'price' => 'Rp 45.000,00',
                'seller' => 'SARYUN YUNI SETIADI',
                'note' => null,
            ],
            [
                'name' => 'SUPER RENGGINAN',
                'price' => 'Rp 25.000,00',
                'seller' => 'MARSINAH',
                'note' => 'Hubungi penjual untuk harga lebih lanjut',
            ],
            [
                'name' => 'Jenang Tape AMalia',
                'price' => 'Rp 25.000,00',
                'seller' => 'JASWADI',
                'note' => 'Bisa hubungi penjual',
            ],
            [
                'name' => 'Telor Gabus dan Kripik',
                'price' => 'Rp 17.000,00',
                'seller' => 'RESTUTI',
                'note' => 'Harga bisa hubungi penjual',
            ],
        ];

        $created = 0;
        $updated = 0;

        foreach ($products as $product) {
            $title = trim($product['name']);

            $imageFile = $title.'.png';
            $imagePath = 'potensi/'.$imageFile;

            if (! file_exists(public_path($imagePath))) {
                $imagePath = null;
            }

            $payload = [
                'village_id' => $village->id,
                'title' => $title,
                'description' => $this->buildDescription($product),
                'price_range' => $product['price'],
                'location_address' => 'Desa Medayu, Kecamatan Wanadadi, Kabupaten Banjarnegara',
                'source' => 'api',
                'verification_status' => 'pending',
                'images' => $imagePath ? [$imagePath] : [],
                'attributes' => [
                    'village_website' => 'https://medayu-banjarnegara.desa.id/lapak',
                    'seller_name' => $product['seller'],
                    'raw_price' => $product['price'],
                    'note' => $product['note'],
                    'category' => 'umkm',
                    'image_file' => $imageFile,
                    'image_path' => $imagePath,
                ],
            ];

            $existing = Potential::query()
                ->where('village_id', $village->id)
                ->where('title', $title)
                ->where('source', 'api')
                ->first();

            if ($existing) {
                $existing->update($payload);
                $updated++;
                $this->line('• Update potensi: '.$title);
            } else {
                $payload['slug'] = $this->generateUniqueSlug($title.' '.$village->village_name);
                Potential::create($payload);
                $created++;
                $this->line('• Buat potensi: '.$title);
            }
        }

        $this->info('Selesai. Potensi dibuat: '.$created.', diperbarui: '.$updated);

        return Command::SUCCESS;
    }

    protected function buildDescription(array $product): string
    {
        $name = $product['name'];
        $seller = $product['seller'];
        $price = $product['price'];
        $note = $product['note'];

        $text = 'Produk UMKM Desa Medayu: '.$name.'. Diproduksi oleh '.$seller.'. '
            .'Harga tercantum '.$price.'. ';

        if ($note) {
            $text .= $note.' ';
        }

        $text .= 'Produk ini tercatat di lapak resmi Desa Medayu dan dapat dikembangkan '
            .'sebagai potensi ekonomi desa.';

        return $text;
    }

    protected function generateUniqueSlug(string $baseTitle): string
    {
        $base = Str::slug($baseTitle);

        if ($base === '') {
            $base = Str::slug('potensi-medayu-umkm');
        }

        $slug = $base;
        $i = 1;

        while (Potential::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
