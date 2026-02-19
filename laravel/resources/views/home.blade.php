<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>SIDARA - Sistem Informasi Database Potensi Desa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#059669">
  <link rel="manifest" href="{{ asset('manifest.json') }}?v={{ time() }}">
  <link rel="apple-touch-icon" href="{{ asset('logo.jpg') }}?v={{ time() }}">
  <link rel="icon" href="{{ asset('logo.jpg') }}?v={{ time() }}" type="image/jpeg">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Basic styles untuk home */
    body { background-color: #f5f2ec; color: #1e293b; font-family: sans-serif; overflow-x: hidden; }
    .min-h-screen { min-height: 100vh; }
    .flex { display: flex; }
    .flex-col { flex-direction: column; }
    .relative { position: relative; }
    .z-0 { z-index: 0; }
    .w-full { width: 100%; }
    .overflow-x-hidden { overflow-x: hidden; }
    .absolute { position: absolute; }
    .inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
    .h-full { height: 100%; }
    .min-w-full { min-width: 100%; }
    .object-cover { object-fit: cover; }
    .opacity-40 { opacity: 0.4; }
    .backdrop-blur { backdrop-filter: blur(8px); }
    .bg-white { background-color: white; }
    .bg-opacity-80 { background-color: rgba(255, 255, 255, 0.8); }
    .rounded-2xl { border-radius: 1rem; }
    .p-6 { padding: 1.5rem; }
    .px-4 { padding-left: 1rem; padding-right: 1rem; }
    .pt-4 { padding-top: 1rem; }
    .pb-24 { padding-bottom: 6rem; }
    .md\:pb-32 { padding-bottom: 8rem; }
    .mx-auto { margin-left: auto; margin-right: auto; }
    .max-w-6xl { max-width: 72rem; }
    .items-center { align-items: center; }
    .justify-between { justify-content: space-between; }
    .text-white { color: white; }
    .mb-10 { margin-bottom: 2.5rem; }
    .gap-2 { gap: 0.5rem; }
    .w-9 { width: 2.25rem; }
    .h-9 { height: 2.25rem; }
    .rounded-xl { border-radius: 0.75rem; }
    .object-contain { object-fit: contain; }
    .bg-white\/10 { background-color: rgba(255, 255, 255, 0.1); }
    .p-1 { padding: 0.25rem; }
    .text-sm { font-size: 0.875rem; }
    .font-semibold { font-weight: 600; }
    .tracking-wide { letter-spacing: 0.025em; }
    .uppercase { text-transform: uppercase; }
    .text-xs { font-size: 0.75rem; }
    .text-white\/70 { color: rgba(255, 255, 255, 0.7); }
    .hidden { display: none; }
    .sm\:inline-flex { display: inline-flex; }
    .font-medium { font-weight: 500; }
    .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
    .py-1\.5 { padding-top: 0.375rem; padding-bottom: 0.375rem; }
    .rounded-full { border-radius: 9999px; }
    .bg-amber-500\/20 { background-color: rgba(245, 158, 11, 0.2); }
    .border { border-width: 1px; }
    .border-amber-400\/60 { border-color: rgba(251, 191, 36, 0.6); }
    .text-amber-300 { color: rgb(252, 211, 77); }
    .hover\:bg-amber-500\/30:hover { background-color: rgba(245, 158, 11, 0.3); }
    .gap-4 { gap: 1rem; }
    .text-2xl { font-size: 1.5rem; }
    .font-bold { font-weight: 700; }
    .leading-tight { line-height: 1.25; }
    .mt-2 { margin-top: 0.5rem; }
    .text-slate-200 { color: rgb(226, 232, 240); }
    .max-w-md { max-width: 28rem; }
    .bg-white\/5 { background-color: rgba(255, 255, 255, 0.05); }
    .border-white\/10 { border-color: rgba(255, 255, 255, 0.1); }
    .focus\:shadow-emerald-500\/50:focus { box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.5); }
    .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
    .pl-3 { padding-left: 0.75rem; }
    .pr-10 { padding-right: 2.5rem; }
    .placeholder-white\/50::placeholder { color: rgba(255, 255, 255, 0.5); }
    .appearance-none { appearance: none; }
    .bg-no-repeat { background-repeat: no-repeat; }
    .bg-right { background-position: right; }
    .bg-\[length\:16px_16px\] { background-size: 16px 16px; }
    .flex-1 { flex: 1 1 0%; }
    .-mt-10 { margin-top: -2.5rem; }
    .md\:-mt-16 { margin-top: -4rem; }
    .z-20 { z-index: 20; }
    .pb-24 { padding-bottom: 6rem; }
    .md\:pb-32 { padding-bottom: 8rem; }
    .grid { display: grid; }
    .md\:grid-cols-\[2fr\,1fr\] { grid-template-columns: 2fr 1fr; }
    .gap-6 { gap: 1.5rem; }
    .md\:gap-8 { gap: 2rem; }
    .items-start { align-items: start; }
    .bg-white { background-color: white; }
    .rounded-3xl { border-radius: 1.5rem; }
    .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
    .shadow-amber-900\/5 { box-shadow: 0 0 0 1px rgba(120, 53, 15, 0.05); }
    .border-amber-100 { border-color: rgb(254, 243, 199); }
    .p-4 { padding: 1rem; }
    .md\:p-6 { padding: 1.5rem; }
    .space-y-6 { row-gap: 1.5rem; }
    .md\:space-y-7 { row-gap: 1.75rem; }
    .mb-4 { margin-bottom: 1rem; }
    .md\:mb-5 { margin-bottom: 1.25rem; }
    .text-base { font-size: 1rem; }
    .text-slate-900 { color: rgb(15, 23, 42); }
    .shadow-emerald-500\/50 { box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.5); }
  </style>
