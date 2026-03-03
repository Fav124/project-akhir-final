@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('header')
    <h2 class="text-xl font-bold text-slate-900">Dashboard</h2>
    <p class="text-sm text-slate-500 hidden sm:block">Ringkasan statistik kesehatan santri Dar El-Ilmi.</p>
@endsection

@section('admin-content')
    <div class="space-y-6" data-realtime-stats="/admin/dashboard/stats">
        <!-- Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <x-stats-card title="Santri Status Sakit" value="{{ $sakitSantriCount ?? 0 }}" trend="" trendType="neutral"
                id="stats-sick-santri" data-stat="sakitSantriCount"
                class="bg-rose-50 border-rose-200/80"
                icon='<svg class="w-6 h-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19.428 15.341A8 8 0 018.659 4.572m10.769 10.769A8 8 0 114.572 8.659m14.856 6.682L4.572 8.659"/></svg>' />

            <x-stats-card title="Jumlah Obat" value="{{ $obatCount ?? 0 }}" trend="" trendType="neutral"
                id="stats-obat-count" data-stat="obatCount"
                class="bg-emerald-50 border-emerald-200/80"
                icon='<svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M10.5 21a6.5 6.5 0 009.19-9.19l-6-6a6.5 6.5 0 00-9.19 9.19l6 6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M7.5 16.5l9-9"/></svg>' />

            <x-stats-card title="Total Santri" value="{{ $totalSantriCount ?? 0 }}" trend="" trendType="neutral"
                id="stats-total-santri" data-stat="totalSantriCount"
                class="bg-blue-50 border-blue-200/80"
                icon='<svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>' />

            <x-stats-card title="Total User" value="{{ $totalUserCount ?? 0 }}" trend="" trendType="neutral"
                id="stats-total-user" data-stat="totalUserCount"
                class="bg-violet-50 border-violet-200/80"
                icon='<svg class="w-6 h-6 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5.121 17.804A11.953 11.953 0 0112 15.75c2.56 0 4.93.804 6.879 2.054M15 11a3 3 0 11-6 0 3 3 0 016 0m6 1a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' />
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
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentPatients as $patient)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $patient->santri->nama_lengkap ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $patient->status === 'Sakit' ? 'bg-red-100 text-red-700' :
                                      ($patient->status === 'Pulang' ? 'bg-orange-100 text-orange-700' :
                                      ($patient->status === 'Sembuh' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-700')) }}">
                                    {{ $patient->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $patient->created_at->format('d M H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-slate-400">Belum ada data pasien.</td>
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
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                plugins: { 
                    legend: { display: false } 
                }, 
                scales: { 
                    y: { 
                        beginAtZero: true, 
                        grid: { 
                            display: true,
                            color: 'rgba(0, 0, 0, 0.03)',
                            drawBorder: false
                        },
                        ticks: {
                            precision: 0,
                            stepSize: 1,
                            font: {
                                size: 10,
                                weight: 'bold'
                            },
                            color: '#94a3b8'
                        }
                    }, 
                    x: { 
                        grid: { 
                            display: true,
                            color: 'rgba(0, 0, 0, 0.03)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 10,
                                weight: 'bold'
                            },
                            color: '#94a3b8'
                        }
                    } 
                } 
            }
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
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                plugins: { 
                    legend: { display: false } 
                }, 
                scales: { 
                    y: { 
                        beginAtZero: true, 
                        grid: { 
                            display: true,
                            color: 'rgba(0, 0, 0, 0.03)',
                            drawBorder: false
                        },
                        ticks: {
                            precision: 0,
                            stepSize: 1,
                            font: {
                                size: 10,
                                weight: 'bold'
                            },
                            color: '#94a3b8'
                        }
                    }, 
                    x: { 
                        grid: { 
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10,
                                weight: 'bold'
                            },
                            color: '#94a3b8'
                        }
                    } 
                } 
            }
        });

    </script>
@endpush
