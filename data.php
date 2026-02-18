<?php

function sidara_potentials(): array
{
    return [
        [
            'slug' => 'wisata-curug-pletuk',
            'title' => 'Wisata Curug Pletuk',
            'district_name' => 'Banjarnegara',
            'village_name' => 'Pagedongan',
            'category' => 'Wisata',
            'description' => 'Curug dengan panorama hijau dan akses yang mudah dijangkau dari jalan utama.',
            'price_range' => 'Rp 10.000',
            'image' => 'https://images.pexels.com/photos/2403207/pexels-photo-2403207.jpeg',
            'latitude' => -7.12345,
            'longitude' => 109.12345,
        ],
        [
            'slug' => 'kopi-arabika-dieng',
            'title' => 'Kopi Arabika Dieng – UMKM Binaan Desa',
            'district_name' => 'Batur',
            'village_name' => 'Batur',
            'category' => 'UMKM',
            'description' => 'Produk kopi arabika dengan cita rasa khas dataran tinggi Dieng, dikelola oleh kelompok tani muda desa.',
            'price_range' => 'Mulai Rp 35.000 / 200gr',
            'image' => 'https://images.pexels.com/photos/894695/pexels-photo-894695.jpeg',
            'latitude' => -7.2,
            'longitude' => 109.9,
        ],
        [
            'slug' => 'lahan-pertanian-hortikultura',
            'title' => 'Lahan Pertanian Terintegrasi Hortikultura',
            'district_name' => 'Banjarnegara',
            'village_name' => 'Susukan',
            'category' => 'Pertanian',
            'description' => 'Sentra produksi hortikultura dengan model kemitraan petani dan BUMDes.',
            'price_range' => 'Nilai investasi variatif',
            'image' => 'https://images.pexels.com/photos/2968938/pexels-photo-2968938.jpeg',
            'latitude' => -7.4,
            'longitude' => 109.6,
        ],
    ];
}

function sidara_filter_potentials(array $potentials, string $q, string $district): array
{
    $q = mb_strtolower(trim($q));
    $district = mb_strtolower(trim($district));

    return array_values(array_filter($potentials, function (array $p) use ($q, $district) {
        if ($q !== '') {
            $haystack = mb_strtolower($p['title'] . ' ' . $p['description'] . ' ' . $p['village_name'] . ' ' . $p['district_name']);
            if (mb_strpos($haystack, $q) === false) {
                return false;
            }
        }

        if ($district !== '') {
            if (mb_strtolower($p['district_name']) !== $district) {
                return false;
            }
        }

        return true;
    }));
}

function sidara_find_potential(string $slug): ?array
{
    foreach (sidara_potentials() as $p) {
        if ($p['slug'] === $slug) {
            return $p;
        }
    }

    return null;
}

