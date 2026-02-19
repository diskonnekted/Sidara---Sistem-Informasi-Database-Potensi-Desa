@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
<div class="space-y-8">
    <div class="relative overflow-hidden rounded-3xl px-6 py-8 sm:px-10 sm:py-10 shadow-xl" style="background: linear-gradient(135deg, #219ebc, #023047);">
        <div class="absolute inset-0 opacity-30">
            <div class="absolute -right-16 -top-16 h-40 w-40 rounded-full blur-3xl" style="background-color:#8ecae6;"></div>
            <div class="absolute -left-10 bottom-0 h-32 w-32 rounded-full blur-3xl" style="background-color:#fb8500;"></div>
        </div>
        <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wide" style="background-color:#ffb703; color:#023047;">
                    Ringkasan SIDARA
                </p>
                <h2 class="mt-3 text-2xl sm:text-3xl font-semibold text-white tracking-tight">Ringkasan Potensi Desa</h2>
                <p class="mt-3 text-sm sm:text-base text-blue-50 max-w-xl">Pantau potensi desa, progres verifikasi, dan aktivitas terbaru dalam satu tampilan yang modern dan ringkas.</p>
            </div>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-1">
                <div class="rounded-2xl px-4 py-3" style="background-color:rgba(142,202,230,0.15);">
                    <p class="text-[11px] font-medium uppercase tracking-wide text-blue-100">Potensi terverifikasi</p>
                    <p class="mt-1 text-xl font-semibold text-white">{{ $verifiedPotentials }}</p>
                </div>
                <div class="rounded-2xl px-4 py-3" style="background-color:rgba(251,133,0,0.18);">
                    <p class="text-[11px] font-medium uppercase tracking-wide text-amber-100">Menunggu verifikasi</p>
                    <p class="mt-1 text-xl font-semibold text-white">{{ $pendingPotentials }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-md ring-1" style="border-color:#8ecae6;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Total potensi</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalPotentials }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl" style="background-color:#8ecae6; color:#023047;">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 7C4 5.89543 4.89543 5 6 5H18C19.1046 5 20 5.89543 20 7V17C20 18.1046 19.1046 19 18 19H6C4.89543 19 4 18.1046 4 17V7Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M9 9H9.01M9 13H9.01M13 9H15.5C16.3284 9 17 9.67157 17 10.5C17 11.3284 16.3284 12 15.5 12H13V15H16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
            <p class="mt-3 text-xs text-gray-500">Jumlah seluruh potensi yang tercatat di SIDARA.</p>
        </div>

        <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-md ring-1" style="border-color:#8ecae6;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Potensi terverifikasi</p>
                    <p class="mt-2 text-3xl font-semibold" style="color:#219ebc;">{{ $verifiedPotentials }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl" style="background-color:#8ecae6; color:#023047;">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 7L10 17L5 12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/></svg>
                </div>
            </div>
            <p class="mt-3 text-xs text-gray-500">Sudah siap ditampilkan di halaman publik desa.</p>
        </div>

        <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-md ring-1" style="border-color:#8ecae6;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Menunggu verifikasi</p>
                    <p class="mt-2 text-3xl font-semibold" style="color:#fb8500;">{{ $pendingPotentials }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl" style="background-color:rgba(255,183,3,0.15); color:#fb8500;">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 8V12L15 15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/></svg>
                </div>
            </div>
            <p class="mt-3 text-xs text-gray-500">Perlu dicek dan disetujui oleh admin sebelum tayang.</p>
        </div>

        <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-md ring-1" style="border-color:#8ecae6;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Jumlah desa</p>
                    <p class="mt-2 text-3xl font-semibold" style="color:#219ebc;">{{ $totalVillages }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl" style="background-color:#8ecae6; color:#023047;">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 10L12 4L20 10V19C20 19.5523 19.5523 20 19 20H5C4.44772 20 4 19.5523 4 19V10Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M10 20V13H14V20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
            <p class="mt-3 text-xs text-gray-500">Desa yang sudah terhubung dengan data potensi SIDARA.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2 rounded-2xl bg-white shadow-md ring-1 ring-gray-100">
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <div>
                    <h2 class="text-sm font-semibold text-gray-900">Potensi terbaru</h2>
                    <p class="mt-1 text-xs text-gray-500">Entri terbaru yang dibuat oleh admin desa.</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Nama potensi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Desa</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 bg-white">
                        @forelse($latestPotentials as $potential)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-900">{{ $potential->title }}</span>
                                        <span class="text-xs text-gray-500">{{ Str::limit($potential->description, 80) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-gray-700">
                                    {{ $potential->village->village_name ?? 'Tidak diketahui' }}
                                </td>
                                <td class="px-6 py-3">
                                    @php
                                        $status = $potential->verification_status;
                                        $statusColor = 'bg-gray-50 text-gray-700 ring-gray-600/20';

                                        if ($status === 'verified') {
                                            $statusColor = 'bg-emerald-50 text-emerald-700 ring-emerald-600/20';
                                        } elseif ($status === 'pending') {
                                            $statusColor = 'bg-amber-50 text-amber-700 ring-amber-600/20';
                                        } elseif ($status === 'rejected') {
                                            $statusColor = 'bg-rose-50 text-rose-700 ring-rose-600/20';
                                        }

                                        $statusLabel = ucfirst($status ?? 'Unknown');
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 {{ $statusColor }}">{{ $statusLabel }}</span>
                                </td>
                                <td class="px-6 py-3 text-right text-gray-500">
                                    {{ $potential->created_at ? $potential->created_at->format('d M Y') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-center text-sm text-gray-500">
                                    Belum ada potensi yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl bg-white p-6 shadow-md ring-1 ring-gray-100">
                <h2 class="text-sm font-semibold text-gray-900">Sebaran potensi per desa</h2>
                <p class="mt-1 text-xs text-gray-500">Desa dengan jumlah potensi terbanyak.</p>
                <div class="mt-4 space-y-3">
                    @forelse($potentialsByDistrict as $village)
                        <div class="flex items-center justify-between rounded-xl bg-gray-50 px-3 py-2">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $village->village_name }}</p>
                                <p class="text-xs text-gray-500">Total potensi: {{ $village->potentials_count }}</p>
                            </div>
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold" style="background-color:rgba(142,202,230,0.35); color:#023047;">
                                {{ $village->potentials_count }}
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-gray-500">Belum ada data potensi per desa.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl bg-slate-900 p-6 text-slate-50 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Tips kurasi</p>
                        <p class="mt-2 text-sm font-medium">Fokus pada potensi yang belum diverifikasi</p>
                    </div>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-slate-800 text-amber-300">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 17V11M12 7H12.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 21C16.4183 21 20 17.4183 20 13C20 8.58172 16.4183 5 12 5C7.58172 5 4 8.58172 4 13C4 17.4183 7.58172 21 12 21Z" stroke="currentColor" stroke-width="1.8"/></svg>
                    </span>
                </div>
                <p class="mt-3 text-xs text-slate-300">Gunakan kartu di atas untuk melihat desa dengan banyak potensi dan prioritas verifikasi. Dashboard ini dirancang agar Anda bisa langsung melihat mana yang perlu dikerjakan terlebih dahulu.</p>
            </div>
        </div>
    </div>
</div>
@endsection
