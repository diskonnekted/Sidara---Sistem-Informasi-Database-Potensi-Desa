@extends('layouts.admin')

@section('header', 'Tambah Produk Baru')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <form action="{{ route('admin.potentials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Judul -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50" required>
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Desa -->
            <div>
                <label for="village_id" class="block text-sm font-medium text-gray-700">Desa</label>
                <select name="village_id" id="village_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50" required>
                    @foreach($villages as $village)
                        <option value="{{ $village->id }}" {{ old('village_id') == $village->id ? 'selected' : '' }}>{{ $village->village_name }}</option>
                    @endforeach
                </select>
                @error('village_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Deskripsi -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50">{{ old('description') }}</textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Status Verifikasi -->
            <div>
                <label for="verification_status" class="block text-sm font-medium text-gray-700">Status Verifikasi</label>
                <select name="verification_status" id="verification_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50">
                    <option value="pending" {{ old('verification_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="verified" {{ old('verification_status') == 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="rejected" {{ old('verification_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                @error('verification_status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Koordinat -->
            <div>
                <label for="coordinates" class="block text-sm font-medium text-gray-700">Koordinat (Contoh: -7.12345, 109.12345)</label>
                <input type="text" name="coordinates" id="coordinates" value="{{ old('coordinates') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50">
                @error('coordinates') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Upload Foto -->
            <div class="md:col-span-2">
                <label for="images" class="block text-sm font-medium text-gray-700">Upload Foto (Bisa lebih dari satu)</label>
                <input type="file" name="images[]" id="images" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                @error('images.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Kontak -->
            <div>
                <label for="contact" class="block text-sm font-medium text-gray-700">Kontak (Nomor WhatsApp)</label>
                <input type="text" name="contact" id="contact" value="{{ old('contact') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50">
                @error('contact') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Kisaran Harga -->
            <div>
                <label for="price_range" class="block text-sm font-medium text-gray-700">Kisaran Harga</label>
                <input type="text" name="price_range" id="price_range" value="{{ old('price_range') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50">
                @error('price_range') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Sumber Data -->
            <div class="md:col-span-2">
                <label for="data_source" class="block text-sm font-medium text-gray-700">Sumber Data</label>
                <input type="text" name="data_source" id="data_source" value="{{ old('data_source') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50">
                @error('data_source') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.potentials.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md mr-2 hover:bg-gray-300">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
