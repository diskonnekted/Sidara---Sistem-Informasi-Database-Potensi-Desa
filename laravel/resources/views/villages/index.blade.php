<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Desa Banjarnegara - SIDARA</title>
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
              <div class="text-xs text-white/70">Direktori Desa Banjarnegara</div>
            </div>
          </div>
          <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-medium px-3 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            <span>Kembali ke beranda</span>
          </a>
        </div>

        <div class="max-w-xl text-white space-y-4">
          <p class="inline-flex items-center gap-2 text-xs font-medium px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/60">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-300"></span>
            Direktori digital desa dan kecamatan se-Banjarnegara
          </p>
          <h1 class="text-3xl md:text-4xl font-bold leading-tight">
            Jelajahi desa dan potensi
            <span class="text-amber-300">Kabupaten Banjarnegara</span>.
          </h1>
          <p class="text-sm md:text-base text-white/80">
            Lihat daftar desa lengkap beserta kecamatan dan website resminya sebagai pintu
            masuk menuju data potensi desa di SIDARA.
          </p>
        </div>

        <div class="mt-6 md:mt-8 max-w-2xl">
          <div class="bg-white/10 backdrop-blur rounded-2xl p-2 border border-white/15">
            <form method="GET" action="{{ route('villages.index') }}" class="flex flex-col md:flex-row gap-2 md:gap-3">
              <div class="flex-1 flex items-center gap-2 bg-white rounded-xl px-3 py-2.5">
                <svg class="w-4 h-4 text-emerald-500" viewBox="0 0 24 24" fill="none">
                  <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="1.5"></circle>
                  <path d="M15.5 15.5L20 20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                </svg>
                <input
                  type="text"
                  name="q"
                  value="{{ request('q') }}"
                  placeholder="Cari desa atau kecamatan..."
                  class="w-full text-sm bg-transparent outline-none placeholder:text-slate-400"
                >
              </div>
              <button
                type="submit"
                class="sm:w-32 inline-flex items-center justify-center gap-2 text-xs font-semibold tracking-wide uppercase bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl px-4 py-2.5 shadow-sm"
              >
                Cari desa
              </button>
            </form>
          </div>
        </div>
      </div>
    </header>

    <main class="relative flex-1 -mt-10 md:-mt-16">
      <div class="max-w-6xl mx-auto px-4 pb-20 md:pb-28">
        <section class="bg-white rounded-3xl border border-amber-100 p-4 md:p-5 shadow-lg shadow-amber-900/5">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4 md:mb-5">
            <div>
              <h2 class="text-sm md:text-base font-semibold text-slate-900">
                Daftar desa di Kabupaten Banjarnegara
              </h2>
              <p class="text-xs md:text-sm text-slate-500 mt-0.5">
                Data bersumber dari daftar desa SID yang telah diimport ke tabel villages.
              </p>
            </div>
            <div class="text-[11px] text-slate-500">
              <span class="font-semibold text-slate-900">{{ $villages->count() }}</span> desa terdata
            </div>
          </div>

          <div class="bg-slate-50 rounded-2xl border border-amber-50">
            @if($villages->isEmpty())
              <div class="p-4 md:p-5 text-xs text-slate-500">
                Belum ada data desa yang terdaftar.
              </div>
            @else
              <div class="hidden md:grid grid-cols-[2fr,2fr,2fr,1fr] gap-3 px-4 pt-3 pb-2 text-[11px] font-semibold text-slate-500">
                <div>Nama desa</div>
                <div>Kecamatan</div>
                <div>Website</div>
                <div class="text-right">Aksi</div>
              </div>
              <div class="divide-y divide-amber-50">
                @foreach($villages as $village)
                  <div class="px-3 md:px-4 py-3 md:py-2.5 flex flex-col md:grid md:grid-cols-[2fr,2fr,2fr,1fr] gap-1 md:gap-3 text-xs md:text-[11px]">
                    <div class="flex items-center gap-2">
                      <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-semibold">
                        {{ strtoupper(substr($village->village_name, 0, 1)) }}
                      </span>
                      <div>
                        <div class="font-semibold text-slate-900">
                          {{ $village->village_name }}
                        </div>
                        <div class="md:hidden text-[11px] text-slate-500">
                          {{ $village->district_name }}
                        </div>
                      </div>
                    </div>
                    <div class="hidden md:flex items-center text-slate-700">
                      {{ $village->district_name }}
                    </div>
                    <div class="flex items-center text-[11px] text-slate-500">
                      @if($village->website_url)
                        <a href="{{ $village->website_url }}" target="_blank" class="inline-flex items-center gap-1 text-emerald-700 hover:text-emerald-600">
                          <span class="truncate max-w-[200px] md:max-w-full">{{ parse_url($village->website_url, PHP_URL_HOST) ?? $village->website_url }}</span>
                        </a>
                      @else
                        <span class="inline-flex items-center gap-1 text-slate-400">
                          <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                          Belum ada website
                        </span>
                      @endif
                    </div>
                    <div class="flex md:justify-end items-center gap-2 mt-1 md:mt-0">
                      <a href="{{ route('villages.show', $village->slug) }}" class="inline-flex items-center justify-center px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-100 text-[11px] font-semibold">
                        Detail desa
                      </a>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        </section>
    </main>
  </div>
</body>
</html>
