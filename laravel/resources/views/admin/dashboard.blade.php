<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin - SIDARA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100">
  <div class="min-h-screen flex">
    <aside class="hidden md:flex w-64 flex-col border-r border-slate-800 bg-gradient-to-b from-slate-950 to-slate-900">
      <div class="px-5 py-4 border-b border-slate-800 flex items-center gap-3">
        <div class="w-9 h-9 rounded-xl bg-slate-900 flex items-center justify-center">
          <img
            src="{{ asset('logo.jpeg') }}"
            alt="Logo SIDARA"
            class="w-8 h-8 object-contain"
          >
        </div>
        <div>
          <div class="text-xs font-semibold tracking-wide uppercase text-emerald-200">SIDARA</div>
          <div class="text-[11px] text-slate-400">Dashboard Admin Desa</div>
        </div>
      </div>
      <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-emerald-600 text-emerald-50 font-medium">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
            <path d="M5 13H11V5H5V13Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"></path>
            <path d="M13 19H19V11H13V19Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"></path>
          </svg>
          <span>Ringkasan</span>
        </a>
        <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-slate-300 hover:bg-slate-800">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
            <path d="M5 11L12 4L19 11V19C19 19.5523 18.5523 20 18 20H6C5.44772 20 5 19.5523 5 19V11Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"></path>
          </svg>
          <span>Halaman publik</span>
        </a>
      </nav>
      <div class="px-4 py-4 border-t border-slate-800 text-[11px] text-slate-500">
        Masuk sebagai prototipe admin. Integrasi autentikasi menyusul.
      </div>
    </aside>

    <div class="flex-1 flex flex-col">
      <header class="border-b border-slate-800 bg-slate-950/70 backdrop-blur px-4 md:px-6 py-3 flex items-center justify-between gap-3">
        <div>
          <div class="flex items-center gap-2 text-xs text-emerald-300">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            <span>Dashboard Admin SIDARA</span>
          </div>
          <h1 class="text-sm md:text-base font-semibold text-slate-50">
            Ringkasan potensi desa dan aktivitas kurasi
          </h1>
        </div>
        <div class="flex items-center gap-2 text-[11px]">
          <span class="hidden sm:inline text-slate-400">Mode demo</span>
          <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-slate-800 text-slate-200 border border-slate-700">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            Admin Desa
          </span>
        </div>
      </header>

      <main class="flex-1 px-4 md:px-6 py-4 md:py-6 space-y-4 md:space-y-6">
        <section class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
          <div class="bg-slate-900 rounded-2xl border border-slate-800 p-3 md:p-4 flex flex-col gap-1.5">
            <div class="text-[11px] text-slate-400">Total potensi</div>
            <div class="text-lg md:text-xl font-semibold text-emerald-400">
              {{ number_format($totalPotentials) }}
            </div>
            <div class="text-[11px] text-slate-500">
              Dari seluruh desa yang terdaftar
            </div>
          </div>
          <div class="bg-slate-900 rounded-2xl border border-slate-800 p-3 md:p-4 flex flex-col gap-1.5">
            <div class="text-[11px] text-slate-400">Potensi terverifikasi</div>
            <div class="text-lg md:text-xl font-semibold text-emerald-200">
              {{ number_format($verifiedPotentials) }}
            </div>
            <div class="text-[11px] text-emerald-400">
              Siap tampil di halaman publik
            </div>
          </div>
          <div class="bg-slate-900 rounded-2xl border border-slate-800 p-3 md:p-4 flex flex-col gap-1.5">
            <div class="text-[11px] text-slate-400">Menunggu verifikasi</div>
            <div class="text-lg md:text-xl font-semibold text-amber-300">
              {{ number_format($pendingPotentials) }}
            </div>
            <div class="text-[11px] text-amber-300/80">
              Perlu ditinjau admin desa
            </div>
          </div>
          <div class="bg-slate-900 rounded-2xl border border-slate-800 p-3 md:p-4 flex flex-col gap-1.5">
            <div class="text-[11px] text-slate-400">Desa terdata</div>
            <div class="text-lg md:text-xl font-semibold text-sky-300">
              {{ number_format($totalVillages) }}
            </div>
            <div class="text-[11px] text-slate-500">
              Desa dengan profil di SIDARA
            </div>
          </div>
        </section>

        <section class="grid md:grid-cols-[3fr,2fr] gap-4 md:gap-6">
          <div class="bg-slate-900 rounded-2xl border border-slate-800 p-3 md:p-4">
            <div class="flex items-center justify-between mb-3 md:mb-4">
              <div>
                <h2 class="text-sm font-semibold text-slate-50">Pengajuan potensi terbaru</h2>
                <p class="text-[11px] text-slate-400">
                  Daftar potensi yang baru ditambahkan ke sistem.
                </p>
              </div>
            </div>
            <div class="overflow-x-auto">
              <table class="min-w-full text-left border-separate border-spacing-y-1 text-[11px]">
                <thead>
                  <tr class="text-slate-400">
                    <th class="px-2 py-1.5 font-medium">Potensi</th>
                    <th class="px-2 py-1.5 font-medium">Desa</th>
                    <th class="px-2 py-1.5 font-medium">Status</th>
                    <th class="px-2 py-1.5 font-medium text-right">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($latestPotentials as $potential)
                    <tr class="bg-slate-950/60 hover:bg-slate-800/70">
                      <td class="px-2 py-2 align-top">
                        <div class="font-medium text-slate-50 line-clamp-2">
                          {{ $potential->title }}
                        </div>
                        <div class="text-[10px] text-slate-500 line-clamp-1">
                          {{ $potential->description ?: 'Belum ada deskripsi.' }}
                        </div>
                      </td>
                      <td class="px-2 py-2 align-top">
                        <div class="text-[11px] text-slate-200">
                          {{ optional($potential->village)->village_name ?: '-' }}
                        </div>
                        <div class="text-[10px] text-slate-500">
                          {{ optional($potential->village)->district_name ?: '' }}
                        </div>
                      </td>
                      <td class="px-2 py-2 align-top">
                        @php
                          $status = $potential->verification_status;
                          $badgeClasses = 'bg-amber-500/10 text-amber-300 border-amber-400/40';
                          $label = 'Menunggu';

                          if ($status === 'verified') {
                              $badgeClasses = 'bg-emerald-500/15 text-emerald-300 border-emerald-400/40';
                              $label = 'Terverifikasi';
                          } elseif ($status === 'rejected') {
                              $badgeClasses = 'bg-rose-500/10 text-rose-300 border-rose-400/40';
                              $label = 'Ditolak';
                          }
                        @endphp
                        <span class="inline-flex px-2 py-0.5 rounded-full border text-[10px] {{ $badgeClasses }}">
                          {{ $label }}
                        </span>
                      </td>
                      <td class="px-2 py-2 align-top text-right">
                        <a href="{{ route('potentials.show', $potential->slug) }}" class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-slate-800 text-[10px] text-slate-100 border border-slate-700">
                          Detail publik
                        </a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="px-2 py-4 text-center text-[11px] text-slate-500">
                        Belum ada data potensi di sistem.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          <div class="space-y-4">
            <div class="bg-slate-900 rounded-2xl border border-slate-800 p-3 md:p-4">
              <div class="flex items-center justify-between mb-3">
                <div>
                  <h2 class="text-sm font-semibold text-slate-50">Desa dengan potensi terbanyak</h2>
                  <p class="text-[11px] text-slate-400">5 desa teratas berdasarkan jumlah potensi.</p>
                </div>
              </div>
              <div class="space-y-2">
                @forelse($potentialsByDistrict as $village)
                  <div class="flex items-center justify-between gap-2 p-2 rounded-xl bg-slate-950/60">
                    <div>
                      <div class="text-[11px] font-medium text-slate-100">
                        {{ $village->village_name }}
                      </div>
                      <div class="text-[10px] text-slate-500">
                        {{ $village->district_name }}
                      </div>
                    </div>
                    <div class="flex items-baseline gap-1">
                      <span class="text-sm font-semibold text-emerald-300">
                        {{ $village->potentials_count }}
                      </span>
                      <span class="text-[10px] text-slate-400">
                        potensi
                      </span>
                    </div>
                  </div>
                @empty
                  <p class="text-[11px] text-slate-500">
                    Belum ada desa dengan data potensi.
                  </p>
                @endforelse
              </div>
            </div>

            <div class="bg-gradient-to-r from-emerald-600 to-emerald-500 rounded-2xl p-3 md:p-4 text-slate-950">
              <div class="text-[11px] font-semibold uppercase tracking-wide">
                Alur kerja admin desa
              </div>
              <p class="mt-1 text-sm font-semibold">
                Verifikasi potensi dari warga sebelum tampil ke publik.
              </p>
              <p class="mt-1 text-[11px]">
                Fitur aksi seperti setujui, revisi, dan tolak pengajuan akan
                ditambahkan pada iterasi berikutnya.
              </p>
              <a href="{{ route('admin.potentials.index') }}" class="inline-flex items-center justify-center gap-2 mt-2 text-xs font-semibold bg-slate-950/90 hover:bg-slate-900 text-emerald-200 rounded-xl px-3 py-2">
                Kelola Potensi Desa
              </a>
            </div>
          </div>
        </section>
      </main>
    </div>
  </div>
</body>
</html>
