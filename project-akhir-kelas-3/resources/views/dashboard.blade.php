@extends('layouts.master')

@section('title', 'Dashboard - Deisa')

@section('content')
<div class="rounded-2xl bg-surface-dark relative overflow-hidden mb-8 shadow-md">
    <div class="absolute inset-0 z-0">
        <div class="w-full h-full bg-cover bg-center opacity-40 mix-blend-overlay" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAM1InwB68-F8Wj0tIHpv8UtU7PxEfjE6yUQawBU57mleT9e16Y0s52W9UTuNsch3H8X-mRzntrX9W3sSFKKP6F9Ie6epBu4vwLxEI4xfFcHg13uLAQVVYSTA3AcOYbHxMk9t48W_-8Gh1_BoqtMUONp9TNvG4q-U20KlWLabqlOxmRs5e2R72CE4RTQN1NKpzYX6k_pzL5JUXtpakcw-RU1b2WghvUd-HGlfMKo5dK1HPYmohDGWNjECLy8uPnKjAsMEMcAtlAMdWe");'></div>
        <div class="absolute inset-0 bg-gradient-to-r from-surface-dark via-surface-dark/90 to-transparent"></div>
    </div>
    <div class="relative z-10 p-8 sm:p-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div>
            <h2 class="text-3xl font-bold text-white mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="text-gray-300 max-w-xl">Ini adalah ringkasan harian kesehatan santri di Pondok Pesantren Deisa. Pantau santri sakit dan inventaris obat dengan efektif.</p>
        </div>
        <a href="{{ route('sakit.create') }}" class="bg-primary hover:bg-green-400 text-surface-dark font-bold py-3 px-6 rounded-lg shadow-lg shadow-primary/20 transition-all active:scale-95 flex items-center gap-2">
            <span class="material-symbols-outlined">add_circle</span>
            Input Sakit Baru
        </a>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                <span class="material-symbols-outlined">groups</span>
            </div>
            <span class="text-xs font-medium text-green-600 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">Aktif</span>
        </div>
        <div class="mt-auto">
            <p class="text-sm font-medium text-text-muted">Total Santri</p>
            <h3 class="text-3xl font-bold text-text-main dark:text-white">{{ $totalSantri }}</h3>
        </div>
    </div>
    <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-lg bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400">
                <span class="material-symbols-outlined">school</span>
            </div>
        </div>
        <div class="mt-auto">
            <p class="text-sm font-medium text-text-muted">Total Kelas</p>
            <h3 class="text-3xl font-bold text-text-main dark:text-white">{{ $totalKelas }}</h3>
        </div>
    </div>
    
    <!-- Obat Alert Card -->
    <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-lg bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400">
                <span class="material-symbols-outlined">medication</span>
            </div>
            @if($obatStokRendah > 0)
            <span class="text-xs font-medium text-red-500 bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded-full">Low Stock: {{ $obatStokRendah }}</span>
            @endif
        </div>
        <div class="mt-auto">
            <p class="text-sm font-medium text-text-muted">Total Jenis Obat</p>
            <h3 class="text-3xl font-bold text-text-main dark:text-white">{{ $totalObat }}</h3>
            @if($obatKadaluarsa > 0)
            <p class="text-xs text-orange-500 mt-1">{{ $obatKadaluarsa }} obat mendekati expired</p>
            @endif
        </div>
    </div>

    <!-- Sakit Card -->
    <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col relative overflow-hidden">
        @if($santriSedangSakit > 0)
        <div class="absolute right-0 top-0 p-24 bg-red-500/5 rounded-full -mr-10 -mt-10 pointer-events-none"></div>
        @endif
        <div class="flex items-center justify-between mb-4 relative z-10">
            <div class="p-3 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-500">
                <span class="material-symbols-outlined">sick</span>
            </div>
        </div>
        <div class="mt-auto relative z-10">
            <p class="text-sm font-medium text-text-muted">Santri Sakit (Aktif)</p>
            <h3 class="text-3xl font-bold text-text-main dark:text-white">{{ $santriSedangSakit }}</h3>
            <p class="text-xs text-text-muted mt-1">+{{ $sakitHariIni }} baru hari ini</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Top 5 Santri Sakit List -->
    <!-- Health Statistics Chart (Chart.js) -->
    <div class="lg:col-span-2 bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-text-main dark:text-white">Statistik Kesehatan</h3>
                <p class="text-sm text-text-muted">Tren Santri Sakit (7 Hari Terakhir)</p>
            </div>
            <!-- Functional filter stub -->
            <select class="form-select text-sm rounded-lg border-gray-200 dark:border-gray-700 bg-transparent text-text-main dark:text-white focus:border-primary focus:ring-primary">
                <option>Minggu Ini</option>
            </select>
        </div>
        
        <div class="relative h-64 w-full">
            <canvas id="healthChart"></canvas>
        </div>
        
        <!-- Top 5 Santri Table -->
        <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800">
             <h4 class="text-md font-bold text-text-main dark:text-white mb-4">Top 5 Santri Sering Sakit</h4>
             <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-text-muted uppercase bg-gray-50 dark:bg-gray-800/50">
                        <tr>
                            <th class="px-4 py-3 rounded-l-lg">Santri</th>
                            <th class="px-4 py-3">Kelas</th>
                            <th class="px-4 py-3 rounded-r-lg text-center">Jumlah Sakit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topSantriSakit as $item)
                        <tr class="border-b border-gray-100 dark:border-gray-800 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="px-4 py-3 font-medium text-text-main dark:text-white flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-bold">
                                    {{ substr($item->nama_lengkap, 0, 1) }}
                                </div>
                                {{ $item->nama_lengkap }}
                            </td>
                            <td class="px-4 py-3 text-text-muted">{{ $item->nama_kelas ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    {{ $item->sakit_count }}x
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-text-muted">Belum ada data bulan ini</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Medicine Alerts Section (Right Column) -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Quick Actions -->
        <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
            <h3 class="text-lg font-bold text-text-main dark:text-white mb-6">Aksi Cepat</h3>
            <div class="flex flex-col gap-3">
                <a href="{{ route('santri.create') }}" class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 hover:border-primary hover:bg-primary/5 transition-all group text-left">
                    <div class="p-2 rounded-lg bg-surface-light dark:bg-surface-dark shadow-sm text-primary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">add_circle</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-text-main dark:text-white">Tambah Santri</h4>
                        <p class="text-xs text-text-muted">Register santri baru</p>
                    </div>
                </a>
                <a href="{{ route('sakit.create') }}" class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 hover:border-primary hover:bg-primary/5 transition-all group text-left">
                    <div class="p-2 rounded-lg bg-surface-light dark:bg-surface-dark shadow-sm text-red-500 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">medical_services</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-text-main dark:text-white">Input Sakit</h4>
                        <p class="text-xs text-text-muted">Catat keluhan kesehatan</p>
                    </div>
                </a>
                <a href="{{ route('obat.index') }}" class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 hover:border-primary hover:bg-primary/5 transition-all group text-left">
                    <div class="p-2 rounded-lg bg-surface-light dark:bg-surface-dark shadow-sm text-purple-500 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">inventory</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-text-main dark:text-white">Cek Stok Obat</h4>
                        <p class="text-xs text-text-muted">Update inventory</p>
                    </div>
                </a>
                <a href="{{ route('laporan.report') }}" class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 hover:border-primary hover:bg-primary/5 transition-all group text-left">
                    <div class="p-2 rounded-lg bg-surface-light dark:bg-surface-dark shadow-sm text-orange-500 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">print</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-text-main dark:text-white">Cetak Laporan</h4>
                        <p class="text-xs text-text-muted">Generate laporan bulanan</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Medicine Alerts -->
        @if($obatStokRendahList->count() > 0 || $obatMendekatiKadaluarsa->count() > 0)
        <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
            <h3 class="text-lg font-bold text-text-main dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-red-500">warning</span>
                Perhatian Obat
            </h3>
            
            @if($obatStokRendahList->count() > 0)
            <div class="mb-4">
                <h4 class="text-xs font-bold text-text-muted uppercase mb-2">Stok Menipis ({{ $obatStokRendah }})</h4>
                <div class="space-y-2">
                    @foreach($obatStokRendahList as $obat)
                    <div class="flex justify-between items-center p-2 bg-red-50 dark:bg-red-900/10 rounded-lg border border-red-100 dark:border-red-900/20">
                        <div>
                            <p class="text-sm font-medium text-text-main dark:text-white">{{ $obat->nama_obat }}</p>
                            <p class="text-xs text-red-500">Sisa: {{ $obat->stok }} {{ $obat->satuan }}</p>
                        </div>
                        <a href="{{ route('obat.show', $obat->id) }}" class="text-xs text-primary hover:underline">Cek</a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($obatMendekatiKadaluarsa->count() > 0)
            <div>
                <h4 class="text-xs font-bold text-text-muted uppercase mb-2">Mendekati Expired ({{ $obatKadaluarsa }})</h4>
                <div class="space-y-2">
                    @foreach($obatMendekatiKadaluarsa as $obat)
                    <div class="flex justify-between items-center p-2 bg-orange-50 dark:bg-orange-900/10 rounded-lg border border-orange-100 dark:border-orange-900/20">
                        <div>
                            <p class="text-sm font-medium text-text-main dark:text-white">{{ $obat->nama_obat }}</p>
                            <p class="text-xs text-orange-500">Exp: {{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d M Y') }}</p>
                        </div>
                        <a href="{{ route('obat.show', $obat->id) }}" class="text-xs text-primary hover:underline">Cek</a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('healthChart').getContext('2d');
        const healthChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Jumlah Santri Sakit',
                    data: @json($chartData),
                    borderColor: '#13ec80',
                    backgroundColor: 'rgba(19, 236, 128, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#13ec80',
                    pointHoverBackgroundColor: '#13ec80',
                    pointHoverBorderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            precision: 0
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    });
</script>
@endpush
