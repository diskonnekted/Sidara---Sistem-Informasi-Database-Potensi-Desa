<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?php echo e($potential->title); ?> - SIDARA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""
  >
  <script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""
  ></script>
</head>
<body class="bg-[#f5f2ec] text-slate-900">
  <div class="min-h-screen flex flex-col">
    <header class="bg-emerald-900 text-emerald-50">
      <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2">
          <img
            src="<?php echo e(asset('logo.jpeg')); ?>"
            alt="Logo SIDARA"
            class="w-8 h-8 rounded-xl object-contain bg-emerald-700/80 p-1"
          >
          <div>
            <div class="text-xs font-semibold tracking-wide uppercase">SIDARA</div>
            <div class="text-[11px] text-emerald-100">Potensi Desa Banjarnegara</div>
          </div>
        </a>
        <a href="<?php echo e(route('map')); ?>" class="hidden sm:inline-flex items-center gap-2 text-xs font-medium px-3 py-1.5 rounded-full bg-emerald-800 border border-emerald-600">
          <span>Lihat Peta Desa</span>
        </a>
      </div>
    </header>

    <main class="flex-1">
      <div class="max-w-5xl mx-auto px-4 py-5 md:py-8">
        <div class="grid md:grid-cols-[2fr,1fr] gap-6 md:gap-8 items-start">
          <section class="bg-white rounded-3xl border border-amber-100 shadow-sm overflow-hidden">
            <?php
              $firstImage = $potential->images[0] ?? null;
              if ($firstImage) {
                  if (preg_match('/^https?:\/\//i', $firstImage)) {
                      $firstImageUrl = $firstImage;
                  } elseif (str_starts_with($firstImage, 'storage/') || str_starts_with($firstImage, 'potensi/') || str_starts_with($firstImage, 'images/')) {
                      $firstImageUrl = asset($firstImage);
                  } else {
                      $firstImageUrl = asset('storage/'.$firstImage);
                  }
              } else {
                  $firstImageUrl = 'https://images.pexels.com/photos/2403207/pexels-photo-2403207.jpeg';
              }
            ?>
            <div class="relative">
              <img
                src="<?php echo e($firstImageUrl); ?>"
                alt="<?php echo e($potential->title); ?>"
                class="w-full h-52 md:h-64 object-cover"
              >
              <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
              <div class="absolute bottom-3 left-4 right-4 flex flex-wrap items-center justify-between gap-2">
                <div class="space-y-1">
                  <h1 class="text-lg md:text-xl font-semibold text-white leading-snug">
                    <?php echo e($potential->title); ?>

                  </h1>
                  <div class="flex flex-wrap items-center gap-2 text-[11px]">
                    <?php if($potential->village): ?>
                      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-white/10 border border-white/30 text-white">
                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none">
                          <path d="M12 21C12 21 5 14.6863 5 10C5 6.68629 7.68629 4 11 4H13C16.3137 4 19 6.68629 19 10C19 14.6863 12 21 12 21Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"></path>
                          <circle cx="12" cy="10" r="2.25" stroke="currentColor" stroke-width="1.5"></circle>
                        </svg>
                        <?php echo e($potential->village->village_name); ?>

                      </span>
                    <?php endif; ?>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-500/90 text-emerald-50 border border-emerald-300/60">
                      Potensi Desa
                    </span>
                    <?php if($potential->verification_status === 'verified'): ?>
                      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Data terverifikasi
                      </span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="p-4 md:p-6 space-y-5">
              <div class="space-y-1">
                <h2 class="text-sm font-semibold text-slate-900">Deskripsi</h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                  <?php echo e($potential->description ?: 'Belum ada deskripsi rinci untuk potensi ini.'); ?>

                </p>
              </div>

              <?php if(is_array($potential->images) && count($potential->images) > 1): ?>
                <div class="space-y-2">
                  <h2 class="text-sm font-semibold text-slate-900">Galeri Foto</h2>
                  <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                    <?php $__currentLoopData = $potential->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php
                        $src = $img;
                        if ($img) {
                            if (!preg_match('/^https?:\/\//i', $img)) {
                                if (str_starts_with($img, 'storage/') || str_starts_with($img, 'potensi/') || str_starts_with($img, 'images/')) {
                                    $src = asset($img);
                                } else {
                                    $src = asset('storage/'.$img);
                                }
                            }
                        }
                      ?>
                      <img src="<?php echo e($src); ?>" alt="Foto <?php echo e($potential->title); ?>" class="w-full h-20 object-cover rounded-xl border border-slate-100">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>
                </div>
              <?php endif; ?>

              <div class="grid sm:grid-cols-3 gap-4 text-sm">
                <div class="bg-slate-50 rounded-2xl border border-slate-100 p-3.5 space-y-1.5">
                  <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Alamat Lokasi</p>
                  <p class="text-sm font-semibold text-slate-900">
                    <?php echo e($potential->location_address ?: 'Dusun/RT/RW belum diisi'); ?>

                  </p>
                  <?php if($potential->village): ?>
                    <p class="text-[11px] text-slate-500">
                      <?php echo e($potential->village->village_name); ?>, <?php echo e($potential->village->district_name ?? 'Banjarnegara'); ?>

                    </p>
                  <?php endif; ?>
                </div>
                <div class="bg-slate-50 rounded-2xl border border-slate-100 p-3.5 space-y-1.5">
                  <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Kontak</p>
                  <p class="text-sm font-semibold text-slate-900">
                    <?php if($potential->whatsapp_number): ?>
                      <?php echo e($potential->whatsapp_number); ?>

                    <?php else: ?>
                      Belum ada nomor WhatsApp
                    <?php endif; ?>
                  </p>
                  <p class="text-[11px] text-slate-500">
                    Kontak langsung ke pengelola potensi.
                  </p>
                </div>
                <div class="bg-slate-50 rounded-2xl border border-slate-100 p-3.5 space-y-1.5">
                  <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Status</p>
                  <p class="text-sm font-semibold text-slate-900">
                    <?php if(($potential->attributes['owner_type'] ?? null) === 'bumdes'): ?>
                      Milik BUMDes
                    <?php elseif(($potential->attributes['owner_type'] ?? null) === 'warga'): ?>
                      Usaha Warga
                    <?php else: ?>
                      <?php echo e(ucfirst($potential->verification_status)); ?>

                    <?php endif; ?>
                  </p>
                  <p class="text-[11px] text-slate-500">
                    Ditampilkan untuk menambah kepercayaan pengunjung/pembeli.
                  </p>
                </div>
              </div>

              <div class="grid sm:grid-cols-3 gap-4 text-sm">
                <div class="bg-slate-50 rounded-2xl border border-slate-100 p-3.5 space-y-1.5">
                  <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Lokasi</p>
                  <p class="text-sm font-semibold text-slate-900">
                    <?php if($potential->village): ?>
                      <?php echo e($potential->village->village_name); ?>

                    <?php else: ?>
                      Tidak tercatat
                    <?php endif; ?>
                  </p>
                  <?php if($potential->village): ?>
                    <p class="text-[11px] text-slate-500">
                      <?php echo e($potential->village->district_name ?? 'Banjarnegara'); ?>

                    </p>
                  <?php endif; ?>
                </div>
                <div class="bg-slate-50 rounded-2xl border border-slate-100 p-3.5 space-y-1.5">
                  <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Kisaran Harga</p>
                  <p class="text-sm font-semibold text-slate-900">
                    <?php echo e($potential->price_range ?: 'Info harga di lokasi'); ?>

                  </p>
                  <p class="text-[11px] text-slate-500">
                    Nilai indikatif, dapat berubah sesuai kebijakan pengelola.
                  </p>
                </div>
                <div class="bg-slate-50 rounded-2xl border border-slate-100 p-3.5 space-y-1.5">
                  <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Koordinat</p>
                  <?php if($potential->latitude && $potential->longitude): ?>
                    <p class="text-sm font-semibold text-slate-900">
                      <?php echo e($potential->latitude); ?>, <?php echo e($potential->longitude); ?>

                    </p>
                    <p class="text-[11px] text-slate-500">
                      Titik estimasi untuk navigasi peta.
                    </p>
                  <?php else: ?>
                    <p class="text-sm font-semibold text-slate-900">
                      Belum tersedia
                    </p>
                    <p class="text-[11px] text-slate-500">
                      Koordinat akan diisi oleh admin desa.
                    </p>
                  <?php endif; ?>
                </div>
              </div>

              <div class="space-y-2">
                <h2 class="text-sm font-semibold text-slate-900">Informasi Tambahan</h2>
                <ul class="text-sm text-slate-600 space-y-1.5">
                  <li>Sumber data: <?php echo e($potential->source === 'api' ? 'Sinkronisasi website desa' : 'Input manual'); ?></li>
                  <li>Status verifikasi: <?php echo e(ucfirst($potential->verification_status)); ?></li>
                </ul>
              </div>
            </div>
          </section>

          <aside class="space-y-4 md:space-y-5">
            <div class="bg-white rounded-3xl border border-amber-100 p-4 md:p-5 space-y-3">
              <h2 class="text-sm font-semibold text-slate-900">Kontak dan Aksi</h2>
              <p class="text-[11px] text-slate-600">
                Hubungi pengelola atau buka lokasi di peta untuk navigasi langsung ke desa.
              </p>
              <div class="flex flex-col gap-2">
                <a
                  href="<?php echo e($potential->whatsapp_number ? 'https://wa.me/'.$potential->whatsapp_number : '#'); ?>"
                  <?php if($potential->whatsapp_number): ?> target="_blank" <?php endif; ?>
                  class="inline-flex items-center justify-center gap-2 text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl px-3 py-2"
                >
                  <span>Hubungi via WhatsApp</span>
                </a>
                <?php if($potential->latitude && $potential->longitude): ?>
                  <a
                    href="https://www.google.com/maps?q=<?php echo e($potential->latitude); ?>,<?php echo e($potential->longitude); ?>"
                    target="_blank"
                    class="inline-flex items-center justify-center gap-2 text-xs font-semibold border border-emerald-600 text-emerald-700 rounded-xl px-3 py-2 bg-emerald-50 hover:bg-emerald-100"
                  >
                    <span>Lihat Lokasi di Google Maps</span>
                  </a>
                <?php else: ?>
                  <a href="<?php echo e(route('map')); ?>" class="inline-flex items-center justify-center gap-2 text-xs font-semibold border border-emerald-600 text-emerald-700 rounded-xl px-3 py-2 bg-emerald-50 hover:bg-emerald-100">
                    <span>Lihat di Peta Desa</span>
                  </a>
                <?php endif; ?>
              </div>
            </div>

            <div class="bg-emerald-900 text-emerald-50 rounded-3xl p-4 md:p-5 space-y-2">
              <p class="text-xs font-semibold tracking-wide uppercase text-emerald-200">
                Untuk Admin Desa
              </p>
              <p class="text-[11px] text-emerald-50">
                Jika informasi ini perlu diperbarui, admin desa dapat masuk ke dashboard SIDARA
                dan mengedit data potensi ini.
              </p>
            </div>

            <div class="bg-white rounded-3xl border border-amber-100 p-4 md:p-5 space-y-3">
              <h2 class="text-sm font-semibold text-slate-900">Peta Desa (OSM)</h2>
              <?php if($potential->latitude && $potential->longitude): ?>
                <div
                  id="village-map"
                  class="w-full h-52 md:h-64 rounded-2xl overflow-hidden border border-amber-100"
                ></div>
                <p class="text-[11px] text-slate-500">
                  Peta menggunakan OpenStreetMap dengan titik estimasi lokasi potensi desa.
                </p>
              <?php else: ?>
                <p class="text-[11px] text-slate-500">
                  Koordinat belum diisi. Admin desa dapat menambahkan latitude dan longitude agar peta tampil di sini.
                </p>
              <?php endif; ?>
            </div>
          </aside>
        </div>
      </div>
    </main>

    <nav class="fixed bottom-0 inset-x-0 z-20 md:hidden">
      <div class="mx-auto max-w-md px-4 pb-3">
        <div class="bg-white rounded-2xl shadow-xl border border-amber-100 px-4 py-1.5 flex justify-between">
          <a href="<?php echo e(route('home')); ?>" class="flex flex-col items-center justify-center flex-1 py-1.5 text-slate-500">
            <svg class="w-5 h-5 mb-0.5" viewBox="0 0 24 24" fill="none">
              <path d="M5 11L12 4L19 11V19C19 19.5523 18.5523 20 18 20H6C5.44772 20 5 19.5523 5 19V11Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"></path>
              <path d="M10 20V14H14V20" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="text-[10px] font-medium">Beranda</span>
          </a>
          <span class="flex flex-col items-center justify-center flex-1 py-1.5 text-emerald-700">
            <svg class="w-5 h-5 mb-0.5" viewBox="0 0 24 24" fill="none">
              <circle cx="11" cy="11" r="5" stroke="currentColor" stroke-width="1.6"></circle>
              <path d="M15.5 15.5L19 19" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"></path>
            </svg>
            <span class="text-[10px] font-semibold">Detail</span>
          </span>
          <a href="<?php echo e(route('map')); ?>" class="flex flex-col items-center justify-center flex-1 py-1.5 text-slate-500">
            <svg class="w-5 h-5 mb-0.5" viewBox="0 0 24 24" fill="none">
              <path d="M8 7C8 5.89543 8.89543 5 10 5H14C15.1046 5 16 5.89543 16 7V9C16 10.1046 15.1046 11 14 11H10C8.89543 11 8 10.1046 8 9V7Z" stroke="currentColor" stroke-width="1.6"></path>
              <path d="M5 17C5 15.8954 5.89543 15 7 15H17C18.1046 15 19 15.8954 19 17V18C19 18.5523 18.5523 19 18 19H6C5.44772 19 5 18.5523 5 18V17Z" stroke="currentColor" stroke-width="1.6"></path>
            </svg>
            <span class="text-[10px] font-medium">Peta</span>
          </a>
          <a href="#" class="flex flex-col items-center justify-center flex-1 py-1.5 text-slate-500">
            <svg class="w-5 h-5 mb-0.5" viewBox="0 0 24 24" fill="none">
              <circle cx="12" cy="9" r="3" stroke="currentColor" stroke-width="1.6"></circle>
              <path d="M7 19C7.80377 17.136 9.70189 16 12 16C14.2981 16 16.1962 17.136 17 19" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"></path>
            </svg>
            <span class="text-[10px] font-medium">Akun</span>
          </a>
        </div>
      </div>
    </nav>
  </div>

  <?php if($potential->latitude && $potential->longitude): ?>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var mapContainer = document.getElementById('village-map');
        if (!mapContainer || typeof L === 'undefined') {
          return;
        }

        var lat = parseFloat(<?php echo json_encode($potential->latitude, 15, 512) ?>);
        var lng = parseFloat(<?php echo json_encode($potential->longitude, 15, 512) ?>);

        if (isNaN(lat) || isNaN(lng)) {
          return;
        }

        var map = L.map('village-map').setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
          .bindPopup(<?php echo json_encode($potential->title, 15, 512) ?>)
          .openPopup();
      });
    </script>
  <?php endif; ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\sidara\laravel\resources\views/potentials/show.blade.php ENDPATH**/ ?>