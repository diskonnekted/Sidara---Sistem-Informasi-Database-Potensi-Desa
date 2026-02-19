<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>{{ $product->title }} - Produk SIDARA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#059669">
  <link rel="manifest" href="{{ asset('manifest.json') }}?v={{ time() }}">
  <link rel="apple-touch-icon" href="{{ asset('logo.jpg') }}?v={{ time() }}">
  <link rel="icon" href="{{ asset('logo.jpg') }}?v={{ time() }}" type="image/jpeg">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <div class="max-w-4xl mx-auto p-4">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
      <div class="relative">
        @if(isset($product->images[0]))
          <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->title }}" class="w-full h-64 object-cover">
        @else
          <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
          </div>
        @endif
        <div class="absolute top-0 left-0 p-4">
          <a href="{{ route('products.index') }}" class="bg-white/80 backdrop-blur-sm rounded-full p-2 hover:bg-white transition-colors">
            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
          </a>
        </div>
      </div>
      <div class="p-6">
        <div class="flex justify-between items-start">
          <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->title }}</h1>
          @if(isset($product->attributes['product_category']))
            <span class="bg-emerald-100 text-emerald-800 text-sm font-medium px-3 py-1 rounded-full">{{ $product->attributes['product_category'] }}</span>
          @endif
        </div>
        <p class="text-lg font-semibold text-emerald-600 mb-4">{{ $product->price_range }}</p>
        
        <div class="prose max-w-none text-gray-700 mb-6">
          {!! nl2br(e($product->description)) !!}
        </div>

        <div class="border-t border-gray-200 pt-4">
          <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Informasi Tambahan</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-800">
            <div>
              <p class="font-semibold">Lokasi:</p>
              <p>{{ $product->village->village_name }}, {{ $product->village->district_name }}</p>
            </div>
            @if($product->whatsapp_number)
            <div>
              <p class="font-semibold">Hubungi Penjual:</p>
              <a href="https://wa.me/{{ $product->whatsapp_number }}" target="_blank" class="text-emerald-600 hover:underline">{{ $product->whatsapp_number }}</a>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