</head>
<body class="bg-[#f5f2ec] text-slate-900 overflow-x-hidden">
  <div class="min-h-screen flex flex-col">
    <header class="relative z-0 w-full overflow-x-hidden">
      <div class="absolute inset-0 z-0 h-full w-full min-w-full">
        @php
          $heroUrl = asset('background.jpg');
        @endphp
        <img
          src="{{ $heroUrl }}"
          alt="Pemandangan Banjarnegara"
          class="w-full h-full object-cover"
          onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&amp;auto=format&amp;fit=crop&amp;w=2070&amp;q=80';"}
        >
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/50 to-black/70"></div>
      </div>

      <div class="relative z-30 max-w-6xl mx-auto px-4 pt-4 pb-24 md:pb-32">
          <div class="flex items-center justify-between text-white mb-10">
          <div class="flex items-center gap-2">
            <img
              src="{{ asset('logo.jpg') }}"
              alt="Logo SIDARA"
              class="w-9 h-9 rounded-xl object-contain bg-white/10 p-1"
            >
            <div>
              <div class="text-sm font-semibold tracking-wide uppercase">SIDARA</div>
              <div class="text-xs text-white/70">Potensi Desa Banjarnegara</div>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <button id="pwaInstallBtn" class="hidden sm:inline-flex items-center gap-2 text-xs font-medium px-3 py-1.5 rounded-full bg-amber-500/20 border border-amber-400/60 backdrop-blur text-amber-300 hover:bg-amber-500/30">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
              </svg>
              <span>Install App</span>
            </button>
            <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center gap-2 text-xs font-medium px-3 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
              <span>Admin Login</span>
            </a>
          </div>
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
            <form method="GET" action="{{ url('/') }}" class="flex flex-col gap-3">
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
              <div class="flex flex-col md:flex-row gap-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 w-full overflow-hidden">
                  <select name="district" class="w-full text-xs bg-white/90 border border-white/60 rounded-xl px-3 py-2.5 text-slate-700 max-w-full">
                    <option value="">Semua Kecamatan</option>
                    @isset($districts)
                      @foreach($districts as $district)
                        <option value="{{ $district }}" @if(request('district') === $district) selected @endif>
                          {{ $district }}
                        </option>
                      @endforeach
                    @endisset
                  </select>
                  <select name="village" class="w-full text-xs bg-white/90 border border-white/60 rounded-xl px-3 py-2.5 text-slate-700 max-w-full">
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

    <main class="relative flex-1 -mt-10 md:-mt-16 z-20">
      <div class="max-w-6xl mx-auto px-4 pb-24 md:pb-32 w-full overflow-x-hidden">
        <div class="flex flex-col md:grid md:grid-cols-[2fr,1fr] gap-6 md:gap-8 items-start w-full">
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

              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5 overflow-x-hidden">
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
                <article class="bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 flex flex-col max-w-full w-full">
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
                    <h3 class="text-sm font-semibold text-slate-900 line-clamp-2 break-words">
                      {{ $potential->title }}
                    </h3>
                    <div class="flex flex-wrap items-center gap-1.5 text-[11px]">
                      @if($potential->village)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-white border border-slate-200 text-slate-700 max-w-full truncate">
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
                    <div class="mt-auto pt-2">
                        <a href="{{ route('potentials.show', $potential->slug) }}" class="block w-full text-center bg-slate-200 text-slate-800 text-xs py-2 rounded-lg hover:bg-slate-300 transition-colors font-semibold">
                          Lihat Detail
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

              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5 overflow-x-hidden">
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
                  <article class="bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 flex flex-col max-w-full w-full">
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
                      <h3 class="text-sm font-semibold text-slate-900 line-clamp-2 break-words">
                        {{ $potential->title }}
                      </h3>
                      <div class="flex flex-wrap items-center gap-1.5 text-[11px]">
                        @if($potential->village)
                          <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-white border border-slate-200 text-slate-700 max-w-full truncate">
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
                      <div class="mt-auto pt-2">
                        <a href="{{ route('potentials.show', $potential->slug) }}" class="block w-full text-center bg-slate-200 text-slate-800 text-xs py-2 rounded-lg hover:bg-slate-300 transition-colors font-semibold">
                          Lihat Detail
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

          <aside class="order-2 space-y-4 md:space-y-5">
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

            <div class="bg-amber-900 text-amber-50 rounded-3xl p-4 md:p-5 flex flex-col gap-3 shadow-lg shadow-amber-900/30">
              <div class="text-xs font-semibold tracking-wide uppercase text-amber-200">
                Install Aplikasi
              </div>
              <h2 class="text-sm md:text-base font-semibold leading-snug">
                Pasang SIDARA di perangkat Anda
              </h2>
              <p class="text-[11px] text-amber-100">
                Akses lebih cepat dan nikmati pengalaman yang lebih baik dengan aplikasi native.
              </p>
              <button id="pwaInstallBtn" class="inline-flex items-center justify-center gap-2 text-xs font-semibold bg-amber-500 hover:bg-amber-400 text-amber-950 rounded-xl px-3 py-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span>Install App</span>
              </button>
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
      <div class="mx-auto max-w-md px-4 pb-3" style="padding-bottom: calc(0.75rem + env(safe-area-inset-bottom));">
        <div class="bg-white rounded-2xl shadow-xl border border-amber-100 px-4 py-1.5 flex justify-between">
          <a href="{{ route('home') }}" class="flex flex-col items-center justify-center flex-1 py-1.5 text-emerald-700">
            <svg class="w-5 h-5 mb-0.5" viewBox="0 0 24 24" fill="none">
              <path d="M5 11L12 4L19 11V19C19 19.5523 18.5523 20 18 20H6C5.44772 20 5 19.5523 5 19V11Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"></path>
              <path d="M10 20V14H14V20" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="text-[10px] font-semibold">Beranda</span>
          </a>
          <a href="{{ route('products.index') }}" class="flex flex-col items-center justify-center flex-1 py-1.5 text-slate-500">
            <svg class="w-5 h-5 mb-0.5" viewBox="0 0 24 24" fill="none">
              <circle cx="11" cy="11" r="5" stroke="currentColor" stroke-width="1.6"></circle>
              <path d="M15.5 15.5L19 19" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"></path>
            </svg>
            <span class="text-[10px] font-medium">Produk</span>
          </a>
          <a href="{{ route('map') }}" class="flex flex-col items-center justify-center flex-1 py-1.5 text-slate-500">
            <svg class="w-5 h-5 mb-0.5" viewBox="0 0 24 24" fill="none">
              <path d="M8 7C8 5.89543 8.89543 5 10 5H14C15.1046 5 16 5.89543 16 7V9C16 10.1046 15.1046 11 14 11H10C8.89543 11 8 10.1046 8 9V7Z" stroke="currentColor" stroke-width="1.6"></path>
              <path d="M5 17C5 15.8954 5.89543 15 7 15H17C18.1046 15 19 15.8954 19 17V18C19 18.5523 18.5523 19 18 19H6C5.44772 19 5 18.5523 5 18V17Z" stroke="currentColor" stroke-width="1.6"></path>
            </svg>
            <span class="text-[10px] font-medium">Peta</span>
          </a>
          <a href="{{ route('login') }}" class="flex flex-col items-center justify-center flex-1 py-1.5 text-slate-500">
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
<script>
  // PWA Install functionality
  let deferredPrompt;
  const installBtn = document.getElementById('pwaInstallBtn');
  
  window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    installBtn.classList.remove('hidden');
    
    installBtn.addEventListener('click', async () => {
      if (deferredPrompt) {
        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;
        if (outcome === 'accepted') {
          console.log('PWA installed successfully');
          installBtn.classList.add('hidden');
        }
        deferredPrompt = null;
      }
    });
  });
  
  window.addEventListener('appinstalled', () => {
    console.log('PWA was installed');
    installBtn.classList.add('hidden');
    deferredPrompt = null;
  });
  
  // Hide install button if app is already installed
  if (window.matchMedia('(display-mode: standalone)').matches) {
    installBtn.classList.add('hidden');
  }
  
  // Service Worker registration
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
      navigator.serviceWorker.register("{{ asset('service-worker.js') }}");
    });
  }
</script>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        let deferredPrompt;
        const installBtn = document.getElementById('pwaInstallBtn');

        window.addEventListener('beforeinstallprompt', (e) => {
          // Mencegah Chrome 67 dan sebelumnya menampilkan prompt secara otomatis
          e.preventDefault();
          // Simpan event untuk nanti
          deferredPrompt = e;
          // Tampilkan tombol install
          if (installBtn) {
            installBtn.style.display = 'inline-flex';
          }
        });

        if (installBtn) {
          installBtn.addEventListener('click', (e) => {
            // Sembunyikan tombol kita, karena hanya bisa digunakan sekali
            installBtn.style.display = 'none';
            // Tampilkan prompt
            if (deferredPrompt) {
              deferredPrompt.prompt();
              // Tunggu pengguna merespons prompt
              deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                  console.log('Pengguna menerima prompt instalasi');
                } else {
                  console.log('Pengguna menolak prompt instalasi');
                }
                deferredPrompt = null;
              });
            }
          });
        }
      });
    </script>
</body>
</html>
