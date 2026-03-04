@extends('layouts.admin')

@section('title', 'Detail Jurusan')

@section('header')
    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
        <div class="space-y-2">
            <a href="{{ route('admin.jurusan.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-deisa-blue">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Manajemen Jurusan
            </a>
            <h2 class="text-xl font-bold text-slate-900">Detail Jurusan {{ $jurusan->nama_jurusan }}</h2>
            <p class="text-sm text-slate-500">Informasi jurusan, kelas terkait, serta persebaran status santri.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.jurusan.edit', $jurusan->id) }}"
               class="inline-flex items-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Edit Jurusan
            </a>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="mx-auto max-w-6xl space-y-6">
        <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/40 rounded-3xl">
            <div class="p-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-2xl border border-violet-100 bg-violet-50 p-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-violet-700">Kode Jurusan</p>
                        <p class="mt-2 text-2xl font-black text-slate-900">{{ $jurusan->kode_jurusan ?: '-' }}</p>
                    </div>
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-blue-700">Total Kelas</p>
                        <p class="mt-2 text-2xl font-black text-slate-900">{{ $jurusan->kelas->count() }}</p>
                    </div>
                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Total Santri</p>
                        <p class="mt-2 text-2xl font-black text-slate-900">{{ $santris->count() }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-600">Update Terakhir</p>
                        <p class="mt-2 text-lg font-black text-slate-900">{{ $jurusan->updated_at?->format('d M Y H:i') ?: '-' }}</p>
                    </div>
                </div>
            </div>
        </x-card>

        <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/30 rounded-3xl">
            <div class="p-6 space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center text-violet-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 8h10"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Profil Jurusan</h3>
                    </div>

                    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 text-sm">
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 xl:col-span-1">
                            <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Nama Jurusan</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $jurusan->nama_jurusan }}</p>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 xl:col-span-2">
                            <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Deskripsi</p>
                            <p class="mt-1 text-slate-700 leading-relaxed">{{ $jurusan->deskripsi ?: 'Belum ada deskripsi jurusan.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h6m-6 4h10M5 6h.01M5 10h.01M5 14h.01M5 18h.01"></path>
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Distribusi Kelas</h3>
                        </div>
                        <div class="space-y-3">
                            @forelse($distribusiKelas as $namaKelas => $jumlah)
                                <div class="flex items-center justify-between rounded-xl border border-blue-100 bg-blue-50 p-3">
                                    <span class="font-medium text-blue-900">{{ $namaKelas }}</span>
                                    <span class="font-bold text-slate-900">{{ $jumlah }} santri</span>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 italic">Belum ada distribusi kelas.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center text-rose-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Status Kesehatan Santri</h3>
                        </div>
                        <div class="space-y-3">
                            @forelse($statusKesehatan as $status => $jumlah)
                                <div class="flex items-center justify-between rounded-xl border border-rose-100 bg-rose-50 p-3">
                                    <span class="font-medium text-rose-900">{{ $status }}</span>
                                    <span class="font-bold text-slate-900">{{ $jumlah }} santri</span>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 italic">Belum ada data status kesehatan.</p>
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
                    <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Kelas Terkait Jurusan</h3>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-100">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Kode</th>
                                <th class="px-4 py-3 text-left font-semibold">Nama Kelas</th>
                                <th class="px-4 py-3 text-left font-semibold">Jenjang</th>
                                <th class="px-4 py-3 text-left font-semibold">Tingkat</th>
                                <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($jurusan->kelas as $kelas)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 font-mono text-slate-600">{{ $kelas->kode_kelas ?: '-' }}</td>
                                    <td class="px-4 py-3 font-semibold text-slate-900">{{ $kelas->nama_kelas ?: '-' }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $kelas->jenjang ?: '-' }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $kelas->tingkat ?: '-' }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('admin.kelas.show', $kelas->id) }}" class="text-deisa-blue font-semibold hover:underline">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-slate-400 italic">Belum ada kelas terkait jurusan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </x-card>
    </div>
@endsection
