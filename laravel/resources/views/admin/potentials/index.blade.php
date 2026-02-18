<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Potensi Desa - SIDARA</title>
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
          Kelola potensi desa
        </h1>
      </div>
      <div class="flex items-center gap-2 text-[11px]">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-slate-900 border border-slate-700 text-slate-200">
          <span>Dashboard</span>
        </a>
        <a href="{{ route('home') }}" class="hidden sm:inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-slate-900 border border-slate-700 text-slate-200">
          <span>Halaman publik</span>
        </a>
      </div>
    </header>

    <main class="flex-1 px-4 md:px-6 py-4 md:py-6 space-y-4 md:space-y-6">
      @if(session('status'))
        <div class="max-w-5xl mx-auto">
          <div class="rounded-2xl border border-emerald-500/40 bg-emerald-500/10 text-emerald-100 px-3 py-2 text-[11px]">
            {{ session('status') }}
          </div>
        </div>
      @endif

      <section class="max-w-5xl mx-auto bg-slate-900 rounded-2xl border border-slate-800 p-3 md:p-4 space-y-3 md:space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
          <div>
            <h2 class="text-sm font-semibold text-slate-50">Daftar potensi desa</h2>
            <p class="text-[11px] text-slate-400">
              CRUD sederhana untuk mengelola data potensi desa.
            </p>
          </div>
          <a href="{{ route('admin.potentials.create') }}" class="inline-flex items-center justify-center gap-2 text-xs font-semibold bg-emerald-500 hover:bg-emerald-400 text-slate-950 rounded-xl px-3 py-2">
            <span class="text-base leading-none">+</span>
            <span>Tambah Potensi</span>
          </a>
        </div>

        <form method="GET" action="{{ route('admin.potentials.index') }}" class="flex flex-col md:flex-row gap-2 md:gap-3 text-[11px]">
          <div class="flex-1 flex items-center gap-2 bg-slate-950 rounded-xl px-3 py-2 border border-slate-700">
            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none">
              <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="1.5"></circle>
              <path d="M15.5 15.5L20 20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            </svg>
            <input
              type="text"
              name="q"
              value="{{ request('q') }}"
              placeholder="Cari judul atau deskripsi potensi..."
              class="w-full bg-transparent outline-none placeholder:text-slate-500 text-slate-100"
            >
          </div>
          <select name="status" class="md:w-40 bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-slate-100 text-[11px]">
            <option value="">Semua status</option>
            <option value="pending" @if(request('status') === 'pending') selected @endif>Menunggu</option>
            <option value="verified" @if(request('status') === 'verified') selected @endif>Terverifikasi</option>
            <option value="rejected" @if(request('status') === 'rejected') selected @endif>Ditolak</option>
          </select>
          <button type="submit" class="md:w-28 inline-flex items-center justify-center px-3 py-2 rounded-xl bg-slate-800 text-slate-100 border border-slate-700 text-[11px] font-semibold">
            Filter
          </button>
        </form>

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
              @forelse($potentials as $potential)
                <tr class="bg-slate-950/70 hover:bg-slate-800/80">
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
                    <div class="inline-flex items-center gap-1.5">
                      <a href="{{ route('admin.potentials.edit', $potential) }}" class="px-2 py-1 rounded-full bg-slate-800 text-slate-100 border border-slate-700">
                        Edit
                      </a>
                      <form method="POST" action="{{ route('admin.potentials.destroy', $potential) }}" onsubmit="return confirm('Hapus potensi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1 rounded-full bg-rose-600/80 text-rose-50 border border-rose-400/40">
                          Hapus
                        </button>
                      </form>
                    </div>
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

        <div class="pt-2">
          {{ $potentials->links() }}
        </div>
      </section>
    </main>
  </div>
</body>
</html>

