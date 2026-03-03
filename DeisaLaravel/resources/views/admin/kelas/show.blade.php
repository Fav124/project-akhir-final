@extends('layouts.admin')

@section('title', 'Detail Kelas')

@section('header')
    <div class="flex flex-col gap-2">
        <a href="{{ route('admin.kelas.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-deisa-blue">
            <span aria-hidden="true">←</span> Kembali ke Manajemen Kelas
        </a>
        <h2 class="text-xl font-bold text-slate-900">Detail Kelas {{ $kelas->nama_kelas }}</h2>
        <p class="text-sm text-slate-500">Ringkasan identitas kelas, komposisi santri, dan status kesehatan.</p>
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
    <div class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <x-card class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100">
                <p class="text-xs uppercase tracking-wider text-blue-600 font-bold flex items-center gap-2">
                    <span>🏫</span> Kode Kelas
                </p>
                <p class="mt-2 text-2xl font-black text-slate-900">{{ $kelas->kode_kelas ?: '-' }}</p>
            </x-card>
            <x-card class="bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-100">
                <p class="text-xs uppercase tracking-wider text-emerald-700 font-bold flex items-center gap-2">
                    <span>👥</span> Total Santri
                </p>
                <p class="mt-2 text-2xl font-black text-slate-900">{{ $kelas->santri->count() }}</p>
            </x-card>
            <x-card class="bg-gradient-to-br from-rose-50 to-pink-50 border border-rose-100">
                <p class="text-xs uppercase tracking-wider text-rose-700 font-bold flex items-center gap-2">
                    <span>🩺</span> Total Riwayat Sakit
                </p>
                <p class="mt-2 text-2xl font-black text-slate-900">{{ $riwayatSakit }}</p>
            </x-card>
            <x-card class="bg-gradient-to-br from-violet-50 to-purple-50 border border-violet-100">
                <p class="text-xs uppercase tracking-wider text-violet-700 font-bold flex items-center gap-2">
                    <span>📅</span> Tahun Ajaran
                </p>
                <p class="mt-2 text-2xl font-black text-slate-900">{{ $kelas->tahun_ajaran ?: '-' }}</p>
            </x-card>
        </div>

        <x-card>
            <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center">🧾</span>
                Identitas Kelas
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 text-sm">
                <div class="rounded-xl border border-blue-100 bg-blue-50 p-4">
                    <p class="text-xs uppercase tracking-wider text-blue-700 font-bold">Nama Kelas</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ $kelas->nama_kelas ?: '-' }}</p>
                </div>
                <div class="rounded-xl border border-indigo-100 bg-indigo-50 p-4">
                    <p class="text-xs uppercase tracking-wider text-indigo-700 font-bold">Jenjang</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ $kelas->jenjang ?: '-' }}</p>
                </div>
                <div class="rounded-xl border border-violet-100 bg-violet-50 p-4">
                    <p class="text-xs uppercase tracking-wider text-violet-700 font-bold">Tingkat</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ $kelas->tingkat ?: '-' }}</p>
                </div>
                <div class="rounded-xl border border-cyan-100 bg-cyan-50 p-4">
                    <p class="text-xs uppercase tracking-wider text-cyan-700 font-bold">Jurusan Terkait</p>
                    <div class="mt-2 flex flex-wrap gap-1.5">
                        @forelse($kelas->jurusans as $jurusan)
                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold bg-white text-cyan-700 border border-cyan-200">
                                {{ $jurusan->nama_jurusan }}
                            </span>
                        @empty
                            <span class="text-slate-400">-</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </x-card>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <x-card>
                <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-rose-50 border border-rose-100 flex items-center justify-center">❤️</span>
                    Distribusi Status Kesehatan
                </h3>
                <div class="mb-3 flex flex-wrap gap-2">
                    @foreach($statusStyles as $label => $class)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold border {{ $class }}">
                            {{ $label }}
                        </span>
                    @endforeach
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
            </x-card>

            <x-card>
                <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-cyan-50 border border-cyan-100 flex items-center justify-center">🧩</span>
                    Komposisi Jurusan Santri
                </h3>
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
            </x-card>
        </div>

        <x-card>
            <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center">📋</span>
                Daftar Santri di Kelas Ini
            </h3>
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
        </x-card>
    </div>
@endsection
