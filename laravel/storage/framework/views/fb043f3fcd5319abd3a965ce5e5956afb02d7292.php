<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?php echo e($mode === 'edit' ? 'Edit Potensi Desa' : 'Tambah Potensi Desa'); ?> - SIDARA</title>
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
<body class="bg-slate-950 text-slate-100">
  <div class="min-h-screen flex flex-col">
    <header class="border-b border-slate-800 bg-slate-950/80 backdrop-blur px-4 md:px-6 py-3 flex items-center justify-between gap-3">
      <div>
        <div class="flex items-center gap-2 text-xs text-emerald-300">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
          <span>Panel Admin SIDARA</span>
        </div>
        <h1 class="text-sm md:text-base font-semibold text-slate-50">
          <?php echo e($mode === 'edit' ? 'Edit potensi desa' : 'Tambah potensi desa'); ?>

        </h1>
      </div>
      <div class="flex items-center gap-2 text-[11px]">
        <a href="<?php echo e(route('admin.potentials.index')); ?>" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-slate-900 border border-slate-700 text-slate-200">
          <span>Kembali ke daftar</span>
        </a>
      </div>
    </header>

    <main class="flex-1 px-4 md:px-6 py-4 md:py-6">
      <section class="max-w-3xl mx-auto bg-slate-900 rounded-2xl border border-slate-800 p-3 md:p-5 space-y-4">
        <?php if($errors->any()): ?>
          <div class="rounded-2xl border border-rose-500/40 bg-rose-500/10 text-rose-100 px-3 py-2 text-[11px]">
            <div class="font-semibold mb-1">Terjadi kesalahan:</div>
            <ul class="list-disc list-inside space-y-0.5">
              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
        <?php endif; ?>

        <?php
          $action = $mode === 'edit'
            ? route('admin.potentials.update', $potential)
            : route('admin.potentials.store');
        ?>

        <form method="POST" action="<?php echo e($action); ?>" enctype="multipart/form-data" class="space-y-4 text-[13px]">
          <?php echo csrf_field(); ?>
          <?php if($mode === 'edit'): ?>
            <?php echo method_field('PUT'); ?>
          <?php endif; ?>

          <div class="grid md:grid-cols-2 gap-4">
            <div class="space-y-1.5">
              <label class="block text-[11px] font-semibold text-slate-200">
                Desa
              </label>
              <select
                name="village_id"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-slate-100 text-[13px]"
                required
              >
                <option value="">Pilih desa</option>
                <?php $__currentLoopData = $villages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $village): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($village->id); ?>" <?php if(old('village_id', $potential->village_id) == $village->id): ?> selected <?php endif; ?>>
                    <?php echo e($village->village_name); ?> - <?php echo e($village->district_name); ?>

                  </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div class="space-y-1.5">
              <label class="block text-[11px] font-semibold text-slate-200">
                Status verifikasi
              </label>
              <select
                name="verification_status"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-slate-100 text-[13px]"
              >
                <?php $currentStatus = old('verification_status', $potential->verification_status ?: 'pending'); ?>
                <option value="pending" <?php if($currentStatus === 'pending'): ?> selected <?php endif; ?>>Menunggu</option>
                <option value="verified" <?php if($currentStatus === 'verified'): ?> selected <?php endif; ?>>Terverifikasi</option>
                <option value="rejected" <?php if($currentStatus === 'rejected'): ?> selected <?php endif; ?>>Ditolak</option>
              </select>
            </div>
          </div>

          <div class="space-y-2">
            <div class="flex items-center justify-between">
              <label class="block text-[11px] font-semibold text-slate-200">
                Foto utama dan galeri
              </label>
              <?php if($mode === 'edit' && $potential->images): ?>
                <label class="inline-flex items-center gap-1.5 text-[11px] text-slate-400">
                  <input type="checkbox" name="reset_images" value="1" class="rounded border-slate-600 bg-slate-950 text-emerald-500">
                  <span>Hapus semua foto lama</span>
                </label>
              <?php endif; ?>
            </div>
            <input
              type="file"
              name="images[]"
              multiple
              accept="image/*"
              class="w-full text-[11px] text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-emerald-600 file:text-slate-950 bg-slate-950 border border-slate-700 rounded-xl px-2 py-1.5"
            >
            <?php if($mode === 'edit' && $potential->images): ?>
              <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 mt-2">
                <?php $__currentLoopData = $potential->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php
                    $src = $img;
                    if ($img && !preg_match('/^https?:\/\//i', $img)) {
                      $src = asset('storage/'.$img);
                    }
                  ?>
                  <div class="relative group">
                    <img src="<?php echo e($src); ?>" alt="Foto potensi" class="w-full h-20 object-cover rounded-xl border border-slate-700">
                    <button type="button" data-index="<?php echo e($index); ?>" class="delete-image-btn absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity w-5 h-5 flex items-center justify-center bg-rose-500 hover:bg-rose-400 text-white rounded-full text-xs">
                      &times;
                    </button>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            <?php endif; ?>
            <p class="text-[11px] text-slate-500">
              Anda dapat mengunggah beberapa foto sekaligus. Format didukung: JPG, PNG, WEBP. Maksimal 2MB per file.
            </p>
          </div>

          <div class="space-y-1.5">
            <label class="block text-[11px] font-semibold text-slate-200">
              Judul potensi
            </label>
            <input
              type="text"
              name="title"
              value="<?php echo e(old('title', $potential->title)); ?>"
              class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-slate-100"
              required
            >
          </div>

          <div class="space-y-1.5">
            <label class="block text-[11px] font-semibold text-slate-200">
              Slug (opsional)
            </label>
            <input
              type="text"
              name="slug"
              value="<?php echo e(old('slug', $potential->slug)); ?>"
              placeholder="Biarkan kosong untuk dibuat otomatis dari judul"
              class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-slate-100"
            >
          </div>

          <div class="space-y-1.5">
            <label class="block text-[11px] font-semibold text-slate-200">
              Deskripsi
            </label>
            <textarea
              name="description"
              rows="4"
              class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-slate-100"
            ><?php echo e(old('description', $potential->description)); ?></textarea>
          </div>

          <div class="grid md:grid-cols-2 gap-4">
            <div class="space-y-1.5">
              <label class="block text-[11px] font-semibold text-slate-200">
                Kisaran harga / HTM
              </label>
              <input
                type="text"
                name="price_range"
                value="<?php echo e(old('price_range', $potential->price_range)); ?>"
                placeholder="Contoh: Rp 10.000 / tiket"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-slate-100"
              >
            </div>
            <div class="space-y-1.5">
              <label class="block text-[11px] font-semibold text-slate-200">
                Nomor WhatsApp kontak
              </label>
              <input
                type="text"
                name="whatsapp_number"
                value="<?php echo e(old('whatsapp_number', $potential->whatsapp_number)); ?>"
                placeholder="Contoh: 62812xxxxxxx"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-slate-100"
              >
            </div>
          </div>

          <div class="space-y-1.5">
            <label class="block text-[11px] font-semibold text-slate-200">
              Alamat lokasi
            </label>
            <input
              type="text"
              name="location_address"
              value="<?php echo e(old('location_address', $potential->location_address)); ?>"
              placeholder="Nama dusun / RT / patokan lokasi"
              class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-slate-100"
            >
          </div>

          <div class="grid md:grid-cols-2 gap-4">
            <div class="space-y-1.5">
              <label class="block text-[11px] font-semibold text-slate-200">
                Latitude
              </label>
              <input
                type="text"
                name="latitude"
                value="<?php echo e(old('latitude', $potential->latitude)); ?>"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-slate-100"
              >
            </div>
            <div class="space-y-1.5">
              <label class="block text-[11px] font-semibold text-slate-200">
                Longitude
              </label>
              <input
                type="text"
                name="longitude"
                value="<?php echo e(old('longitude', $potential->longitude)); ?>"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-slate-100"
              >
            </div>
          </div>

          <div class="space-y-1.5">
            <label class="block text-[11px] font-semibold text-slate-200">
              Peta lokasi
            </label>
            <div id="potential-map" class="w-full h-64 rounded-2xl border border-slate-700 overflow-hidden"></div>
            <p class="text-[11px] text-slate-500">
              Klik pada peta untuk menempatkan marker, koordinat akan terisi otomatis.
            </p>
          </div>

          <div class="pt-3 flex items-center justify-between gap-3">
            <p class="text-[11px] text-slate-500">
              Data yang disimpan akan langsung terhubung dengan halaman publik SIDARA.
            </p>
            <button
              type="submit"
              class="inline-flex items-center justify-center gap-2 text-xs font-semibold bg-emerald-500 hover:bg-emerald-400 text-slate-950 rounded-xl px-4 py-2.5"
              style="z-index: 1000; position: relative;"
            >
              <?php echo e($mode === 'edit' ? 'Simpan perubahan' : 'Simpan potensi'); ?>

            </button>
          </div>
        </form>
      </section>
    </main>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var latInput = document.querySelector('input[name="latitude"]');
      var lngInput = document.querySelector('input[name="longitude"]');
      var mapContainer = document.getElementById('potential-map');

      if (!latInput || !lngInput || !mapContainer || typeof L === 'undefined') {
        return;
      }

      var lat = parseFloat(latInput.value);
      var lng = parseFloat(lngInput.value);
      var hasInitial = !isNaN(lat) && !isNaN(lng);

      var defaultLat = hasInitial ? lat : -7.4531;
      var defaultLng = hasInitial ? lng : 109.7044;

      var map = L.map(mapContainer).setView([defaultLat, defaultLng], hasInitial ? 15 : 12);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
      }).addTo(map);

      var marker = null;

      function attachDrag(markerInstance) {
        markerInstance.on('dragend', function (e) {
          var pos = e.target.getLatLng();
          latInput.value = pos.lat.toFixed(6);
          lngInput.value = pos.lng.toFixed(6);
        });
      }

      if (hasInitial) {
        marker = L.marker([lat, lng], { draggable: true }).addTo(map);
        attachDrag(marker);
      }

      function setMarker(latValue, lngValue) {
        if (marker) {
          marker.setLatLng([latValue, lngValue]);
        } else {
          marker = L.marker([latValue, lngValue], { draggable: true }).addTo(map);
          attachDrag(marker);
        }
        latInput.value = latValue.toFixed(6);
        lngInput.value = lngValue.toFixed(6);
      }

      map.on('click', function (e) {
        setMarker(e.latlng.lat, e.latlng.lng);
      });
    });

    // Function untuk delete image
    function deleteImage(imageIndex) {
      if (confirm('Hapus foto ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo e(route("admin.potentials.deleteImage", ["potential" => $potential, "imageIndex" => "IMAGE_INDEX"])); ?>'.replace('IMAGE_INDEX', imageIndex);
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '<?php echo e(csrf_token()); ?>';
        
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
      }
    }

    // Event listener untuk tombol delete image
    document.addEventListener('click', function(e) {
      if (e.target.classList.contains('delete-image-btn') || e.target.closest('.delete-image-btn')) {
        const button = e.target.classList.contains('delete-image-btn') ? e.target : e.target.closest('.delete-image-btn');
        const index = button.getAttribute('data-index');
        deleteImage(index);
      }
    });
  </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\sidara\laravel\resources\views/admin/potentials/form.blade.php ENDPATH**/ ?>