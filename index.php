<?php

require __DIR__ . '/data.php';

$q = isset($_GET['q']) ? (string) $_GET['q'] : '';
$district = isset($_GET['district']) ? (string) $_GET['district'] : '';

$allPotentials = sidara_potentials();
$potentials = sidara_filter_potentials($allPotentials, $q, $district);

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>SIDARA – Sistem Informasi Database Potensi Desa Banjarnegara</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5f2ec] text-slate-900">
  <div class="min-h-screen flex flex-col">
    <header class="bg-emerald-900 text-emerald-50">
      <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between gap-3">
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-xl bg-emerald-500 flex items-center justify-center">
            <span class="text-xs font-semibold tracking-wider">SD</span>
          </div>
          <div>
            <div class="text-xs font-semibold tracking-wide uppercase">SIDARA</div>
            <div class="text-[11px] text-emerald-100">Potensi Desa Banjarnegara</div>
          </div>
        </div>
        <div class="hidden sm:flex items-center gap-2 text-[11px]">
          <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-800/70 text-emerald-100 border border-emerald-500/60">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            <span>Prototype data</span>
          </span>
          <span class="text-emerald-100/80">Preview lokal SIDARA</span>
        </div>
      </div>
    </header>

    <main class="flex-1">
      <div class="max-w-5xl mx-auto px-4 py-5 md:py-8 space-y-5 md:space-y-6">
        <section class="relative rounded-3xl overflow-hidden bg-slate-900 text-white border border-amber-100 shadow-sm">
          <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-900 via-slate-900 to-slate-900 opacity-95"></div>
            <div class="absolute -right-16 -bottom-16 w-64 h-64 rounded-full bg-emerald-500/20 blur-3xl"></div>
          </div>
          <div class="relative px-4 md:px-6 py-5 md:py-6 flex flex-col md:flex-row gap-5 md:gap-6 items-start md:items-center">
            <div class="flex-1 space-y-3 md:space-y-4">
              <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-emerald-800/60 border border-emerald-500/60 text-[11px]">
                <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-emerald-500 text-[9px] font-semibold">ID</span>
                <span class="uppercase tracking-wide font-semibold text-emerald-100">Database Potensi Desa Banjarnegara</span>
              </div>
              <div class="space-y-1.5">
                <h1 class="text-lg md:text-2xl font-semibold leading-snug">
                  Satu pintu data potensi desa untuk Banjarnegara
                </h1>
                <p class="text-[11px] md:text-xs text-emerald-100 leading-relaxed max-w-xl">
                  Telusuri peluang wisata, UMKM, dan potensi ekonomi desa di Banjarnegara
                  dalam satu tampilan yang rapi, terverifikasi, dan mudah diakses.
                </p>
              </div>
              <form method="GET" action="index.php" class="space-y-2">
                <div class="bg-white/95 text-slate-900 rounded-2xl px-3.5 py-2.5 flex flex-col md:flex-row items-stretch md:items-center gap-2 md:gap-3 shadow-sm">
                  <div class="flex items-center gap-2 flex-1">
                    <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none">
                      <circle cx="11" cy="11" r="5" stroke="currentColor" stroke-width="1.6"></circle>
                      <path d="M15.5 15.5L19 19" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"></path>
                    </svg>
                    <input
                      type="text"
                      name="q"
                      value="<?php echo htmlspecialchars($q, ENT_QUOTES, 'UTF-8'); ?>"
                      placeholder="Apa potensi desa yang Anda cari?"
                      class="w-full text-sm bg-transparent outline-none placeholder:text-slate-400"
                    />
                  </div>
                  <div class="flex flex-col md:flex-row gap-2 md:gap-3 md:items-center">
                    <select
                      name="district"
                      class="flex-1 md:flex-none md:w-40 text-xs bg-white/90 border border-white/60 rounded-xl px-3 py-2.5 text-slate-700"
                    >
                      <option value="">Semua Kecamatan</option>
                      <option value="Banjarnegara" <?php echo $district === 'Banjarnegara' ? 'selected' : ''; ?>>Banjarnegara</option>
                      <option value="Batur" <?php echo $district === 'Batur' ? 'selected' : ''; ?>>Batur</option>
                    </select>
                    <button
                      type="submit"
                      class="flex-1 md:flex-none md:w-32 inline-flex items-center justify-center gap-2 text-xs font-semibold tracking-wide uppercase bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl px-4 py-2.5 shadow-sm"
                    >
                      Cari
                    </button>
                  </div>
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
                    Pertanian
                  </span>
                </div>
              </form>
            </div>
            <div class="w-full md:w-64 bg-white/5 border border-emerald-700/50 rounded-3xl p-3.5 md:p-4 backdrop-blur-sm">
              <div class="flex items-center justify-between mb-2">
                <p class="text-[11px] font-semibold text-emerald-100 uppercase tracking-wide">Ringkasan hari ini</p>
              </div>
              <dl class="space-y-2.5 text-[11px] text-emerald-50/90">
                <div class="flex items-center justify-between">
                  <dt class="flex items-center gap-1">Total potensi</dt>
                  <dd class="font-semibold text-emerald-100"><?php echo count($allPotentials); ?></dd>
                </div>
                <div class="flex items-center justify-between">
                  <dt>Potensi wisata</dt>
                  <dd class="font-semibold text-emerald-100">1</dd>
                </div>
                <div class="flex items-center justify-between">
                  <dt>Potensi UMKM</dt>
                  <dd class="font-semibold text-emerald-100">1</dd>
                </div>
                <div class="flex items-center justify-between">
                  <dt>Potensi pertanian</dt>
                  <dd class="font-semibold text-emerald-100">1</dd>
                </div>
              </dl>
            </div>
          </div>
        </section>

        <section class="space-y-3 md:space-y-4">
          <div class="flex items-center justify-between gap-2">
            <div>
              <h2 class="text-sm md:text-base font-semibold text-slate-900">
                Potensi unggulan hari ini
              </h2>
              <p class="text-[11px] md:text-xs text-slate-600">
                Contoh data potensi desa dari beberapa kecamatan di Banjarnegara.
              </p>
            </div>
            <a href="peta.php" class="hidden md:inline-flex items-center gap-2 text-[11px] font-semibold text-emerald-700">
              <span>Lihat di peta</span>
            </a>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5">
            <?php if (count($potentials) > 0): ?>
              <?php foreach ($potentials as $potential): ?>
                <article class="bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 flex flex-col">
                  <div class="relative h-32 md:h-36 bg-slate-200">
                    <img
                      src="<?php echo htmlspecialchars($potential['image'], ENT_QUOTES, 'UTF-8'); ?>"
                      alt="<?php echo htmlspecialchars($potential['title'], ENT_QUOTES, 'UTF-8'); ?>"
                      class="w-full h-full object-cover"
                    />
                    <div class="absolute top-2 left-2 inline-flex items-center px-2 py-0.5 rounded-full bg-black/45 backdrop-blur text-[10px] text-white">
                      <span><?php echo htmlspecialchars($potential['category'], ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                  </div>
                  <div class="p-3.5 md:p-4 flex-1 flex flex-col gap-2">
                    <div class="space-y-1">
                      <h3 class="text-sm font-semibold text-slate-900 line-clamp-2">
                        <?php echo htmlspecialchars($potential['title'], ENT_QUOTES, 'UTF-8'); ?>
                      </h3>
                      <p class="text-[11px] text-slate-500 line-clamp-2">
                        <?php echo htmlspecialchars($potential['description'], ENT_QUOTES, 'UTF-8'); ?>
                      </p>
                    </div>
                    <div class="mt-auto flex items-center justify-between gap-2">
                      <div class="space-y-0.5">
                        <p class="text-[11px] font-medium text-emerald-700">
                          <?php echo htmlspecialchars($potential['price_range'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                        <p class="text-[10px] text-slate-500">
                          <?php echo htmlspecialchars($potential['village_name'], ENT_QUOTES, 'UTF-8'); ?>,
                          <?php echo htmlspecialchars($potential['district_name'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                      </div>
                      <a
                        href="potensi.php?slug=<?php echo urlencode($potential['slug']); ?>"
                        class="text-[11px] font-semibold text-emerald-700"
                      >
                        Detail
                      </a>
                    </div>
                  </div>
                </article>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="text-xs text-slate-500 col-span-3">
                Tidak ada potensi yang cocok dengan filter pencarian.
              </p>
            <?php endif; ?>
          </div>
        </section>
      </div>
    </main>

    <nav class="fixed bottom-0 inset-x-0 z-20 md:hidden">
      <div class="mx-auto max-w-md px-4 pb-3">
        <div class="bg-white rounded-2xl shadow-xl border border-amber-100 px-4 py-1.5 flex justify-between">
          <span class="flex flex-col items-center justify-center flex-1 py-1.5 text-emerald-700">
            <svg class="w-5 h-5 mb-0.5" viewBox="0 0 24 24" fill="none">
              <path d="M5 11L12 4L19 11V19C19 19.5523 18.5523 20 18 20H6C5.44772 20 5 19.5523 5 19V11Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"></path>
              <path d="M10 20V14H14V20" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="text-[10px] font-semibold">Beranda</span>
          </span>
          <a href="peta.php" class="flex flex-col items-center justify-center flex-1 py-1.5 text-slate-500">
            <svg class="w-5 h-5 mb-0.5" viewBox="0 0 24 24" fill="none">
              <path d="M8 7C8 5.89543 8.89543 5 10 5H14C15.1046 5 16 5.89543 16 7V9C16 10.1046 15.1046 11 14 11H10C8.89543 11 8 10.1046 8 9V7Z" stroke="currentColor" stroke-width="1.6"></path>
              <path d="M5 17C5 15.8954 5.89543 15 7 15H17C18.1046 15 19 15.8954 19 17V18C19 18.5523 18.5523 19 18 19H6C5.44772 19 5 18.5523 5 18V17Z" stroke="currentColor" stroke-width="1.6"></path>
            </svg>
            <span class="text-[10px] font-medium">Peta</span>
          </a>
          <span class="flex flex-col items-center justify-center flex-1 py-1.5 text-slate-500">
            <svg class="w-5 h-5 mb-0.5" viewBox="0 0 24 24" fill="none">
              <circle cx="12" cy="9" r="3" stroke="currentColor" stroke-width="1.6"></circle>
              <path d="M7 19C7.80377 17.136 9.70189 16 12 16C14.2981 16 16.1962 17.136 17 19" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"></path>
            </svg>
            <span class="text-[10px] font-medium">Akun</span>
          </span>
        </div>
      </div>
    </nav>
  </div>
</body>
</html>

