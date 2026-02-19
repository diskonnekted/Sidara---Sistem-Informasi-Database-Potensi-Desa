<div class="bg-white rounded-2xl p-4 md:p-5 mb-6 shadow-sm border border-slate-200">
  <form method="GET" action="{{ route('products.index') }}" class="space-y-3 md:space-y-0 md:grid md:grid-cols-2 lg:grid-cols-6 md:gap-3 items-center">
    
    <div class="relative lg:col-span-2">
      <input 
        type="text" 
        name="search" 
        placeholder="Cari produk, kerajinan, jasa..." 
        value="{{ request('search') }}"
        class="w-full pl-10 pr-4 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
      >
      <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
      </div>
    </div>

    <select name="category" class="w-full text-sm px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
      <option value="">Semua Kategori</option>
      @foreach($categories as $category)
        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
      @endforeach
    </select>

    <select name="kecamatan" class="w-full text-sm px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
      <option value="">Semua Kecamatan</option>
      @foreach($kecamatans as $kecamatan)
        <option value="{{ $kecamatan }}" {{ request('kecamatan') == $kecamatan ? 'selected' : '' }}>{{ $kecamatan }}</option>
      @endforeach
    </select>

    <div class="grid grid-cols-2 gap-2">
        <input 
            type="number" 
            name="harga_min" 
            placeholder="Harga Min" 
            value="{{ request('harga_min') }}"
            class="w-full text-sm px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
        >
        <input 
            type="number" 
            name="harga_max" 
            placeholder="Harga Max" 
            value="{{ request('harga_max') }}"
            class="w-full text-sm px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
        >
    </div>

    <div class="flex items-center gap-2">
        <button type="submit" class="w-full bg-emerald-600 text-white px-5 py-2 text-sm rounded-lg hover:bg-emerald-700 transition-colors font-medium">
          Filter
        </button>
        <a href="{{ route('products.index') }}" class="text-slate-500 hover:text-slate-700 p-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4l16 16"></path>
            </svg>
        </a>
    </div>
  </form>
</div>