@if($products->count() > 0)
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5 overflow-x-hidden">
    @foreach($products as $product)
      <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200 hover:border-emerald-300 transition-colors">
        <div class="w-full h-48 bg-gray-100 rounded-xl mb-3 flex items-center justify-center overflow-hidden">
          @if(isset($product->images[0]))
            <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
          @else
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          @endif
        </div>
        <h3 class="text-sm font-semibold text-slate-900 mb-1">{{ $product->title }}</h3>
        <p class="text-xs text-slate-600 mb-2">{{ Str::limit($product->description, 80) }}</p>
        
        @if($product->village)
          <p class="text-xs text-slate-500 mb-2">
            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            {{ $product->village->village_name }}, {{ $product->village->district_name }}
          </p>
        @endif
        
        @if(isset($product->attributes['product_category']))
          <span class="inline-block bg-emerald-100 text-emerald-800 text-xs px-2 py-1 rounded-full mb-3">
            {{ $product->attributes['product_category'] }}
          </span>
        @endif
        
        <div class="flex items-center gap-2 mt-4">
          <a 
            href="{{ route('products.show', $product->id) }}"
            class="flex-1 text-center bg-slate-200 text-slate-800 text-sm py-2 rounded-lg hover:bg-slate-300 transition-colors"
          >
            Detail
          </a>
          @if($product->whatsapp_number)
            <a 
              href="https://wa.me/{{ $product->whatsapp_number }}?text=Halo, saya tertarik dengan produk {{ $product->title }}" 
              target="_blank"
              class="flex-1 bg-emerald-600 text-white text-center text-sm py-2 rounded-lg hover:bg-emerald-700 transition-colors"
            >
              WhatsApp
            </a>
          @endif
        </div>
      </div>
    @endforeach
  </div>

  <!-- Pagination -->
  <div class="mt-8">
    {{ $products->links() }}
  </div>
@else
  <div class="text-center py-12">
    <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-16"></path>
    </svg>
    <p class="text-slate-600">Tidak ada produk yang ditemukan.</p>
    @if(request()->anyFilled(['search', 'category', 'kecamatan', 'desa', 'harga_min', 'harga_max']))
      <a href="{{ route('products.index') }}" class="text-emerald-600 hover:text-emerald-700 mt-2 inline-block">
        Reset filter
      </a>
    @endif
  </div>
@endif