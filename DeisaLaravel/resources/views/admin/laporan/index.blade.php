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

        <x-card>
            <x-slot name="header">
                <h4>Preview File Laporan</h4>
            </x-slot>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2 border border-slate-200 rounded-xl p-4 bg-white">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="text-xs font-black text-slate-400 uppercase tracking-widest">Judul</div>
                            <div class="text-lg font-bold text-slate-900 mt-1">Laporan Kesehatan Santri</div>
                            <div class="text-sm text-slate-500 mt-1">
                                Periode {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-black text-slate-400 uppercase tracking-widest">Nama File</div>
                            <div class="text-sm font-semibold text-deisa-blue mt-1">
                                laporan-kesehatan-{{ now()->format('Y-m-d') }}.pdf
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3">
                        <div class="p-3 rounded-lg bg-blue-50 border border-blue-100">
                            <div class="text-[10px] font-black text-blue-500 uppercase">Total Kunjungan</div>
                            <div class="text-xl font-bold text-blue-700 mt-1">{{ $totalKunjungan }}</div>
                        </div>
                        <div class="p-3 rounded-lg bg-emerald-50 border border-emerald-100">
                            <div class="text-[10px] font-black text-emerald-500 uppercase">Obat Terpakai</div>
                            <div class="text-xl font-bold text-emerald-700 mt-1">{{ $totalObat }}</div>
                        </div>
                        <div class="p-3 rounded-lg bg-violet-50 border border-violet-100">
                            <div class="text-[10px] font-black text-violet-500 uppercase">Rata-rata Hari</div>
                            <div class="text-xl font-bold text-violet-700 mt-1">{{ $avgSakit }}</div>
                        </div>
                        <div class="p-3 rounded-lg bg-amber-50 border border-amber-100">
                            <div class="text-[10px] font-black text-amber-500 uppercase">Top Santri</div>
                            <div class="text-xl font-bold text-amber-700 mt-1">{{ $topSantris->count() }}</div>
                        </div>
                    </div>
                </div>

                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50">
                    <div class="text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Konten PDF</div>
                    <ul class="space-y-2 text-sm text-slate-700">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-deisa-blue"></span> Ringkasan KPI</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Tren Kasus Harian</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-violet-500"></span> Distribusi Kelas</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Penggunaan Obat</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-slate-500"></span> Top Santri</li>
                    </ul>
                </div>
            </div>
        </x-card>

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
            @php
                $trendPoints = collect($trendData ?? [])->filter(fn($v) => (int) $v > 0);
                $classItems = collect($classData ?? [])->filter(fn($v) => (int) $v > 0);
                $medicineItems = collect($medicineData ?? [])->filter(fn($v) => (int) $v > 0);
            @endphp

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
                <div class="h-72">
                    @forelse($trendPoints as $point)
                        <canvas id="trendChart"></canvas>
                        @break
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-slate-400">
                            <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center mb-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M9 17v-6m4 6V7m4 10v-3M4 4v16h16" />
                                </svg>
                            </div>
                            <p class="font-semibold text-slate-600">Grafik tren belum tersedia</p>
                            <p class="text-sm">Tidak ada kasus pada rentang tanggal ini.</p>
                        </div>
                    @endforelse
                </div>
            </x-card>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Distribution by Class -->
                <x-card>
                    <x-slot name="header">
                        <h4>Distribusi Kasus per Kelas</h4>
                    </x-slot>
                    <div class="h-64 flex justify-center">
                        @forelse($classItems as $item)
                            <canvas id="classChart"></canvas>
                            @break
                        @empty
                            <div class="h-full w-full flex flex-col items-center justify-center text-slate-400">
                                <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center mb-3">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M11 3.055A9.001 9.001 0 1021 12h-9V3.055z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M13 3.055A9.001 9.001 0 0121 11h-8V3.055z" />
                                    </svg>
                                </div>
                                <p class="font-semibold text-slate-600">Distribusi kelas kosong</p>
                                <p class="text-sm">Belum ada data kasus per kelas.</p>
                            </div>
                        @endforelse
                    </div>
                </x-card>

                <!-- Top Medicine -->
                <x-card>
                    <x-slot name="header">
                        <h4>Penggunaan Obat Terbanyak</h4>
                    </x-slot>
                    <div class="h-64">
                        @forelse($medicineItems as $item)
                            <canvas id="medicineChart"></canvas>
                            @break
                        @empty
                            <div class="h-full w-full flex flex-col items-center justify-center text-slate-400">
                                <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center mb-3">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M10.5 21a6.5 6.5 0 009.19-9.19l-6-6a6.5 6.5 0 00-9.19 9.19l6 6z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7.5 16.5l9-9" />
                                    </svg>
                                </div>
                                <p class="font-semibold text-slate-600">Data obat kosong</p>
                                <p class="text-sm">Belum ada penggunaan obat pada periode ini.</p>
                            </div>
                        @endforelse
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
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const trendCrosshairPlugin = {
                id: 'trendCrosshair',
                afterDatasetsDraw(chart, args, pluginOptions) {
                    const {
                        ctx,
                        chartArea: {
                            top,
                            bottom,
                            left,
                            right
                        }
                    } = chart;
                    const active = chart.tooltip?.getActiveElements?.() || [];
                    if (!active.length) return;

                    const {
                        x,
                        y
                    } = active[0].element;

                    ctx.save();
                    ctx.setLineDash([4, 4]);
                    ctx.lineWidth = 1;
                    ctx.strokeStyle = pluginOptions?.lineColor || 'rgba(71, 85, 105, 0.55)';

                    // Garis bantu vertikal
                    ctx.beginPath();
                    ctx.moveTo(x, top);
                    ctx.lineTo(x, bottom);
                    ctx.stroke();

                    // Garis bantu horizontal
                    ctx.beginPath();
                    ctx.moveTo(left, y);
                    ctx.lineTo(right, y);
                    ctx.stroke();
                    ctx.restore();
                }
            };

            // 1. Trend Line
            const trendEl = document.getElementById('trendChart');
            if (trendEl) {
                const trendValues = {!! json_encode($trendData ?? []) !!};
                const trendMax = Math.max(...trendValues, 0);

                new Chart(trendEl, {
                    type: 'line',
                    plugins: [trendCrosshairPlugin],
                    data: {
                        labels: {!! json_encode($days ?? []) !!},
                        datasets: [{
                            label: 'Kasus',
                            data: trendValues,
                            borderColor: '#0B63D6',
                            backgroundColor: 'rgba(11, 99, 214, 0.14)',
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#0B63D6',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            borderWidth: 3,
                            fill: true,
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                top: 8,
                                right: 12
                            }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                displayColors: false,
                                backgroundColor: 'rgba(15, 23, 42, 0.92)',
                                titleColor: '#e2e8f0',
                                bodyColor: '#ffffff',
                                padding: 10,
                                callbacks: {
                                    label: (context) => ` Kasus: ${context.raw}`
                                }
                            },
                            trendCrosshair: {
                                lineColor: 'rgba(71, 85, 105, 0.55)'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                suggestedMax: trendMax < 5 ? 5 : trendMax + 1,
                                border: {
                                    display: true,
                                    color: 'rgba(148, 163, 184, 0.6)'
                                },
                                ticks: {
                                    precision: 0,
                                    stepSize: 1,
                                    color: '#64748b',
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.28)',
                                    drawBorder: true
                                }
                            },
                            x: {
                                border: {
                                    display: true,
                                    color: 'rgba(148, 163, 184, 0.6)'
                                },
                                ticks: {
                                    color: '#64748b',
                                    font: {
                                        size: 11
                                    },
                                    maxRotation: 0,
                                    autoSkip: true,
                                    maxTicksLimit: 12
                                },
                                grid: {
                                    display: true,
                                    color: 'rgba(148, 163, 184, 0.18)',
                                    drawTicks: false
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
                            borderColor: '#ffffff',
                            borderWidth: 2,
                            backgroundColor: ['#0B63D6', '#10B981', '#F59E0B', '#EF4444', '#6366F1', '#14B8A6', '#F97316']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '60%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    padding: 14,
                                    color: '#475569',
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: (context) => ` ${context.label}: ${context.raw} kasus`
                                }
                            }
                        }
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
                            borderRadius: 6,
                            barThickness: 16
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: (context) => ` ${context.raw} unit`
                                }
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                ticks: {
                                    color: '#475569',
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            },
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    stepSize: 1,
                                    color: '#64748b',
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.2)'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
