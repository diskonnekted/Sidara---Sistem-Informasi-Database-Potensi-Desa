<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>{{ $village->village_name }} - SIDARA</title>
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
            <div class="text-[11px] text-emerald-100">Profil Desa Banjarnegara</div>
          </div>
        </a>
        <a href="{{ route('map') }}" class="hidden sm:inline-flex items-center gap-2 text-xs font-medium px-3 py-1.5 rounded-full bg-emerald-800 border border-emerald-600">
          <span>Lihat Peta Desa</span>
        </a>
      </div>
    </header>

    <main class="flex-1">
      <div class="max-w-5xl mx-auto px-4 py-5 md:py-7 space-y-5 md:space-y-6">
        <section class="bg-white rounded-3xl border border-amber-100 shadow-sm p-4 md:p-6 space-y-4">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div class="space-y-1">
              <h1 class="text-base md:text-lg font-semibold text-slate-900">
                {{ $village->village_name }}
              </h1>
              <p class="text-[11px] md:text-xs text-slate-600">
                {{ $village->district_name }}, Kabupaten Banjarnegara
              </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
              @if($village->website_url)
                <a
                  href="{{ $village->website_url }}"
                  target="_blank"
                  class="inline-flex items-center gap-2 text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl px-3 py-2"
                >
                  <span>Website Resmi Desa</span>
                </a>
              @endif
              <a
                href="{{ route('map') }}"
                class="inline-flex items-center gap-2 text-xs font-semibold border border-emerald-600 text-emerald-700 rounded-xl px-3 py-2 bg-emerald-50 hover:bg-emerald-100"
              >
                <span>Lihat di Peta</span>
              </a>
            </div>
          </div>

          <div class="grid sm:grid-cols-3 gap-4 text-sm">
            <div class="bg-slate-50 rounded-2xl border border-slate-100 p-3.5 space-y-1.5">
              <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Kecamatan</p>
              <p class="text-sm font-semibold text-slate-900">
                {{ $village->district_name }}
              </p>
              <p class="text-[11px] text-slate-500">
                Bagian dari Kabupaten Banjarnegara.
              </p>
            </div>
            <div class="bg-slate-50 rounded-2xl border border-slate-100 p-3.5 space-y-1.5">
              <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Platform Website</p>
              <p class="text-sm font-semibold text-slate-900">
                {{ $village->platform ? strtoupper($village->platform) : 'Belum terdata' }}
              </p>
              <p class="text-[11px] text-slate-500">
                Diambil dari hasil identifikasi website desa.
              </p>
            </div>
            <div class="bg-slate-50 rounded-2xl border border-slate-100 p-3.5 space-y-1.5">
              <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Status Website</p>
              <p class="text-sm font-semibold text-slate-900">
                {{ $village->has_active_website ? 'Aktif' : 'Tidak aktif / belum terdata' }}
              </p>
              <p class="text-[11px] text-slate-500">
                Terakhir dicek: {{ $village->last_scraped_at ? $village->last_scraped_at->format('d M Y') : 'Belum pernah' }}
              </p>
            </div>
          </div>
        </section>

        <section class="space-y-3">
          <div class="flex items-center justify-between gap-2">
            <h2 class="text-sm font-semibold text-slate-900">
              Potensi Desa di {{ $village->village_name }}
            </h2>
            <a href="{{ route('home', ['district' => $village->district_name]) }}" class="text-[11px] text-emerald-700">
              Lihat semua potensi di kecamatan ini
            </a>
          </div>

          <div class="bg-white rounded-3xl border border-amber-100 shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4 p-4 md:p-5">
              @forelse($village->potentials as $potential)
                <article class="border border-slate-100 rounded-2xl overflow-hidden flex flex-col bg-slate-50">
                  <div class="h-28 bg-slate-200">
                    <img
                      src="{{ $potential->images[0] ?? 'https://images.pexels.com/photos/2403207/pexels-photo-2403207.jpeg' }}"
                      alt="{{ $potential->title }}"
                      class="w-full h-full object-cover"
                    >
                  </div>
                  <div class="p-3.5 space-y-1.5 flex-1 flex flex-col">
                    <h3 class="text-sm font-semibold text-slate-900 line-clamp-2">
                      {{ $potential->title }}
                    </h3>
                    <p class="text-[11px] text-slate-500 line-clamp-2">
                      {{ $potential->description ?: 'Belum ada deskripsi.' }}
                    </p>
                    <div class="mt-2 flex items-center justify-between gap-2">
                      <span class="text-[11px] font-medium text-emerald-700">
                        {{ $potential->price_range ?: 'Info harga di lokasi' }}
                      </span>
                      <a
                        href="{{ route('potentials.show', $potential->slug) }}"
                        class="text-[11px] font-semibold text-emerald-700"
                      >
                        Detail
                      </a>
                    </div>
                  </div>
                </article>
              @empty
                <p class="text-xs text-slate-500">
                  Belum ada data potensi yang terverifikasi di desa ini.
                </p>
              @endforelse
            </div>
          </div>
        </section>
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

