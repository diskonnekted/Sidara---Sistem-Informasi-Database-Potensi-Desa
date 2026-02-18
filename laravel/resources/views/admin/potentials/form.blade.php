<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>{{ $mode === 'edit' ? 'Edit Potensi Desa' : 'Tambah Potensi Desa' }} - SIDARA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
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
          {{ $mode === 'edit' ? 'Edit potensi desa' : 'Tambah potensi desa' }}
        </h1>
      </div>
      <div class="flex items-center gap-2 text-[11px]">
        <a href="{{ route('admin.potentials.index') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-slate-900 border border-slate-700 text-slate-200">
          <span>Kembali ke daftar</span>
        </a>
      </div>
    </header>

    <main class="flex-1 px-4 md:px-6 py-4 md:py-6">
      <section class="max-w-3xl mx-auto bg-slate-900 rounded-2xl border border-slate-800 p-3 md:p-5 space-y-4">
        @if($errors->any())
          <div class="rounded-2xl border border-rose-500/40 bg-rose-500/10 text-rose-100 px-3 py-2 text-[11px]">
            <div class="font-semibold mb-1">Terjadi kesalahan:</div>
            <ul class="list-disc list-inside space-y-0.5">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @php
          $action = $mode === 'edit'
            ? route('admin.potentials.update', $potential)
            : route('admin.potentials.store');
        @endphp

        <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-4 text-[13px]">
          @csrf
          @if($mode === 'edit')
            @method('PUT')
          @endif

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
                @foreach($villages as $village)
                  <option value="{{ $village->id }}" @if(old('village_id', $potential->village_id) == $village->id) selected @endif>
                    {{ $village->village_name }} - {{ $village->district_name }}
                  </option>
                @endforeach
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
                @php $currentStatus = old('verification_status', $potential->verification_status ?: 'pending'); @endphp
                <option value="pending" @if($currentStatus === 'pending') selected @endif>Menunggu</option>
                <option value="verified" @if($currentStatus === 'verified') selected @endif>Terverifikasi</option>
                <option value="rejected" @if($currentStatus === 'rejected') selected @endif>Ditolak</option>
              </select>
            </div>
          </div>

          <div class="space-y-2">
            <div class="flex items-center justify-between">
              <label class="block text-[11px] font-semibold text-slate-200">
                Foto utama dan galeri
              </label>
              @if($mode === 'edit' && $potential->images)
                <label class="inline-flex items-center gap-1.5 text-[11px] text-slate-400">
                  <input type="checkbox" name="reset_images" value="1" class="rounded border-slate-600 bg-slate-950 text-emerald-500">
                  <span>Hapus semua foto lama</span>
                </label>
              @endif
            </div>
            <input
              type="file"
              name="images[]"
              multiple
              accept="image/*"
              class="w-full text-[11px] text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-emerald-600 file:text-slate-950 bg-slate-950 border border-slate-700 rounded-xl px-2 py-1.5"
            >
            @if($mode === 'edit' && $potential->images)
              <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 mt-2">
                @foreach($potential->images as $img)
                  @php
                    $src = $img;
                    if ($img && !preg_match('/^https?:\/\//i', $img)) {
                      $src = asset('storage/'.$img);
                    }
                  @endphp
                  <div class="relative">
                    <img src="{{ $src }}" alt="Foto potensi" class="w-full h-20 object-cover rounded-xl border border-slate-700">
                  </div>
                @endforeach
              </div>
            @endif
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
              value="{{ old('title', $potential->title) }}"
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
              value="{{ old('slug', $potential->slug) }}"
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
            >{{ old('description', $potential->description) }}</textarea>
          </div>

          <div class="grid md:grid-cols-2 gap-4">
            <div class="space-y-1.5">
              <label class="block text-[11px] font-semibold text-slate-200">
                Kisaran harga / HTM
              </label>
              <input
                type="text"
                name="price_range"
                value="{{ old('price_range', $potential->price_range) }}"
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
                value="{{ old('whatsapp_number', $potential->whatsapp_number) }}"
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
              value="{{ old('location_address', $potential->location_address) }}"
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
                value="{{ old('latitude', $potential->latitude) }}"
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
                value="{{ old('longitude', $potential->longitude) }}"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-slate-100"
              >
            </div>
          </div>

          <div class="pt-3 flex items-center justify-between gap-3">
            <p class="text-[11px] text-slate-500">
              Data yang disimpan akan langsung terhubung dengan halaman publik SIDARA.
            </p>
            <button
              type="submit"
              class="inline-flex items-center justify-center gap-2 text-xs font-semibold bg-emerald-500 hover:bg-emerald-400 text-slate-950 rounded-xl px-4 py-2.5"
            >
              {{ $mode === 'edit' ? 'Simpan perubahan' : 'Simpan potensi' }}
            </button>
          </div>
        </form>
      </section>
    </main>
  </div>
</body>
</html>
