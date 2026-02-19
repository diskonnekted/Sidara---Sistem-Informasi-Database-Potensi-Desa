<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Peta Desa - SIDARA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .sidara-popup .leaflet-popup-content-wrapper {
      background: transparent;
      box-shadow: none;
      border-radius: 0;
      padding: 0;
    }
    .sidara-popup .leaflet-popup-content {
      margin: 0;
    }
    .sidara-popup .leaflet-popup-tip {
      background: transparent;
      box-shadow: none;
    }
  </style>
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

  @php
    $potentialPoints = isset($potentials)
        ? $potentials->map(function ($p) {
            $firstImage = $p->images[0] ?? null;

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

            return [
                'id' => $p->id,
                'title' => $p->title,
                'lat' => $p->latitude,
                'lng' => $p->longitude,
                'village' => optional($p->village)->village_name,
                'district' => optional($p->village)->district_name,
                'status' => $p->verification_status,
                'url' => route('potentials.show', $p->slug),
                'image' => $firstImageUrl,
            ];
        })
        : collect();
  @endphp

  <script>
    var potentials = @json($potentialPoints);

    function addPotentialMarkers(map, bounds) {
      potentials.forEach(function (p) {
        if (!p.lat || !p.lng) {
          return;
        }

        var marker = L.marker([p.lat, p.lng]).addTo(map);
        var popupHtml = ''
          + '<div class=\"w-52 bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-100\">'
          + '  <div class=\"relative h-24\">'
          + '    <img src=\"' + (p.image || '') + '\" alt=\"' + p.title + '\"'
          + '      class=\"w-full h-full object-cover\">'
          + '    <div class=\"absolute inset-0 bg-gradient-to-t from-black/60 to-transparent\"></div>'
          + '    <div class=\"absolute bottom-1.5 left-1.5 right-1.5 flex items-center justify-between\">'
          + '      <div class=\"px-1.5 py-0.5 rounded-full bg-black/50 text-[9px] text-white truncate\">'
          +          (p.village ? p.village : 'Potensi Desa')
          + '      </div>'
          + '      <span class=\"px-1.5 py-0.5 rounded-full bg-emerald-500 text-[9px] text-white font-semibold\">'
          + '        Detail'
          + '      </span>'
          + '    </div>'
          + '  </div>'
          + '  <div class=\"p-2.5 space-y-1\">'
          + '    <div class=\"text-[11px] font-semibold text-slate-900 leading-snug line-clamp-2\">' + p.title + '</div>'
          +      (p.district
                    ? '    <div class=\"text-[10px] text-slate-500\">' + (p.village ? p.village + ', ' : '') + p.district + '</div>'
                    : '')
          + '    <div class=\"pt-1\">'
          + '      <a href=\"' + p.url + '\"'
          + '        class=\"inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100 text-[10px] font-medium\">'
          + '        <span>Lihat detail</span>'
          + '      </a>'
          + '    </div>'
          + '  </div>'
          + '</div>';

        marker.bindPopup(popupHtml, {
          closeButton: false,
          className: 'sidara-popup'
        });

        if (bounds) {
          bounds.extend([p.lat, p.lng]);
        }
      });
    }

    var map = L.map('map', {
      zoomControl: true
    }).setView([-7.45, 109.6], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
      attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    var hasAnyPotential = potentials && potentials.length > 0;

    fetch('/docs/peta-desa/peta_desa.geojson')
      .then(function (response) {
        if (!response.ok) {
          throw new Error('GeoJSON not found');
        }
        return response.json();
      })
      .then(function (data) {
        var layer = L.geoJSON(data, {
          style: function () {
            return {
              color: '#059669',
              weight: 0.4,
              fillColor: '#6ee7b7',
              fillOpacity: 0.25
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

        var bounds = layer.getBounds();

        if (hasAnyPotential) {
          addPotentialMarkers(map, bounds);
        }

        if (bounds.isValid && typeof bounds.isValid === 'function') {
          if (bounds.isValid()) {
            map.fitBounds(bounds, {
              padding: [20, 20]
            });
          }
        } else {
          map.fitBounds(bounds, {
            padding: [20, 20]
          });
        }
      })
      .catch(function () {
        console.error('Gagal memuat data peta desa.');

        if (hasAnyPotential) {
          var bounds = L.latLngBounds();
          addPotentialMarkers(map, bounds);
          if (bounds.isValid()) {
            map.fitBounds(bounds, { padding: [20, 20] });
          }
        }
      });
  </script>
</body>
</html>
