<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Desa - SIDARA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5f2ec] text-slate-900">
  <div class="min-h-screen flex flex-col">
    <header class="bg-emerald-900 text-emerald-50">
      <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-xl bg-emerald-500 flex items-center justify-center">
            <span class="text-xs font-semibold tracking-wider">SD</span>
          </div>
          <div>
            <div class="text-xs font-semibold tracking-wide uppercase">SIDARA</div>
            <div class="text-[11px] text-emerald-100">Database Desa Banjarnegara</div>
          </div>
        </a>
        <a href="{{ route('map') }}" class="hidden sm:inline-flex items-center gap-2 text-xs font-medium px-3 py-1.5 rounded-full bg-emerald-800 border border-emerald-600">
          <span>Lihat Peta Desa</span>
        </a>
      </div>
    </header>

    <main class="flex-1">
      <div class="max-w-5xl mx-auto px-4 py-5 md:py-7 space-y-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
          <div>
            <h1 class="text-base md:text-lg font-semibold text-slate-900">
              Daftar Desa
            </h1>
            <p class="text-[11px] md:text-xs text-slate-600">
              Direktori desa di Kabupaten Banjarnegara beserta tautan website resmi jika tersedia.
            </p>
          </div>
          <form method="GET" action="{{ route('villages.index') }}" class="md:w-80">
            <div class="flex items-center gap-2 bg-white rounded-2xl border border-amber-100 px-3 py-2">
              <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none">
                <circle cx="11" cy="11" r="5" stroke="currentColor" stroke-width="1.6"></circle>
                <path d="M15.5 15.5L19 19" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"></path>
              </svg>
              <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari desa atau kecamatan..."
                class="flex-1 text-xs bg-transparent outline-none placeholder:text-slate-400"
              >
            </div>
          </form>
        </div>

        <div class="bg-white rounded-3xl border border-amber-100 shadow-sm">
          <div class="divide-y divide-slate-100">
            @forelse($villages as $village)
              <article class="px-4 md:px-5 py-3.5 md:py-4 flex items-start justify-between gap-3">
                <div class="flex-1 space-y-1">
                  <h2 class="text-sm font-semibold text-slate-900">
                    <a href="{{ route('villages.show', $village->slug) }}" class="hover:text-emerald-700">
                      {{ $village->village_name }}
                    </a>
                  </h2>
                  <p class="text-[11px] text-slate-500">
                    {{ $village->district_name }}, Banjarnegara
                  </p>
                  <div class="flex flex-wrap items-center gap-1.5">
                    @if($village->website_url)
                      <a
                        href="{{ $village->website_url }}"
                        target="_blank"
                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100 text-[11px]"
                      >
                        <span>Website Desa</span>
                      </a>
                    @else
                      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-slate-50 text-slate-500 border border-slate-100 text-[11px]">
                        <span>Website belum terdata</span>
                      </span>
                    @endif
                    @if($village->platform && $village->platform !== 'unknown')
                      <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-white text-slate-600 border border-slate-100 text-[11px]">
                        Platform: {{ strtoupper($village->platform) }}
                      </span>
                    @endif
                  </div>
                </div>
                <div class="flex flex-col items-end gap-1">
                  <a
                    href="{{ route('villages.show', $village->slug) }}"
                    class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700"
                  >
                    Detail desa
                  </a>
                  <a
                    href="{{ route('map') }}"
                    class="inline-flex items-center gap-1 text-[10px] text-slate-500"
                  >
                    Lihat di peta
                  </a>
                </div>
              </article>
            @empty
              <p class="px-4 md:px-5 py-4 text-xs text-slate-500">
                Belum ada data desa yang tersedia. Jalankan seeder atau proses import terlebih dahulu.
              </p>
            @endforelse
          </div>
        </div>
      </div>
    </main>

    <nav class="fixed bottom-0 inset-x-0 z-20 md:hidden">
      <div class="mx-auto max-w-md px-4 pb-3">
        <div class="bg-white rounded-2xl shadow-xl border border-amber-100 px-4 py-1.5 flex justify-between">
          <a href="{{ route('home') }}" class="flex flex-col items-center justify-center flex-1 py-1.5 text-slate-500">
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
            <span class="text-[10px] font-semibold">Desa</span>
          </span>
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
</body>
</html>

