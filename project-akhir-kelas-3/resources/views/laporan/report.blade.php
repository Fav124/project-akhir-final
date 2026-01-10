@extends('layouts.master')
@section('content')
<div class="space-y-6">
    <!-- PAGE HEADER -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-text-main dark:text-white">Laporan Kesehatan</h1>
            <p class="text-text-muted dark:text-gray-400 mt-1">Kelola dan unduh laporan kesehatan santri</p>
        </div>
        <a href="{{ route('laporan.report.pdf', request()->query()) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-green-600 text-white font-medium rounded-lg transition-colors w-fit">
            <span class="material-symbols-outlined text-lg">download</span>
            <span>Download PDF</span>
        </a>
    </div>

    <!-- FILTERS -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-800">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-text-main dark:text-gray-300 mb-2">Periode</label>
                    <select name="period" id="period" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="this_month" {{ (isset($period) && $period=='this_month')? 'selected':'' }}>Bulan Ini</option>
                        <option value="this_year" {{ (isset($period) && $period=='this_year')? 'selected':'' }}>Tahun Ini</option>
                        <option value="custom" {{ (isset($period) && $period=='custom')? 'selected':'' }}>Custom</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-text-main dark:text-gray-300 mb-2">Mulai</label>
                    <input type="date" name="start_date" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" value="{{ isset($start)? $start->toDateString():'' }}">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-text-main dark:text-gray-300 mb-2">Sampai</label>
                    <input type="date" name="end_date" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" value="{{ isset($end)? $end->toDateString():'' }}">
                </div>
                <div class="flex items-end">
                    <button class="w-full px-4 py-2 bg-primary hover:bg-green-600 text-white font-semibold rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-lg">check</span> Terapkan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Total Santri Sakit -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-800">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Total Santri Sakit</h3>
                <div class="h-10 w-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400">sick</span>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-4xl font-bold text-text-main dark:text-white">{{ $uniqueSantriCount ?? 0 }}</p>
                <p class="text-sm text-text-muted dark:text-gray-400">santri unik</p>
            </div>
            <p class="text-xs text-text-muted dark:text-gray-400 mt-3">Tercatat sakit pada rentang terpilih</p>
        </div>

        <!-- Card 2: Obat Terbanyak -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-800">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Obat Terbanyak</h3>
                <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">pill</span>
                </div>
            </div>
            @if(isset($topObats) && count($topObats) > 0)
                <p class="text-3xl font-bold text-text-main dark:text-white">{{ $topObats[0]->nama_obat }}</p>
                <p class="text-sm text-text-muted dark:text-gray-400 mt-2">Dipakai {{ $topObats[0]->total_jumlah }}x</p>
                @if(count($topObats) > 1)
                    <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700 space-y-1 text-xs">
                        @foreach($topObats->slice(1, 2) as $ob)
                            <p class="text-text-muted dark:text-gray-400">{{ $ob->nama_obat }} — {{ $ob->total_jumlah }}x</p>
                        @endforeach
                    </div>
                @endif
            @else
                <p class="text-lg font-bold text-text-main dark:text-white">-</p>
                <p class="text-sm text-text-muted dark:text-gray-400 mt-2">Tidak ada data obat</p>
            @endif
        </div>

        <!-- Card 3: Santri Sering Sakit -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-800">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Santri Sering Sakit</h3>
                <div class="h-10 w-10 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-amber-600 dark:text-amber-400">person</span>
                </div>
            </div>
            @if(isset($topSantri) && count($topSantri) > 0)
                <p class="text-3xl font-bold text-text-main dark:text-white">{{ $topSantri[0]['nama'] }}</p>
                <p class="text-sm text-text-muted dark:text-gray-400 mt-2">{{ $topSantri[0]['times_sick'] }}x sakit</p>
                @if(count($topSantri) > 1)
                    <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700 space-y-1 text-xs">
                        @foreach($topSantri->slice(1, 2) as $s)
                            <p class="text-text-muted dark:text-gray-400">{{ $s['nama'] }} — {{ $s['times_sick'] }}x</p>
                        @endforeach
                    </div>
                @endif
            @else
                <p class="text-lg font-bold text-text-main dark:text-white">-</p>
                <p class="text-sm text-text-muted dark:text-gray-400 mt-2">Tidak ada data santri</p>
            @endif
        </div>
    </div>

    <!-- DETAILED TABLES -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Santri Table -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-800">
            <div class="p-6 border-b border-gray-200 dark:border-gray-800">
                <h3 class="text-lg font-bold text-text-main dark:text-white">Santri Sering Sakit</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Nama</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Kelas</th>
                            <th class="px-6 py-3 text-right text-sm font-semibold text-text-main dark:text-gray-300">Frekuensi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @if(isset($topSantri) && count($topSantri))
                            @foreach($topSantri->slice(0, 5) as $s)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-medium text-text-main dark:text-gray-300">{{ $s['nama'] }}</td>
                                    <td class="px-6 py-4 text-sm text-text-muted dark:text-gray-400">{{ $s['kelas'] ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-center justify-center px-2 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-full text-xs font-bold">{{ $s['times_sick'] }}x</span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-text-muted dark:text-gray-400">
                                    Tidak ada data santri pada periode ini
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Obat Table -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-800">
            <div class="p-6 border-b border-gray-200 dark:border-gray-800">
                <h3 class="text-lg font-bold text-text-main dark:text-white">Obat Terbanyak Digunakan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Nama Obat</th>
                            <th class="px-6 py-3 text-right text-sm font-semibold text-text-main dark:text-gray-300">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @if(isset($topObats) && count($topObats))
                            @foreach($topObats->slice(0, 5) as $ob)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-medium text-text-main dark:text-gray-300">{{ $ob->nama_obat }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-center justify-center px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-xs font-bold">{{ $ob->total_jumlah }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2" class="px-6 py-8 text-center text-text-muted dark:text-gray-400">
                                    Tidak ada data obat pada periode ini
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
