@extends('layouts.admin')

@section('header', 'Manajemen Produk')

@section('content')
<div class="space-y-4">
    <div class="bg-white shadow-md rounded-lg px-4 py-4">
        <form method="GET" action="{{ route('admin.potentials.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label for="category" class="block text-xs font-medium text-gray-700 mb-1">Kategori potensi</label>
                <select id="category" name="category" class="block w-full rounded-md border-gray-300 bg-gray-50 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua kategori</option>
                    @foreach($categories as $code => $label)
                        <option value="{{ $code }}" {{ request('category') === $code ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="district" class="block text-xs font-medium text-gray-700 mb-1">Kecamatan</label>
                <select id="district" name="district" class="block w-full rounded-md border-gray-300 bg-gray-50 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua kecamatan</option>
                    @foreach($districts as $district)
                        <option value="{{ $district }}" {{ request('district') === $district ? 'selected' : '' }}>
                            {{ $district }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="village" class="block text-xs font-medium text-gray-700 mb-1">Desa</label>
                <select id="village" name="village" class="block w-full rounded-md border-gray-300 bg-gray-50 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua desa</option>
                    @foreach($villages as $village)
                        <option value="{{ $village }}" {{ request('village') === $village ? 'selected' : '' }}>
                            {{ $village }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="block text-xs font-medium text-gray-700 mb-1">Status verifikasi</label>
                <select id="status" name="status" class="block w-full rounded-md border-gray-300 bg-gray-50 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua status</option>
                    <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 rounded-md bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700">
                    Terapkan
                </button>
                <a href="{{ route('admin.potentials.index') }}" class="inline-flex items-center px-3 py-2 rounded-md bg-gray-100 text-xs font-medium text-gray-700 hover:bg-gray-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('admin.potentials.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">
            + Tambah Produk
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Nama Produk
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Desa
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                </th>
                <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Aksi</span>
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($potentials as $potential)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $potential->title }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $potential->village->village_name ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($potential->verification_status == 'verified') bg-green-100 text-green-800 @elseif($potential->verification_status == 'pending') bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif">
                            {{ $potential->verification_status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.potentials.edit', $potential) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('admin.potentials.destroy', $potential) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                        Tidak ada produk yang ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <div class="mt-4">
        {{ $potentials->links() }}
    </div>
</div>
@endsection
