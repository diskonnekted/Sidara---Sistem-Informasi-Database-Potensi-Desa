<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Desa {{ $village->village_name }} - SIDARA</title>
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

      <div class="relative z-10 max-w-6xl mx-auto px-4 pt-4 pb-20 md:pb-28">
        <div class="flex items-center justify-between text-white mb-8">
          <div class="flex items-center gap-2">
            <img
              src="{{ asset('logo.jpeg') }}"
              alt="Logo SIDARA"
              class="w-9 h-9 rounded-xl object-contain bg-white/10 p-1"
            >
            <div>
              <div class="text-sm font-semibold tracking-wide uppercase">SIDARA</div>
              <div class="text-xs text-white/70">Profil Desa</div>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <a href="{{ route('villages.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur">
              <span>Daftar desa</span>
            </a>
            <a href="{{ route('home') }}" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur">
              <span>Beranda</span>
            </a>
          </div>
        </div>

        <div class="max-w-xl text-white space-y-3">
          <p class="inline-flex items-center gap-2 text-xs font-medium px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/60">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-300"></span>
            Profil desa dan potensi di Kabupaten Banjarnegara
          </p>
          <h1 class="text-3xl md:text-4xl font-bold leading-tight">
            Desa {{ $village->village_name }}
          </h1>
          <p class="text-sm md:text-base text-white/80">
            Kecamatan {{ $village->district_name }}, Kabupaten Banjarnegara. Lihat informasi
            website desa, platform layanan, dan daftar potensi yang sudah tercatat di SIDARA.
          </p>
        </div>
      </div>
    </header>

    <main class="relative flex-1 -mt-10 md:-mt-16">
      <div class="max-w-6xl mx-auto px-4 pb-20 md:pb-28 space-y-5">
        <div class="bg-white rounded-3xl border border-amber-100 p-4 md:p-6 shadow-lg shadow-amber-900/5 space-y-3">
          <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-2xl bg-emerald-500 flex items-center justify-center text-white text-base font-semibold">
              {{ strtoupper(substr($village->village_name, 0, 1)) }}
            </div>
            <div class="space-y-1">
              <h1 class="text-lg md:text-xl font-semibold text-slate-900">
                Desa {{ $village->village_name }}
              </h1>
              <p class="text-xs md:text-sm text-slate-500">
                Kecamatan {{ $village->district_name }}, Kabupaten Banjarnegara
              </p>
            </div>
          </div>

          <div class="grid md:grid-cols-3 gap-3 text-xs md:text-[13px] mt-3">
            <div class="space-y-1.5">
              <div class="text-[11px] font-semibold text-slate-500">
                Website desa
              </div>
              @if($village->website_url)
                <a href="{{ $village->website_url }}" target="_blank" class="inline-flex items-center gap-1.5 text-emerald-700 hover:text-emerald-600 break-all">
                  <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                  <span>{{ $village->website_url }}</span>
                </a>
              @else
                <span class="inline-flex items-center gap-1.5 text-slate-400">
                  <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                  Belum tercatat website desa
                </span>
              @endif
            </div>
            <div class="space-y-1.5">
              <div class="text-[11px] font-semibold text-slate-500">
                Platform
              </div>
              <div class="inline-flex items-center gap-1.5 text-slate-700">
                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                <span class="capitalize">
                  {{ $village->platform ?? 'unknown' }}
                </span>
              </div>
            </div>
            <div class="space-y-1.5">
              <div class="text-[11px] font-semibold text-slate-500">
                Status website
              </div>
              <div class="inline-flex items-center gap-1.5">
                @if($village->has_active_website)
                  <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                  <span class="text-emerald-700">Aktif</span>
                @else
                  <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                  <span class="text-slate-500">Belum ditandai aktif</span>
                @endif
              </div>
            </div>
          </div>

          @if($village->population)
            <div class="mt-3">
              <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-50 border border-amber-100 text-[11px] text-amber-900">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                <span>Perkiraan jumlah penduduk: {{ number_format($village->population) }} jiwa</span>
              </div>
            </div>
          @endif
        </div>

        <div class="bg-white rounded-3xl border border-amber-100 p-4 md:p-6 shadow-lg shadow-amber-900/5 space-y-3">
          <div class="flex items-center justify-between mb-1">
            <h2 class="text-sm md:text-base font-semibold text-slate-900">
              Potensi desa
            </h2>
            <span class="text-[11px] text-slate-500">
              {{ $village->potentials->count() }} potensi terdata
            </span>
          </div>

          @if($village->potentials->isEmpty())
            <p class="text-xs text-slate-500">
              Belum ada data potensi yang terhubung dengan desa ini.
            </p>
          @else
            <div class="grid md:grid-cols-2 gap-3 md:gap-4">
              @foreach($village->potentials as $potential)
                <article class="bg-slate-50 rounded-2xl border border-slate-100 p-3.5 md:p-4 flex flex-col gap-2">
                  <div class="flex items-start justify-between gap-2">
                    <h3 class="text-xs md:text-sm font-semibold text-slate-900 line-clamp-2">
                      {{ $potential->title }}
                    </h3>
                    @if($potential->verification_status === 'verified')
                      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100 text-[10px] font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Verified
                      </span>
                    @else
                      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-slate-50 text-slate-600 border border-slate-200 text-[10px] font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                        {{ ucfirst($potential->verification_status) }}
                      </span>
                    @endif
                  </div>
                  <p class="text-[11px] text-slate-500 line-clamp-2">
                    {{ $potential->description ?: 'Belum ada deskripsi.' }}
                  </p>
                  <div class="flex items-center justify-between mt-1">
                    <p class="text-[11px] text-slate-600">
                      @if($potential->price_range)
                        Kisaran <span class="font-semibold text-slate-900">{{ $potential->price_range }}</span>
                      @else
                        <span class="font-semibold text-slate-900">Info harga di lokasi</span>
                      @endif
                    </p>
                    <a href="{{ route('potentials.show', $potential->slug) }}" class="text-[11px] font-semibold text-emerald-700">
                      Detail
                    </a>
                  </div>
                </article>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </main>
  </div>
</body>
</html>
