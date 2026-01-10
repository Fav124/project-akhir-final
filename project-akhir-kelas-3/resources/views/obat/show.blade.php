@extends('layouts.master')

@section('title', 'Detail Obat - Deisa')

@section('content')
<nav aria-label="Breadcrumb" class="flex mb-4">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a class="inline-flex items-center text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined text-lg mr-2">home</span>
                Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <span class="material-symbols-outlined text-text-muted text-lg">chevron_right</span>
                <a href="{{ route('obat.index') }}" class="ml-1 text-sm font-medium text-text-muted hover:text-primary md:ml-2 dark:text-gray-400 dark:hover:text-white">Data Obat</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <span class="material-symbols-outlined text-text-muted text-lg">chevron_right</span>
                <span class="ml-1 text-sm font-medium text-text-main md:ml-2 dark:text-white">Detail Obat</span>
            </div>
        </li>
    </ol>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column: Obat Info -->
    <div class="lg:col-span-1">
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden p-6 text-center">
            <div class="w-32 h-32 mx-auto rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 text-4xl font-bold overflow-hidden mb-4 border-4 border-white dark:border-gray-800 shadow-lg dark:bg-purple-900/20 dark:text-purple-400">
                @if($obat->foto)
                    <img src="{{ Storage::url($obat->foto) }}" alt="{{ $obat->nama_obat }}" class="w-full h-full object-cover">
                @else
                    <span class="material-symbols-outlined text-6xl">medication</span>
                @endif
            </div>
            <h2 class="text-2xl font-bold text-text-main dark:text-white">{{ $obat->nama_obat }}</h2>
            <p class="text-text-muted mb-4">{{ $obat->satuan }}</p>
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium {{ $obat->stok <= $obat->stok_minimum ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                <span class="w-2 h-2 rounded-full {{ $obat->stok <= $obat->stok_minimum ? 'bg-red-500' : 'bg-green-500' }}"></span>
                {{ $obat->stok <= $obat->stok_minimum ? 'Stok Menipis' : 'Stok Aman' }}
            </div>

            <div class="mt-8 flex flex-col gap-3">
                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800/50 text-left">
                    <p class="text-xs text-text-muted uppercase font-bold mb-1">Total Stok</p>
                    <p class="text-3xl font-bold text-text-main dark:text-white">{{ $obat->stok }} <span class="text-sm font-medium text-text-muted">{{ $obat->satuan }}</span></p>
                </div>
                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800/50 text-left">
                    <p class="text-xs text-text-muted uppercase font-bold mb-1">Total Terpakai</p>
                    <p class="text-2xl font-bold text-primary">{{ $obat->total_terpakai }} <span class="text-sm font-medium text-text-muted">{{ $obat->satuan }}</span></p>
                </div>
                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800/50 text-left">
                    <p class="text-xs text-text-muted uppercase font-bold mb-1">Harga Satuan</p>
                    <p class="text-text-main dark:text-white font-medium">Rp {{ number_format($obat->harga_satuan ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800/50 text-left">
                    <p class="text-xs text-text-muted uppercase font-bold mb-1">Tanggal Kadaluarsa</p>
                    <p class="text-text-main dark:text-white font-medium {{ ($obat->tanggal_kadaluarsa && \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->isPast()) ? 'text-red-500 font-bold' : '' }}">
                        {{ $obat->tanggal_kadaluarsa ? \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->translatedFormat('d F Y') : '-' }}
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('obat.edit', $obat->id) }}" class="flex w-full justify-center items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-medium transition-colors">
                    <span class="material-symbols-outlined text-lg">edit</span>
                    Edit Obat
                </a>
            </div>
        </div>
    </div>

    <!-- Right Column: Description & Usage History -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Description -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden p-6">
            <h3 class="text-lg font-bold text-text-main dark:text-white mb-4 border-b border-gray-100 dark:border-gray-800 pb-2">Deskripsi</h3>
            <div class="prose dark:prose-invert max-w-none text-text-main dark:text-gray-300">
                <p>{{ $obat->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
            </div>
        </div>

        <!-- Usage History table -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden p-6">
            <h3 class="text-lg font-bold text-text-main dark:text-white mb-4 border-b border-gray-100 dark:border-gray-800 pb-2">Riwayat Penggunaan (Terbaru)</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-text-muted uppercase bg-gray-50 dark:bg-gray-800/50">
                        <tr>
                            <th class="px-4 py-3 rounded-l-lg">Tanggal</th>
                            <th class="px-4 py-3">Pasien (Santri)</th>
                            <th class="px-4 py-3 text-center rounded-r-lg">Jumlah Keluar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($riwayatPenggunaan as $history)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="px-4 py-3 font-medium text-text-main dark:text-white">
                                {{ \Carbon\Carbon::parse($history->created_at)->translatedFormat('d M Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-text-main dark:text-gray-300">
                                {{ $history->nama_lengkap }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="bg-red-50 text-red-700 text-xs font-bold px-2 py-1 rounded border border-red-100 dark:bg-red-900/30 dark:text-red-300 dark:border-red-800">
                                    -{{ $history->jumlah }} {{ $obat->satuan }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-text-muted">Belum ada riwayat penggunaan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
