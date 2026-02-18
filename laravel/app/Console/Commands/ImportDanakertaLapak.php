<?php

namespace App\Console\Commands;

use App\Models\Potential;
use App\Models\Village;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportDanakertaLapak extends Command
{
    protected $signature = 'sidara:import-danakerta-lapak';

    protected $description = 'Ganti potensi Desa Danakerta dari artikel dengan potensi UMKM dari lapak desa';

    public function handle(): int
    {
        $village = Village::query()
            ->where('village_name', 'Danakerta')
            ->where('district_name', 'Punggelan')
            ->first();

        if (! $village) {
            $this->error('Desa Danakerta, Kecamatan Punggelan tidak ditemukan di tabel villages.');

            return Command::FAILURE;
        }

        $deleted = Potential::query()
            ->where('village_id', $village->id)
            ->where('attributes->article_source', 'desa-website')
            ->delete();

        if ($deleted > 0) {
            $this->info('Menghapus '.$deleted.' potensi Danakerta yang berasal dari artikel desa.');
        }

        $products = [
            [
                'name' => 'Sanggar Seni Campursari NEW SETYA NADA',
                'price' => 'Rp 1.000.000,00',
                'description' => 'Layanan Sanggar Seni Campursari NEW SETYA NADA meliputi pertunjukan dangdut, campursari, '
                    .'lengger/orleng, dan MC untuk berbagai acara di Desa Danakerta dan sekitarnya.',
            ],
            [
                'name' => 'DC HNI UMI ROKHYATUN',
                'price' => 'Rp 100,00',
                'description' => 'DC HNI UMI ROKHYATUN melayani kebutuhan produk-produk herbal HNI, pendaftaran agen dan stockist, '
                    .'konsultasi kesehatan dan bisnis HNI, serta penjualan berbagai produk herba, suplemen, madu, vitamin, '
                    .'skincare, kosmetik, home care, pakaian, dan lainnya.',
            ],
            [
                'name' => 'AGEN BRILINK TOKO AWAL USAHA ADMINAH',
                'price' => 'Rp 5.000,00',
                'description' => 'Agen BRILink Toko Awal Usaha Adminah menyediakan layanan mini ATM, transfer bank, pembayaran listrik, '
                    .'cicilan, token listrik, pembelian pulsa, pembayaran angsuran, BPJS, top up BRIZZI, serta layanan TBank '
                    .'untuk setor tunai, tarik tunai, dan registrasi tanpa harus ke bank.',
            ],
            [
                'name' => 'Rumah Jahit AGHA COLLECTION',
                'price' => 'Rp 100.000,00',
                'description' => 'Rumah Jahit AGHA COLLECTION melayani pembuatan seragam sekolah, seragam karyawan, kemeja, gamis, '
                    .'blus, kebaya, taplak meja, gorden, serta layanan obras, kancing, permak baju dan celana. Juga menjual '
                    .'alat makan dan minum bayi.',
            ],
            [
                'name' => 'Citra Arum',
                'price' => 'Rp 15.000,00',
                'description' => 'Citra Arum melayani jual beli buah Jambu Citra dan kebutuhan bibit Jambu Citra, dengan layanan '
                    .'pengiriman ke berbagai wilayah di Indonesia.',
            ],
            [
                'name' => 'KOPI MBOK WARNI',
                'price' => 'Rp 70.000,00',
                'description' => 'KOPI MBOK WARNI memproduksi dan menjual kopi bubuk khas nusantara dengan cita rasa kuat, '
                    .'melayani penjualan eceran maupun grosir untuk memenuhi kebutuhan kopi berkualitas.',
            ],
        ];

        $created = 0;
        $updated = 0;

        $imageMap = [
            'Sanggar Seni Campursari NEW SETYA NADA' => 'danakerta-sanggar-seni.jpg',
            'DC HNI UMI ROKHYATUN' => 'danakerta-dc-hni.png',
            'AGEN BRILINK TOKO AWAL USAHA ADMINAH' => 'danakerta-agen-brilink.jpg',
            'Rumah Jahit AGHA COLLECTION' => 'danakerta-rumah-jahit.jpg',
            'Citra Arum' => 'danakerta-citra-arum.jpg',
            'KOPI MBOK WARNI' => 'danakerta-kopi-mbok.jpeg',
        ];

        foreach ($products as $product) {
            $title = trim($product['name']);

            $imageFile = $imageMap[$title] ?? null;
            $imagePath = $imageFile ? 'potensi/'.$imageFile : null;

            $payload = [
                'village_id' => $village->id,
                'title' => $title,
                'description' => $this->buildDescription($product),
                'price_range' => $product['price'],
                'location_address' => 'Desa Danakerta, Kecamatan Punggelan, Kabupaten Banjarnegara',
                'source' => 'api',
                'verification_status' => 'pending',
                'images' => $imagePath ? [$imagePath] : [],
                'attributes' => [
                    'village_website' => 'https://danakerta-banjarnegara.desa.id/lapak',
                    'raw_price' => $product['price'],
                    'raw_description' => $product['description'],
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
        $price = $product['price'];
        $desc = $product['description'];

        $text = 'Potensi UMKM Desa Danakerta: '.$name.'. ';
        $text .= $desc.' ';
        $text .= 'Harga tercantum '.$price.'. ';
        $text .= 'Informasi sumber diambil dari halaman lapak resmi Desa Danakerta.';

        return $text;
    }

    protected function generateUniqueSlug(string $baseTitle): string
    {
        $base = Str::slug($baseTitle);

        if ($base === '') {
            $base = Str::slug('potensi-danakerta-umkm');
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
