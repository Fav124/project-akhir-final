@extends('layouts.admin-template')

@section('title', 'Inventaris Obat')

@section('content')
<div class="flex flex-col gap-6">
    <!-- Top Header & Actions -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <h1 class="text-text-main dark:text-white text-3xl font-black leading-tight tracking-[-0.033em]">Inventaris Obat</h1>
            <p class="text-text-muted text-sm font-normal">Kelola stok obat dan pemantauan kadaluarsa klinik santri.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('web.obat.create') }}" class="flex items-center gap-2 h-10 px-4 rounded-lg bg-primary text-white text-sm font-bold shadow-md shadow-blue-200 hover:bg-primary-dark transition-colors">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span>Tambah Obat</span>
            </a>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total -->
        <div class="flex flex-col gap-1 p-5 rounded-xl border border-border-light dark:border-border-dark bg-white dark:bg-surface-dark shadow-soft hover:shadow-card transition-shadow">
            <div class="flex justify-between items-center">
                <p class="text-text-muted text-sm font-medium">Total Jenis Obat</p>
                <span class="material-symbols-outlined text-primary bg-primary/10 p-1.5 rounded-lg text-xl">medication</span>
            </div>
            <p class="text-text-main dark:text-white text-3xl font-bold mt-2">{{ \App\Models\Obat::count() }}</p>
            <p class="text-xs text-text-muted">Semua kategori</p>
        </div>
        <!-- Stok Menipis (Red) -->
        <div class="flex flex-col gap-1 p-5 rounded-xl border border-danger/30 bg-white dark:bg-surface-dark shadow-soft hover:shadow-card transition-shadow relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-danger/5 rounded-bl-full -mr-8 -mt-8"></div>
            <div class="flex justify-between items-center relative z-10">
                <p class="text-danger text-sm font-bold">Stok Menipis</p>
                <span class="material-symbols-outlined text-danger bg-danger/10 p-1.5 rounded-lg text-xl">production_quantity_limits</span>
            </div>
            <p class="text-danger text-3xl font-bold mt-2 relative z-10">{{ \App\Models\Obat::whereColumn('stok', '<=', 'stok_minimum')->count() }}</p>
            <p class="text-xs text-danger/80 font-medium">Perlu restock segera</p>
        </div>
        <!-- Segera Kadaluarsa (Yellow) - Placeholder logic as expiry might not be in DB yet or needs complex query -->
        <div class="flex flex-col gap-1 p-5 rounded-xl border border-warning/40 bg-white dark:bg-surface-dark shadow-soft hover:shadow-card transition-shadow">
            <div class="flex justify-between items-center">
                <p class="text-warning text-sm font-bold">Segera Kadaluarsa</p>
                <span class="material-symbols-outlined text-warning bg-warning/10 p-1.5 rounded-lg text-xl">history_toggle_off</span>
            </div>
            <p class="text-warning text-3xl font-bold mt-2">0</p>
            <p class="text-xs text-warning/80 font-medium">Dalam < 3 bulan</p>
        </div>
        <!-- Obat Habis (Dark Grey) -->
        <div class="flex flex-col gap-1 p-5 rounded-xl border border-gray-600/30 bg-gray-600/5 shadow-soft hover:shadow-card transition-shadow">
            <div class="flex justify-between items-center">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-bold">Obat Habis</p>
                <span class="material-symbols-outlined text-gray-600 dark:text-gray-400 bg-white dark:bg-surface-dark p-1.5 rounded-lg text-xl border border-gray-600/10">block</span>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-3xl font-bold mt-2">{{ \App\Models\Obat::where('stok', 0)->count() }}</p>
            <p class="text-xs text-gray-600 dark:text-gray-400 font-medium">Tidak tersedia</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="flex flex-col sm:flex-row gap-4 justify-between items-center pt-2">
         <div class="flex p-1 bg-background-light dark:bg-gray-800 rounded-lg self-start sm:self-auto">
            <button class="px-4 py-1.5 rounded-md bg-white dark:bg-surface-dark shadow-sm text-text-main dark:text-white text-sm font-semibold transition-all">Semua</button>
            <button class="px-4 py-1.5 rounded-md text-text-muted hover:text-text-main dark:hover:text-white text-sm font-medium transition-all">Stok Rendah</button>
        </div>
        <div class="w-full sm:max-w-xs relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-text-muted text-[20px]">search</span>
            </div>
            <input class="block w-full pl-10 pr-3 py-2 border-none ring-1 ring-border-light dark:ring-gray-700 rounded-lg leading-5 bg-white dark:bg-surface-dark placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary sm:text-sm shadow-sm transition-shadow text-text-main dark:text-white" placeholder="Cari obat..." type="text"/>
        </div>
    </div>

    <!-- Main Table -->
    <div class="bg-white dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 border-b border-border-light dark:border-border-dark">
                        <th class="px-6 py-4 text-xs font-bold text-text-muted uppercase tracking-wider">Info Obat</th>
                        <th class="px-6 py-4 text-xs font-bold text-text-muted uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-text-muted uppercase tracking-wider w-1/4">Level Stok</th>
                        <th class="px-6 py-4 text-xs font-bold text-text-muted uppercase tracking-wider">Kadaluarsa</th>
                        <th class="px-6 py-4 text-xs font-bold text-text-muted uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-light dark:divide-border-dark">
                    @forelse(\App\Models\Obat::paginate(10) as $obat)
                    @php
                        $stok_percent = ($obat->stok / 100) * 100; // Assuming 100 is max, needs logic
                        $is_low = $obat->stok <= $obat->stok_minimum;
                        $is_empty = $obat->stok == 0;
                    @endphp
                    <tr class="hover:bg-primary/5 dark:hover:bg-primary/5 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="size-10 rounded-lg bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-text-muted">medication</span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-text-main dark:text-white">{{ $obat->nama_obat }}</p>
                                    <p class="text-xs text-text-muted font-mono">{{ $obat->kode_obat ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800">
                                {{ $obat->jenis_obat }}
                            </span>
                        </td>
                        <td class="px-6 py-4 align-middle">
                            <div class="flex flex-col gap-1.5">
                                <div class="flex justify-between text-xs">
                                    <span class="font-medium text-text-main dark:text-white">{{ $obat->stok }} / 100</span> <!-- Mock max -->
                                    @if($is_empty)
                                        <span class="text-gray-500 font-bold">Habis</span>
                                    @elseif($is_low)
                                        <span class="text-danger font-bold">Kritis</span>
                                    @else
                                        <span class="text-success font-bold">Aman</span>
                                    @endif
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                                    <div class="h-2 rounded-full {{ $is_empty ? 'bg-gray-500' : ($is_low ? 'bg-danger' : 'bg-success') }}" style="width: {{ $stok_percent }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-text-main dark:text-white">-</span> 
                                <!-- Expiry data placeholder -->
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('web.obat.edit', $obat->id) }}" class="p-1.5 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <button class="p-1.5 text-text-muted hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors" title="Log Restock">
                                    <span class="material-symbols-outlined text-[20px]">history</span>
                                </button>
                                <button class="p-1.5 text-danger hover:bg-danger/10 rounded-lg transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-text-muted">Tidak ada data obat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="bg-white dark:bg-surface-dark px-4 py-3 border-t border-border-light dark:border-border-dark sm:px-6">
            {{ \App\Models\Obat::paginate(10)->links() }}
        </div>
    </div>
</div>
@endsection
