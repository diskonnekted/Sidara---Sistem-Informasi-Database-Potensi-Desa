<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Peta Desa - SIDARA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""
  >
  <script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""
  ></script>
</head>
<body class="bg-[#f5f2ec] text-slate-900">
  <div class="min-h-screen flex flex-col">
    <header class="bg-emerald-900 text-emerald-50">
      <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
          <img
            src="{{ asset('logo.jpeg') }}"
            alt="Logo SIDARA"
            class="w-8 h-8 rounded-xl object-contain bg-emerald-700/80 p-1"
          >
          <div>
            <div class="text-xs font-semibold tracking-wide uppercase">SIDARA</div>
            <div class="text-[11px] text-emerald-100">Peta Desa Banjarnegara</div>
          </div>
        </a>
        <div class="hidden sm:flex items-center gap-2 text-[11px] text-emerald-100">
          <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
          <span>Layer desa berbasis GeoJSON</span>
        </div>
      </div>
    </header>

    <main class="flex-1">
      <div class="max-w-6xl mx-auto px-4 py-4 md:py-6 space-y-3">
        <div class="flex items-center justify-between gap-3">
          <div>
            <h1 class="text-base md:text-lg font-semibold text-slate-900">
              Peta Persebaran Desa
            </h1>
            <p class="text-[11px] md:text-xs text-slate-600">
              Setiap polygon mewakili wilayah administrasi desa di Kabupaten Banjarnegara.
              Klik pada area untuk melihat nama desa dan kecamatan.
            </p>
          </div>
        </div>

        <div class="bg-white rounded-3xl border border-amber-100 shadow-sm overflow-hidden">
          <div id="map" class="w-full h-[70vh] md:h-[75vh]"></div>
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
          <a href="#" class="flex flex-col items-center justify-center flex-1 py-1.5 text-slate-500">
            <svg class="w-5 h-5 mb-0.5" viewBox="0 0 24 24" fill="none">
              <circle cx="11" cy="11" r="5" stroke="currentColor" stroke-width="1.6"></circle>
              <path d="M15.5 15.5L19 19" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"></path>
            </svg>
            <span class="text-[10px] font-medium">Jelajah</span>
          </a>
          <span class="flex flex-col items-center justify-center flex-1 py-1.5 text-emerald-700">
            <svg class="w-5 h-5 mb-0.5" viewBox="0 0 24 24" fill="none">
              <path d="M8 7C8 5.89543 8.89543 5 10 5H14C15.1046 5 16 5.89543 16 7V9C16 10.1046 15.1046 11 14 11H10C8.89543 11 8 10.1046 8 9V7Z" stroke="currentColor" stroke-width="1.6"></path>
              <path d="M5 17C5 15.8954 5.89543 15 7 15H17C18.1046 15 19 15.8954 19 17V18C19 18.5523 18.5523 19 18 19H6C5.44772 19 5 18.5523 5 18V17Z" stroke="currentColor" stroke-width="1.6"></path>
            </svg>
            <span class="text-[10px] font-semibold">Peta</span>
          </span>
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

  <script>
    var map = L.map('map', {
      zoomControl: true
    }).setView([-7.45, 109.6], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
      attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    fetch('/Docs/peta-desa/peta_desa.geojson')
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        var layer = L.geoJSON(data, {
          style: function () {
            return {
              color: '#059669',
              weight: 1,
              fillColor: '#6ee7b7',
              fillOpacity: 0.35
            };
          },
          onEachFeature: function (feature, layer) {
            var props = feature.properties || {};
            var nama = props.Nama_Desa_ || 'Tanpa nama';
            var kec = props.Kecamatan || '';
            var kab = props.Kabupaten || '';
            var html = '<div class="text-[11px]">' +
              '<div class="font-semibold text-slate-900 mb-1">' + nama + '</div>' +
              '<div class="text-slate-700">' + kec + '</div>' +
              '<div class="text-slate-500">' + kab + '</div>' +
              '</div>';
            layer.bindPopup(html);
          }
        }).addTo(map);

        map.fitBounds(layer.getBounds(), {
          padding: [20, 20]
        });
      })
      .catch(function () {
        console.error('Gagal memuat data peta desa.');
      });
  </script>
</body>
</html>
