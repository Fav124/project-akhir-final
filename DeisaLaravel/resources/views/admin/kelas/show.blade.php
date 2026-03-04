@extends('layouts.admin')

@section('title', 'Detail Kelas')

@section('header')
    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
        <div class="space-y-2">
            <a href="{{ route('admin.kelas.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-deisa-blue">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Manajemen Kelas
            </a>
            <h2 class="text-xl font-bold text-slate-900">Detail Kelas {{ $kelas->nama_kelas ?: '-' }}</h2>
            <p class="text-sm text-slate-500">Ringkasan identitas kelas, komposisi santri, dan status kesehatan.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.kelas.edit', $kelas->id) }}"
               class="inline-flex items-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Edit Kelas
            </a>
        </div>
    </div>
@endsection

@section('admin-content')
    @php
        $statusStyles = [
            'Sehat' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'Sakit' => 'bg-rose-50 text-rose-700 border-rose-200',
            'Pulang' => 'bg-blue-50 text-blue-700 border-blue-200',
            'Pemulihan' => 'bg-amber-50 text-amber-700 border-amber-200',
            'Rawat Inap' => 'bg-orange-50 text-orange-700 border-orange-200',
        ];
    @endphp

    <div class="mx-auto max-w-6xl space-y-6">
        <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/40 rounded-3xl">
            <div class="p-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-blue-700">Kode Kelas</p>
                        <p class="mt-2 text-2xl font-black text-slate-900">{{ $kelas->kode_kelas ?: '-' }}</p>
                    </div>
                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Total Santri</p>
                        <p class="mt-2 text-2xl font-black text-slate-900">{{ $kelas->santri->count() }}</p>
                    </div>
                    <div class="rounded-2xl border border-rose-100 bg-rose-50 p-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-rose-700">Riwayat Sakit</p>
                        <p class="mt-2 text-2xl font-black text-slate-900">{{ $riwayatSakit }}</p>
                    </div>
                    <div class="rounded-2xl border border-violet-100 bg-violet-50 p-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-violet-700">Tahun Ajaran</p>
                        <p class="mt-2 text-2xl font-black text-slate-900">{{ $kelas->tahun_ajaran ?: '-' }}</p>
                    </div>
                </div>
            </div>
        </x-card>

        <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/30 rounded-3xl">
            <div class="p-6 space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-deisa-blue">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Identitas Kelas</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 text-sm">
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Nama Kelas</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $kelas->nama_kelas ?: '-' }}</p>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Jenjang</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $kelas->jenjang ?: '-' }}</p>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Tingkat</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $kelas->tingkat ?: '-' }}</p>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Jurusan Terkait</p>
                            <div class="mt-2 flex flex-wrap gap-1.5">
                                @forelse($kelas->jurusans as $jurusan)
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold bg-white text-slate-700 border border-slate-200">
                                        {{ $jurusan->nama_jurusan }}
                                    </span>
                                @empty
                                    <span class="text-slate-400">-</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center text-rose-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Distribusi Status Kesehatan</h3>
                        </div>
                        <div class="space-y-3">
                            @forelse($statusKesehatan as $status => $jumlah)
                                @php
                                    $statusClass = $statusStyles[$status] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                                @endphp
                                <div class="flex items-center justify-between rounded-xl border p-3 {{ $statusClass }}">
                                    <span class="font-medium">{{ $status }}</span>
                                    <span class="font-bold text-slate-900">{{ $jumlah }} santri</span>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 italic">Belum ada data status kesehatan.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-cyan-50 flex items-center justify-center text-cyan-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h6m-6 4h10M5 6h.01M5 10h.01M5 14h.01M5 18h.01"></path>
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Komposisi Jurusan Santri</h3>
                        </div>
                        <div class="space-y-3">
                            @forelse($komposisiJurusan as $namaJurusan => $jumlah)
                                <div class="flex items-center justify-between rounded-xl border border-cyan-100 bg-cyan-50 p-3">
                                    <span class="font-medium text-cyan-900">{{ $namaJurusan }}</span>
                                    <span class="font-bold text-slate-900">{{ $jumlah }} santri</span>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 italic">Belum ada data jurusan.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </x-card>

        <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/30 rounded-3xl">
            <div class="p-6 space-y-4">
                <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10 0v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6m10 0H7"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Daftar Santri di Kelas Ini</h3>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-100">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">NIS</th>
                                <th class="px-4 py-3 text-left font-semibold">Nama</th>
                                <th class="px-4 py-3 text-left font-semibold">Jurusan</th>
                                <th class="px-4 py-3 text-left font-semibold">Status Kesehatan</th>
                                <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($kelas->santri as $santri)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 font-mono text-slate-600">{{ $santri->nis }}</td>
                                    <td class="px-4 py-3 font-semibold text-slate-900">{{ $santri->nama_lengkap }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ optional($santri->jurusan)->nama_jurusan ?: '-' }}</td>
                                    <td class="px-4 py-3">
                                        @php
                                            $badgeClass = $statusStyles[$santri->status_kesehatan] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                                        @endphp
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold border {{ $badgeClass }}">
                                            {{ $santri->status_kesehatan ?: '-' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('admin.santri.show', $santri->id) }}" class="text-deisa-blue font-semibold hover:underline">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-slate-400 italic">Belum ada santri pada kelas ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </x-card>
    </div>
@endsection
