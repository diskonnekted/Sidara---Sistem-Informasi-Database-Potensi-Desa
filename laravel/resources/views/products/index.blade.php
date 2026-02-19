<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Produk - SIDARA</title>
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
          $heroUrl = asset('images/hero-banjarnegara.jpg');
        @endphp
        <img
          src="{{ $heroUrl }}"
          alt="Pemandangan Banjarnegara"
          class="w-full h-full object-cover"
          onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&amp;auto=format&amp;fit=crop&amp;w=2070&amp;q=80';"
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
            <h1 class="text-lg font-semibold">Produk</h1>
          </div>
          <a href="{{ route('home') }}" class="p-2 hover:bg-white/10 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </a>
        </div>

        @include('products.filter')

        <div class="text-center max-w-2xl mx-auto">
          <h1 class="text-2xl md:text-3xl font-bold text-white mb-4">
            Produk &amp; Layanan Desa
          </h1>
          <p class="text-white/80 text-sm md:text-base">
            Temukan berbagai produk unggulan dan layanan dari desa-desa di Banjarnegara
          </p>
        </div>
      </div>
    </header>

    <main class="relative flex-1 -mt-10 md:-mt-16 z-20">
      <div class="max-w-6xl mx-auto px-4 pb-24 md:pb-32 w-full overflow-x-hidden">
        <section class="bg-white rounded-3xl shadow-lg shadow-amber-900/5 border border-amber-100 p-4 md:p-6 space-y-6 md:space-y-7">
          <div>
            <h2 class="text-sm md:text-base font-semibold text-slate-900 mb-4 md:mb-5">
              Katalog Produk Desa
            </h2>
            <p class="text-xs text-slate-600">
              Jelajahi berbagai produk unggulan dari desa-desa di Banjarnegara. Mulai dari hasil pertanian, 
              kerajinan tangan, hingga jasa dan layanan desa.
            </p>
          </div>

          <div class="space-y-3">
              <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori Populer</h3>
              <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
                  @foreach($categories as $category)
                      <a href="{{ route('products.index', ['category' => $category]) }}" class="bg-slate-50 border border-slate-200 rounded-xl p-3 md:p-4 flex items-center gap-3 hover:bg-emerald-50 hover:border-emerald-300 transition-all duration-300">
                          <div>
                              <h4 class="font-semibold text-slate-800 text-sm">{{ $category }}</h4>
                              <p class="text-xs text-slate-500">Lihat produk</p>
                          </div>
                      </a>
                  @endforeach
              </div>
          </div>

          @include('products.product-list')

          <div class="text-center pt-4">
            <p class="text-xs text-slate-500">Fitur e-commerce akan segera hadir untuk memudahkan transaksi</p>
          </div>
        </section>
      </div>
    </main>

        <!-- Bottom Navigation (Mobile Only) -->
    <nav class="bg-white border-t border-slate-200 fixed bottom-0 left-0 right-0 z-50 md:hidden">
      <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-stretch">
          <a href="{{ route('home') }}" class="flex flex-col items-center justify-center flex-1 py-1.5 text-slate-500">
            <svg class="w-5 h-5 mb-0.5" viewBox="0 0 24 24" fill="none">
              <path d="M5 11L12 4L19 11V19C19 19.5523 18.5523 20 18 20H6C5.44772 20 5 19.5523 5 19V11Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"></path>
              <path d="M10 20V14H14V20" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="text-[10px] font-medium">Beranda</span>
          </a>
          <a href="{{ route('products.index') }}" class="flex flex-col items-center justify-center flex-1 py-1.5 text-emerald-700">
            <svg class="w-5 h-5 mb-0.5" viewBox="0 0 24 24" fill="none">
              <circle cx="11" cy="11" r="5" stroke="currentColor" stroke-width="1.6"></circle>
              <path d="M15.5 15.5L19 19" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"></path>
            </svg>
            <span class="text-[10px] font-semibold">Produk</span>
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
</body>
</html>