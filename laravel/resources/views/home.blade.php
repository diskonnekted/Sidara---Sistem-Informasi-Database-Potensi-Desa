<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>SIDARA - Sistem Informasi Database Potensi Desa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5f2ec] text-slate-900">
  <div class="min-h-screen flex flex-col">
    <header class="relative">
      <div class="absolute inset-0">
        @php
          $heroUrl = asset('images/hero-banjarnegara.jpg');
        @endphp
        <img
          src="{{ $heroUrl }}"
          alt="Pemandangan Banjarnegara"
          class="w-full h-full object-cover"
          onerror="this.onerror=null;this.src='https://images.pexels.com/photos/2403207/pexels-photo-2403207.jpeg';"
        >
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/50 to-black/70"></div>
      </div>

      <div class="relative z-10 max-w-6xl mx-auto px-4 pt-4 pb-24 md:pb-32">
          <div class="flex items-center justify-between text-white mb-10">
          <div class="flex items-center gap-2">
            <img
              src="{{ asset('logo.jpeg') }}"
              alt="Logo SIDARA"
              class="w-9 h-9 rounded-xl object-contain bg-white/10 p-1"
            >
            <div>
              <div class="text-sm font-semibold tracking-wide uppercase">SIDARA</div>
              <div class="text-xs text-white/70">Potensi Desa Banjarnegara</div>
            </div>
          </div>
          <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-2 text-xs font-medium px-3 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            <span>Admin Login</span>
          </a>
        </div>

        <div class="max-w-xl text-white space-y-4">
          <p class="inline-flex items-center gap-2 text-xs font-medium px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/60">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-300"></span>
            Direktori digital potensi desa se-Banjarnegara
          </p>
          <h1 class="text-3xl md:text-4xl font-bold leading-tight">
            Temukan Potensi Desa di
            <span class="text-amber-300">Banjarnegara</span>
            dalam satu peta.
          </h1>
          <p class="text-sm md:text-base text-white/80">
            Jelajahi wisata, UMKM, pertanian, dan peluang investasi desa dengan
            data terverifikasi dari pemerintah desa dan warga setempat.
          </p>
        </div>

        <div class="mt-6 md:mt-8 max-w-2xl space-y-3">
          <div class="bg-white/10 backdrop-blur rounded-2xl p-2 border border-white/15">
            <form method="GET" action="{{ url('/') }}" class="flex flex-col md:flex-row gap-2 md:gap-3">
              <div class="flex-1 flex items-center gap-2 bg-white rounded-xl px-3 py-2.5">
                <svg class="w-4 h-4 text-emerald-500" viewBox="0 0 24 24" fill="none">
                  <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="1.5"></circle>
                  <path d="M15.5 15.5L20 20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                </svg>
                <input
                  type="text"
                  name="q"
                  value="{{ request('q') }}"
                  placeholder="Apa potensi desa yang Anda cari?"
                  class="w-full text-sm bg-transparent outline-none placeholder:text-slate-400"
                >
              </div>
              <div class="flex flex-col sm:flex-row gap-2">
                <div class="flex-1 flex gap-2">
                  <select name="district" class="flex-1 text-xs bg-white/90 border border-white/60 rounded-xl px-3 py-2.5 text-slate-700">
                    <option value="">Semua Kecamatan</option>
                    @isset($districts)
                      @foreach($districts as $district)
                        <option value="{{ $district }}" @if(request('district') === $district) selected @endif>
                          {{ $district }}
                        </option>
                      @endforeach
                    @endisset
                  </select>
                  <select name="village" class="flex-1 text-xs bg-white/90 border border-white/60 rounded-xl px-3 py-2.5 text-slate-700">
                    <option value="">Semua Desa</option>
                    @isset($villages)
                      @foreach($villages as $village)
                        <option value="{{ $village->id }}" @if((string)request('village') === (string)$village->id) selected @endif>
                          {{ $village->village_name }} - {{ $village->district_name }}
                        </option>
                      @endforeach
                    @endisset
                  </select>
                </div>
                <button
                  type="submit"
                  class="sm:w-32 inline-flex items-center justify-center gap-2 text-xs font-semibold tracking-wide uppercase bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl px-4 py-2.5 shadow-sm"
                >
                  Cari
                </button>
              </div>
            </form>
          </div>

          <div class="flex flex-wrap items-center gap-2 text-[11px]">
            <span class="text-white/70 mr-1">Kategori populer:</span>
            <span class="px-3 py-1 rounded-full bg-white/10 text-white border border-white/20">
              Wisata
            </span>
            <span class="px-3 py-1 rounded-full bg-white/5 text-white/80 border border-white/10">
              UMKM
            </span>
            <span class="px-3 py-1 rounded-full bg-white/5 text-white/80 border border-white/10">
              Tambang
            </span>
            <span class="px-3 py-1 rounded-full bg-white/5 text-white/80 border border-white/10">
              Pertanian
            </span>
            <a href="{{ route('villages.index') }}" class="px-3 py-1 rounded-full bg-white text-emerald-800 border border-white/10 font-semibold">
              Lihat semua desa
            </a>
          </div>
        </div>
      </div>
    </header>

    <main class="relative flex-1 -mt-10 md:-mt-16">
      <div class="max-w-6xl mx-auto px-4 pb-24 md:pb-32">
        <div class="grid md:grid-cols-[2fr,1fr] gap-6 md:gap-8 items-start">
          <section class="bg-white rounded-3xl shadow-lg shadow-amber-900/5 border border-amber-100 p-4 md:p-6 space-y-6 md:space-y-7">
            <div>
              <div class="flex items-center justify-between mb-4 md:mb-5">
                <div>
                  <h2 class="text-sm md:text-base font-semibold text-slate-900">
                    Potensi terkini
                  </h2>
                  <p class="text-xs text-slate-500 mt-0.5">
                    9 potensi terbaru yang sudah terverifikasi di SIDARA.
                  </p>
                </div>
                <span class="hidden md:inline-flex text-[11px] font-medium text-slate-400">
                  {{ $latestPotentials->count() }} potensi
                </span>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5">
                @forelse($latestPotentials as $potential)
                @php
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
                @endphp
                <article class="bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 flex flex-col">
                  <div class="relative">
                    <img
                      src="{{ $firstImageUrl }}"
                      alt="{{ $potential->title }}"
                      class="w-full h-32 md:h-36 object-cover"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    @if($potential->verification_status === 'verified')
                      <div class="absolute bottom-2 left-2 flex items-center gap-1.5">
                        <span class="inline-flex items-center gap-1 bg-emerald-500/90 text-white text-[10px] font-medium px-2 py-0.5 rounded-full">
                          <span class="w-1.5 h-1.5 rounded-full bg-emerald-200"></span>
                          Verified Desa
                        </span>
                      </div>
                    @endif
                  </div>
                  <div class="p-3.5 md:p-4 flex-1 flex flex-col gap-2">
                    <h3 class="text-sm font-semibold text-slate-900 line-clamp-2">
                      {{ $potential->title }}
                    </h3>
                    <div class="flex flex-wrap items-center gap-1.5 text-[11px]">
                      @if($potential->village)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-white border border-slate-200 text-slate-700">
                          <svg class="w-3 h-3 text-emerald-500" viewBox="0 0 24 24" fill="none">
                            <path d="M12 21C12 21 5 14.6863 5 10C5 6.68629 7.68629 4 11 4H13C16.3137 4 19 6.68629 19 10C19 14.6863 12 21 12 21Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"></path>
                            <circle cx="12" cy="10" r="2.25" stroke="currentColor" stroke-width="1.5"></circle>
                          </svg>
                          {{ $potential->village->village_name }}
                        </span>
                      @endif
                      <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">
                        Potensi Desa
                      </span>
                    </div>
                    <p class="text-[11px] text-slate-500 line-clamp-2">
                      {{ $potential->description ?: 'Belum ada deskripsi.' }}
                    </p>
                    <div class="mt-auto flex items-center justify-between">
                      <p class="text-[11px] text-slate-600">
                        @if($potential->price_range)
                          Kisaran
                          <span class="font-semibold text-slate-900">{{ $potential->price_range }}</span>
                        @elseif(($potential->attributes['category_slug'] ?? null) === 'wisata' && isset($potential->attributes['htm']))
                          HTM
                          <span class="font-semibold text-slate-900">Rp {{ number_format($potential->attributes['htm']) }}</span>
                        @else
                          <span class="font-semibold text-slate-900">Info harga di lokasi</span>
                        @endif
                      </p>
                      <a href="{{ route('potentials.show', $potential->slug) }}" class="text-[11px] font-semibold text-emerald-700">
                        Detail
                      </a>
                    </div>
                  </div>
                </article>
              @empty
                <p class="text-xs text-slate-500 col-span-3">
                  Belum ada data potensi yang terverifikasi.
                </p>
              @endforelse
            </div>
            </div>

            <div class="border-t border-slate-100 pt-4 md:pt-5">
              <div class="flex items-center justify-between mb-4 md:mb-5">
                <div>
                  <h2 class="text-sm md:text-base font-semibold text-slate-900">
                    Potensi terpopuler
                  </h2>
                  <p class="text-xs text-slate-500 mt-0.5">
                    9 potensi yang sering dijadikan referensi, urutan populer saat ini.
                  </p>
                </div>
                <span class="hidden md:inline-flex text-[11px] font-medium text-slate-400">
                  {{ $popularPotentials->count() }} potensi
                </span>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5">
                @forelse($popularPotentials as $potential)
                  @php
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
                  @endphp
                  <article class="bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 flex flex-col">
                    <div class="relative">
                      <img
                        src="{{ $firstImageUrl }}"
                        alt="{{ $potential->title }}"
                        class="w-full h-32 md:h-36 object-cover"
                      >
                      <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                      @if($potential->verification_status === 'verified')
                        <div class="absolute bottom-2 left-2 flex items-center gap-1.5">
                          <span class="inline-flex items-center gap-1 bg-emerald-500/90 text-white text-[10px] font-medium px-2 py-0.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-200"></span>
                            Verified Desa
                          </span>
                        </div>
                      @endif
                    </div>
                    <div class="p-3.5 md:p-4 flex-1 flex flex-col gap-2">
                      <h3 class="text-sm font-semibold text-slate-900 line-clamp-2">
                        {{ $potential->title }}
                      </h3>
                      <div class="flex flex-wrap items-center gap-1.5 text-[11px]">
                        @if($potential->village)
                          <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-white border border-slate-200 text-slate-700">
                            <svg class="w-3 h-3 text-emerald-500" viewBox="0 0 24 24" fill="none">
                              <path d="M12 21C12 21 5 14.6863 5 10C5 6.68629 7.68629 4 11 4H13C16.3137 4 19 6.68629 19 10C19 14.6863 12 21 12 21Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"></path>
                              <circle cx="12" cy="10" r="2.25" stroke="currentColor" stroke-width="1.5"></circle>
                            </svg>
                            {{ $potential->village->village_name }}
                          </span>
                        @endif
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-100">
                          Populer
                        </span>
                      </div>
                      <p class="text-[11px] text-slate-500 line-clamp-2">
                        {{ $potential->description ?: 'Belum ada deskripsi.' }}
                      </p>
                      <div class="mt-auto flex items-center justify-between">
                        <p class="text-[11px] text-slate-600">
                          @if($potential->price_range)
                            Kisaran
                            <span class="font-semibold text-slate-900">{{ $potential->price_range }}</span>
                          @elseif(($potential->attributes['category_slug'] ?? null) === 'wisata' && isset($potential->attributes['htm']))
                            HTM
                            <span class="font-semibold text-slate-900">Rp {{ number_format($potential->attributes['htm']) }}</span>
                          @else
                            <span class="font-semibold text-slate-900">Info harga di lokasi</span>
                          @endif
                        </p>
                        <a href="{{ route('potentials.show', $potential->slug) }}" class="text-[11px] font-semibold text-emerald-700">
                          Detail
                        </a>
                      </div>
                    </div>
                  </article>
                @empty
                  <p class="text-xs text-slate-500 col-span-3">
                    Belum ada data potensi yang terverifikasi.
                  </p>
                @endforelse
              </div>

              @if($popularPotentials->hasPages())
                <div class="mt-4 md:mt-5">
                  {{ $popularPotentials->onEachSide(1)->links() }}
                </div>
              @endif
            </div>
          </section>

          <aside class="space-y-4 md:space-y-5">
            <div class="bg-emerald-900 text-emerald-50 rounded-3xl p-4 md:p-5 flex flex-col gap-3 shadow-lg shadow-emerald-900/30">
              <div class="text-xs font-semibold tracking-wide uppercase text-emerald-200">
                Untuk Admin Desa
              </div>
              <h2 class="text-sm md:text-base font-semibold leading-snug">
                Kurasi potensi desa Anda langsung dari dashboard SIDARA.
              </h2>
              <p class="text-[11px] text-emerald-100">
                Verifikasi data UMKM dan wisata yang diajukan warga, lalu tampilkan
                ke publik sebagai potensi resmi desa.
              </p>
              <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center gap-2 text-xs font-semibold bg-emerald-500 hover:bg-emerald-400 text-emerald-950 rounded-xl px-3 py-2">
                Masuk sebagai Admin Desa
              </a>
            </div>

            <div class="bg-white rounded-3xl border border-amber-100 p-4 md:p-5 flex flex-col gap-3">
              <div class="flex items-center justify-between">
                <div class="text-xs font-semibold text-slate-900">
                  Statistik singkat
                </div>
                <span class="text-[11px] text-slate-400">Mockup</span>
              </div>
              <div class="grid grid-cols-3 gap-3 text-center">
                <div class="space-y-1">
                  <div class="text-sm font-semibold text-slate-900">85+</div>
                  <div class="text-[10px] text-slate-500">Desa terdata</div>
                </div>
                <div class="space-y-1">
                  <div class="text-sm font-semibold text-slate-900">230+</div>
                  <div class="text-[10px] text-slate-500">Potensi tampil</div>
                </div>
                <div class="space-y-1">
                  <div class="text-sm font-semibold text-slate-900">120+</div>
                  <div class="text-[10px] text-slate-500">UMKM aktif</div>
                </div>
              </div>
            </div>

            <div class="bg-[#f5f2ec] rounded-3xl border border-amber-100/70 p-4 md:p-5 space-y-3">
              <div class="flex items-center justify-between">
                <div class="text-xs font-semibold text-slate-900">
                  Kategori potensi di SIDARA
                </div>
                @if(!empty($selectedCategory))
                  <span class="text-[11px] text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
                    Filter: {{ ucfirst($selectedCategory) }}
                  </span>
                @else
                  <span class="text-[11px] text-amber-700/80 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-100">
                    Contoh
                  </span>
                @endif
              </div>
              <p class="text-[11px] text-slate-600">
                Kategori membantu memetakan jenis potensi yang ada di desa. Beberapa kategori
                utama yang digunakan di SIDARA:
              </p>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                <a href="{{ url('/?category=umkm') }}" class="group flex items-start gap-2 rounded-2xl bg-white/90 border border-emerald-50 px-3 py-2.5 hover:border-emerald-300 hover:bg-emerald-50/60 transition">
                  <div class="mt-0.5 w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[11px] font-semibold group-hover:bg-emerald-600 group-hover:text-white">
                    UM
                  </div>
                  <div class="space-y-0.5">
                    <div class="text-[12px] font-semibold text-slate-900">Produk UMKM</div>
                    <p class="text-[11px] text-slate-500">
                      Makanan olahan, kerajinan, fashion, dan produk rumahan lainnya.
                    </p>
                  </div>
                </a>
                <a href="{{ url('/?category=wisata') }}" class="group flex items-start gap-2 rounded-2xl bg-white/90 border border-emerald-50 px-3 py-2.5 hover:border-emerald-300 hover:bg-emerald-50/60 transition">
                  <div class="mt-0.5 w-6 h-6 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center text-[11px] font-semibold group-hover:bg-sky-600 group-hover:text-white">
                    WS
                  </div>
                  <div class="space-y-0.5">
                    <div class="text-[12px] font-semibold text-slate-900">Wisata &amp; Rekreasi</div>
                    <p class="text-[11px] text-slate-500">
                      Wisata alam, buatan, religi, maupun destinasi foto dan rekreasi keluarga.
                    </p>
                  </div>
                </a>
                <a href="{{ url('/?category=pertanian') }}" class="group flex items-start gap-2 rounded-2xl bg-white/90 border border-emerald-50 px-3 py-2.5 hover:border-emerald-300 hover:bg-emerald-50/60 transition">
                  <div class="mt-0.5 w-6 h-6 rounded-full bg-lime-100 text-lime-700 flex items-center justify-center text-[11px] font-semibold group-hover:bg-lime-600 group-hover:text-white">
                    PT
                  </div>
                  <div class="space-y-0.5">
                    <div class="text-[12px] font-semibold text-slate-900">Pertanian &amp; Perkebunan</div>
                    <p class="text-[11px] text-slate-500">
                      Komoditas unggulan, hasil panen, dan olahan pascapanen dari desa.
                    </p>
                  </div>
                </a>
                <a href="{{ url('/?category=jasa') }}" class="group flex items-start gap-2 rounded-2xl bg-white/90 border border-emerald-50 px-3 py-2.5 hover:border-emerald-300 hover:bg-emerald-50/60 transition">
                  <div class="mt-0.5 w-6 h-6 rounded-full bg-fuchsia-100 text-fuchsia-700 flex items-center justify-center text-[11px] font-semibold group-hover:bg-fuchsia-600 group-hover:text-white">
                    SB
                  </div>
                  <div class="space-y-0.5">
                    <div class="text-[12px] font-semibold text-slate-900">Seni, Budaya, &amp; Jasa</div>
                    <p class="text-[11px] text-slate-500">
                      Sanggar seni, jasa keuangan, layanan digital, dan usaha jasa lainnya.
                    </p>
                  </div>
                </a>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </main>

    <nav class="fixed bottom-0 inset-x-0 z-20 md:hidden">
      <div class="mx-auto max-w-md px-4 pb-3">
        <div class="bg-white rounded-2xl shadow-xl border border-amber-100 px-4 py-1.5 flex justify-between">
          <a href="{{ route('home') }}" class="flex flex-col items-center justify-center flex-1 py-1.5 text-emerald-700">
            <svg class="w-5 h-5 mb-0.5" viewBox="0 0 24 24" fill="none">
              <path d="M5 11L12 4L19 11V19C19 19.5523 18.5523 20 18 20H6C5.44772 20 5 19.5523 5 19V11Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"></path>
              <path d="M10 20V14H14V20" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="text-[10px] font-semibold">Beranda</span>
          </a>
          <a href="#" class="flex flex-col items-center justify-center flex-1 py-1.5 text-slate-500">
            <svg class="w-5 h-5 mb-0.5" viewBox="0 0 24 24" fill="none">
              <circle cx="11" cy="11" r="5" stroke="currentColor" stroke-width="1.6"></circle>
              <path d="M15.5 15.5L19 19" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"></path>
            </svg>
            <span class="text-[10px] font-medium">Jelajah</span>
          </a>
          <a href="{{ route('map') }}" class="flex flex-col items-center justify-center flex-1 py-1.5 text-slate-500">
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
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var districtSelect = document.querySelector('select[name="district"]');
    var villageSelect = document.querySelector('select[name="village"]');

    if (districtSelect && districtSelect.form) {
      districtSelect.addEventListener('change', function () {
        if (villageSelect) {
          villageSelect.selectedIndex = 0;
        }
        districtSelect.form.submit();
      });
    }
  });
</script>
</body>
</html>
