@extends('layouts.admin')

@section('title', 'Laporan Kesehatan')

@section('header')
    <h2 class="text-xl font-bold text-slate-900">Laporan & Analitik</h2>
    <p class="text-sm text-slate-500 hidden sm:block">Visualisasi data kesehatan santri</p>
@endsection

@section('admin-content')
    <div class="space-y-6">
        <form action="{{ route('admin.laporan.index') }}" method="GET"
            class="flex flex-wrap items-end gap-4 bg-white p-4 rounded-xl shadow-sm border border-slate-100">
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Mulai Dari</label>
                <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}"
                    class="px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue bg-white text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Sampai Dengan</label>
                <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}"
                    class="px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue bg-white text-sm">
            </div>
            <div class="flex gap-2">
                <x-button type="submit" variant="outline">Filter</x-button>
                <a href="{{ route('admin.laporan.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                    class="inline-flex items-center px-4 py-2 bg-deisa-blue hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-all shadow-lg shadow-blue-500/30">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Export PDF
                </a>
            </div>
        </form>

        @if($totalKunjungan == 0)
            <div class="p-12 text-center bg-white rounded-xl shadow-sm border border-slate-100">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 text-slate-300 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Tidak Ada Data</h3>
                <p class="text-slate-500">Gunakan rentang waktu lain atau periksa data pemeriksaan.</p>
            </div>
        @else
            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-stats-card title="Total Kunjungan" value="{{ $totalKunjungan }}"
                    icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>' />
                <x-stats-card title="Rata-rata Sakit (Hari)" value="{{ $avgSakit }}"
                    icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>' />
                <x-stats-card title="Obat Terpakai (Item)" value="{{ $totalObat }}"
                    icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>' />
            </div>

            <!-- Main Trend Chart -->
            <x-card>
                <x-slot name="header">
                    <h4>Tren Kasus</h4>
                </x-slot>
                <div class="h-64">
                    <canvas id="trendChart"></canvas>
                </div>
            </x-card>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Distribution by Class -->
                <x-card>
                    <x-slot name="header">
                        <h4>Distribusi Kasus per Kelas</h4>
                    </x-slot>
                    <div class="h-64 flex justify-center">
                        @if(count($classData) > 0)
                            <canvas id="classChart"></canvas>
                        @else
                            <div class="flex items-center text-slate-400 italic">Data kelas tidak tersedia</div>
                        @endif
                    </div>
                </x-card>

                <!-- Top Medicine -->
                <x-card>
                    <x-slot name="header">
                        <h4>Penggunaan Obat Terbanyak</h4>
                    </x-slot>
                    <div class="h-64">
                        @if(count($medicineData) > 0)
                            <canvas id="medicineChart"></canvas>
                        @else
                            <div class="flex items-center justify-center h-full text-slate-400 italic">Data obat tidak tersedia
                            </div>
                        @endif
                    </div>
                </x-card>
            </div>

            <!-- Top Santri Table -->
            <x-card>
                <x-slot name="header">
                    <h4>Top 5 Santri dengan Riwayat Sakit Terbanyak</h4>
                </x-slot>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-900 border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Nama Santri</th>
                                <th class="px-4 py-3 font-semibold">Kelas</th>
                                <th class="px-4 py-3 text-center font-semibold">Total Kejadian</th>
                                <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($topSantris as $item)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3 font-medium text-slate-900">{{ $item->santri->nama_lengkap ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $item->santri->kelas->nama_kelas ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-center font-bold text-deisa-blue">{{ $item->total }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <x-button variant="outline" class="text-xs px-2 py-1"
                                            data-detail-url="{{ route('admin.santri.show', $item->santri_id) }}">Profil</x-button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-slate-400 italic">Data tidak tersedia</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        @endif
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Trend Line
            const trendEl = document.getElementById('trendChart');
            if (trendEl) {
                new Chart(trendEl, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($days ?? []) !!},
                        datasets: [{
                            label: 'Kasus',
                            data: {!! json_encode($trendData ?? []) !!},
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    display: false
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // 2. Class Pie
            const classEl = document.getElementById('classChart');
            if (classEl) {
                new Chart(classEl, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($classLabels ?? []) !!},
                        datasets: [{
                            data: {!! json_encode($classData ?? []) !!},
                            backgroundColor: ['#10B981', '#34D399', '#6EE7B7', '#A7F3D0', '#D1FAE5', '#0B63D6', '#3B82F6']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }

            // 3. Medicine Bar
            const medEl = document.getElementById('medicineChart');
            if (medEl) {
                new Chart(medEl, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($medicineLabels ?? []) !!},
                        datasets: [{
                            label: 'Unit',
                            data: {!! json_encode($medicineData ?? []) !!},
                            backgroundColor: '#0B63D6',
                            borderRadius: 4
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                grid: {
                                    display: false
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush