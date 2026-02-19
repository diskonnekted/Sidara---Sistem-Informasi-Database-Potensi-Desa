@extends('layouts.admin')

@section('header', 'Edit Pengguna')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password baru (opsional)</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50">
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50">
                    @foreach($roles as $value => $label)
                        <option value="{{ $value }}" {{ old('role', $user->role) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('role')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="village_id" class="block text-sm font-medium text-gray-700">Desa (untuk Admin Desa / Pemilik)</label>
                <select name="village_id" id="village_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50">
                    <option value="">Tidak terkait desa</option>
                    @foreach($villages as $village)
                        <option value="{{ $village->id }}" {{ (string) old('village_id', $user->village_id) === (string) $village->id ? 'selected' : '' }}>
                            {{ $village->village_name }}
                        </option>
                    @endforeach
                </select>
                @error('village_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Avatar</label>
                <div class="flex items-center space-x-4">
                    <div class="h-16 w-16 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                        @if ($user->avatar_path)
                            <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                        @else
                            <span class="text-sm text-gray-500">Tidak ada</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" name="avatar" id="avatar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('avatar')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <div class="mt-2 flex items-center space-x-2">
                            <input type="checkbox" name="remove_avatar" id="remove_avatar" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <label for="remove_avatar" class="text-xs text-gray-600">Hapus avatar</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.users.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md mr-2 hover:bg-gray-300">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Simpan</button>
        </div>
    </form>
</div>
@endsection

