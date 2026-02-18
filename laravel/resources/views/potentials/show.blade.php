<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>{{ $potential->title }} - SIDARA</title>
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
            <div class="text-[11px] text-emerald-100">Potensi Desa Banjarnegara</div>
          </div>
        </a>
        <a href="{{ route('map') }}" class="hidden sm:inline-flex items-center gap-2 text-xs font-medium px-3 py-1.5 rounded-full bg-emerald-800 border border-emerald-600">
          <span>Lihat Peta Desa</span>
        </a>
      </div>
    </header>

    <main class="flex-1">
      <div class="max-w-5xl mx-auto px-4 py-5 md:py-8">
        <div class="grid md:grid-cols-[2fr,1fr] gap-6 md:gap-8 items-start">
          <section class="bg-white rounded-3xl border border-amber-100 shadow-sm overflow-hidden">
            <div class="relative">
              <img
                src="{{ $potential->images[0] ?? 'https://images.pexels.com/photos/2403207/pexels-photo-2403207.jpeg' }}"
                alt="{{ $potential->title }}"
                class="w-full h-52 md:h-64 object-cover"
              >
              <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
              <div class="absolute bottom-3 left-4 right-4 flex flex-wrap items-center justify-between gap-2">
                <div class="space-y-1">
                  <h1 class="text-lg md:text-xl font-semibold text-white leading-snug">
                    {{ $potential->title }}
                  </h1>
                  <div class="flex flex-wrap items-center gap-2 text-[11px]">
                    @if($potential->village)
                      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-white/10 border border-white/30 text-white">
                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none">
                          <path d="M12 21C12 21 5 14.6863 5 10C5 6.68629 7.68629 4 11 4H13C16.3137 4 19 6.68629 19 10C19 14.6863 12 21 12 21Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"></path>
                          <circle cx="12" cy="10" r="2.25" stroke="currentColor" stroke-width="1.5"></circle>
                        </svg>
                        {{ $potential->village->village_name }}
                      </span>
                    @endif
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-500/90 text-emerald-50 border border-emerald-300/60">
                      Potensi Desa
                    </span>
                    @if($potential->verification_status === 'verified')
                      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Data terverifikasi
                      </span>
                    @endif
                  </div>
                </div>
              </div>
            </div>

            <div class="p-4 md:p-6 space-y-5">
              <div class="space-y-1">
                <h2 class="text-sm font-semibold text-slate-900">Deskripsi</h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                  {{ $potential->description ?: 'Belum ada deskripsi rinci untuk potensi ini.' }}
                </p>
              </div>

              <div class="grid sm:grid-cols-3 gap-4 text-sm">
                <div class="bg-slate-50 rounded-2xl border border-slate-100 p-3.5 space-y-1.5">
                  <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Alamat Lokasi</p>
                  <p class="text-sm font-semibold text-slate-900">
                    {{ $potential->location_address ?: 'Dusun/RT/RW belum diisi' }}
                  </p>
                  @if($potential->village)
                    <p class="text-[11px] text-slate-500">
                      {{ $potential->village->village_name }}, {{ $potential->village->district_name ?? 'Banjarnegara' }}
                    </p>
                  @endif
                </div>
                <div class="bg-slate-50 rounded-2xl border border-slate-100 p-3.5 space-y-1.5">
                  <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Kontak</p>
                  <p class="text-sm font-semibold text-slate-900">
                    @if($potential->whatsapp_number)
                      {{ $potential->whatsapp_number }}
                    @else
                      Belum ada nomor WhatsApp
                    @endif
                  </p>
                  <p class="text-[11px] text-slate-500">
                    Kontak langsung ke pengelola potensi.
                  </p>
                </div>
                <div class="bg-slate-50 rounded-2xl border border-slate-100 p-3.5 space-y-1.5">
                  <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Status</p>
                  <p class="text-sm font-semibold text-slate-900">
                    @if(($potential->attributes['owner_type'] ?? null) === 'bumdes')
                      Milik BUMDes
                    @elseif(($potential->attributes['owner_type'] ?? null) === 'warga')
                      Usaha Warga
                    @else
                      {{ ucfirst($potential->verification_status) }}
                    @endif
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
                    @if($potential->village)
                      {{ $potential->village->village_name }}
                    @else
                      Tidak tercatat
                    @endif
                  </p>
                  @if($potential->village)
                    <p class="text-[11px] text-slate-500">
                      {{ $potential->village->district_name ?? 'Banjarnegara' }}
                    </p>
                  @endif
                </div>
                <div class="bg-slate-50 rounded-2xl border border-slate-100 p-3.5 space-y-1.5">
                  <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Kisaran Harga</p>
                  <p class="text-sm font-semibold text-slate-900">
                    {{ $potential->price_range ?: 'Info harga di lokasi' }}
                  </p>
                  <p class="text-[11px] text-slate-500">
                    Nilai indikatif, dapat berubah sesuai kebijakan pengelola.
                  </p>
                </div>
                <div class="bg-slate-50 rounded-2xl border border-slate-100 p-3.5 space-y-1.5">
                  <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Koordinat</p>
                  @if($potential->latitude && $potential->longitude)
                    <p class="text-sm font-semibold text-slate-900">
                      {{ $potential->latitude }}, {{ $potential->longitude }}
                    </p>
                    <p class="text-[11px] text-slate-500">
                      Titik estimasi untuk navigasi peta.
                    </p>
                  @else
                    <p class="text-sm font-semibold text-slate-900">
                      Belum tersedia
                    </p>
                    <p class="text-[11px] text-slate-500">
                      Koordinat akan diisi oleh admin desa.
                    </p>
                  @endif
                </div>
              </div>

              <div class="space-y-2">
                <h2 class="text-sm font-semibold text-slate-900">Informasi Tambahan</h2>
                <ul class="text-sm text-slate-600 space-y-1.5">
                  <li>Sumber data: {{ $potential->source === 'api' ? 'Sinkronisasi website desa' : 'Input manual' }}</li>
                  <li>Status verifikasi: {{ ucfirst($potential->verification_status) }}</li>
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
                  href="{{ $potential->whatsapp_number ? 'https://wa.me/'.$potential->whatsapp_number : '#' }}"
                  @if($potential->whatsapp_number) target="_blank" @endif
                  class="inline-flex items-center justify-center gap-2 text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl px-3 py-2"
                >
                  <span>Hubungi via WhatsApp</span>
                </a>
                @if($potential->latitude && $potential->longitude)
                  <a
                    href="https://www.google.com/maps?q={{ $potential->latitude }},{{ $potential->longitude }}"
                    target="_blank"
                    class="inline-flex items-center justify-center gap-2 text-xs font-semibold border border-emerald-600 text-emerald-700 rounded-xl px-3 py-2 bg-emerald-50 hover:bg-emerald-100"
                  >
                    <span>Lihat Lokasi di Google Maps</span>
                  </a>
                @else
                  <a href="{{ route('map') }}" class="inline-flex items-center justify-center gap-2 text-xs font-semibold border border-emerald-600 text-emerald-700 rounded-xl px-3 py-2 bg-emerald-50 hover:bg-emerald-100">
                    <span>Lihat di Peta Desa</span>
                  </a>
                @endif
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
          </aside>
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
            <span class="text-[10px] font-semibold">Detail</span>
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
