@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('header')
    <h2 class="text-xl font-bold text-slate-900">Dashboard</h2>
    <p class="text-sm text-slate-500 hidden sm:block">Ringkasan statistik kesehatan santri Dar El-Ilmi.</p>
@endsection

@section('admin-content')
    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-stats-card title="Total Pasien Hari Ini" value="{{ $totalPasienHariIni ?? 0 }}" trend="0%"
                trendType="neutral"
                icon='<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>' />

            <x-stats-card title="Menunggu Pemeriksaan" value="{{ $menungguPemeriksaan ?? 0 }}" trend="" trendType="neutral"
                icon='<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' />

            <x-stats-card title="Obat Keluar" value="{{ $obatKeluarHariIni ?? 0 }}" trend="" trendType="neutral"
                icon='<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>' />

            <x-stats-card title="Santri Sakit (Total)" value="{{ $totalSakit ?? 0 }}" trend="" trendType="neutral"
                icon='<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>' />
        </div>

        @if($criticalObatCount > 0 || $expiredObatCount > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($criticalObatCount > 0)
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-red-800">{{ $criticalObatCount }} Obat Stok Kritis</div>
                        <div class="text-xs text-red-600">Segera lakukan restock untuk menjamin pelayanan UKS.</div>
                    </div>
                </div>
                <a href="{{ route('admin.obat.index') }}" class="text-xs font-bold text-red-700 hover:underline px-3 py-1 bg-red-100 rounded-lg">Check →</a>
            </div>
            @endif

            @if($expiredObatCount > 0)
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-blue-800">{{ $expiredObatCount }} Obat Kadaluarsa</div>
                        <div class="text-xs text-blue-600">Obat yang kadaluarsa harus segera dipisahkan/dibuang.</div>
                    </div>
                </div>
                <a href="{{ route('admin.obat.index') }}" class="text-xs font-bold text-blue-700 hover:underline px-3 py-1 bg-blue-100 rounded-lg">Check →</a>
            </div>
            @endif
        </div>
        @endif

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-card>
                <x-slot name="header">Tren Kesehatan (7 Hari)</x-slot>
                <div class="h-64">
                    <canvas id="healthTrendChart"></canvas>
                </div>
            </x-card>

            <x-card>
                <x-slot name="header">Top 5 Diagnosis</x-slot>
                <div class="h-64">
                    <canvas id="diagnosisChart"></canvas>
                </div>
            </x-card>
        </div>

        <!-- Recent Table -->
        <x-card>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800">Pasien Terakhir</h3>
                <a href="#" class="text-sm font-medium text-deisa-blue hover:text-blue-700">Lihat Semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-900 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Nama Santri</th>
                            <th class="px-4 py-3 font-semibold">Kelas</th>
                            <th class="px-4 py-3 font-semibold">Keluhan</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentPatients as $sakit)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 font-medium text-slate-900">
                                    {{ $sakit->santri?->nama_lengkap ?? 'Unknown' }}</td>
                                <td class="px-4 py-3">{{ $sakit->santri?->kelas?->nama_kelas ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ Str::limit($sakit->keluhan, 30) }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusClasses = [
                                            'darurat' => 'bg-red-100 text-red-700',
                                            'rawat_jalan' => 'bg-blue-100 text-blue-700',
                                            'sakit' => 'bg-amber-100 text-amber-700',
                                            'selesai' => 'bg-emerald-100 text-emerald-700'
                                        ];
                                        $cls = $statusClasses[$sakit->status] ?? 'bg-slate-100 text-slate-700';
                                    @endphp
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-semibold {{ $cls }}">{{ ucfirst(str_replace('_', ' ', $sakit->status)) }}</span>
                                </td>
                                <td class="px-4 py-3 text-slate-500">{{ $sakit->created_at->format('H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-slate-500 italic">Belum ada pasien hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection

@push('scripts')
    <script>
        // Chart configurations (Dynamic Data)
        const trendCtx = document.getElementById('healthTrendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($dates ?? []) !!},
                datasets: [{
                    label: 'Sakit',
                    data: {!! json_encode($trendData ?? []) !!},
                    borderColor: '#0B63D6',
                    backgroundColor: 'rgba(11, 99, 214, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { display: false } }, x: { grid: { display: false } } } }
        });

        const diagCtx = document.getElementById('diagnosisChart').getContext('2d');
        new Chart(diagCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($diagLabels ?? []) !!},
                datasets: [{
                    label: 'Kasus',
                    data: {!! json_encode($diagData ?? []) !!},
                    backgroundColor: ['#0B63D6', '#2563EB', '#3B82F6', '#60A5FA', '#93C5FD'],
                    borderRadius: 6
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { display: false } }, x: { grid: { display: false } } } }
        });
    </script>
@endpush