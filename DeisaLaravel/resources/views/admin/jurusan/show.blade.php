@extends('layouts.admin')

@section('title', 'Detail Jurusan')

@section('header')
    <div class="flex flex-col gap-2">
        <a href="{{ route('admin.jurusan.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-deisa-blue">
            <span aria-hidden="true">←</span> Kembali ke Manajemen Jurusan
        </a>
        <h2 class="text-xl font-bold text-slate-900">Detail Jurusan {{ $jurusan->nama_jurusan }}</h2>
        <p class="text-sm text-slate-500">Informasi jurusan, kelas terkait, serta persebaran status santri.</p>
    </div>
@endsection

@section('admin-content')
    <div class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <x-card>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Kode Jurusan</p>
                <p class="mt-2 text-2xl font-black text-slate-900">{{ $jurusan->kode_jurusan ?: '-' }}</p>
            </x-card>
            <x-card>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Total Kelas</p>
                <p class="mt-2 text-2xl font-black text-slate-900">{{ $jurusan->kelas->count() }}</p>
            </x-card>
            <x-card>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Total Santri</p>
                <p class="mt-2 text-2xl font-black text-slate-900">{{ $santris->count() }}</p>
            </x-card>
            <x-card>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Update Terakhir</p>
                <p class="mt-2 text-lg font-black text-slate-900">{{ $jurusan->updated_at?->format('d M Y H:i') ?: '-' }}</p>
            </x-card>
        </div>

        <x-card>
            <h3 class="text-base font-bold text-slate-900 mb-4">Profil Jurusan</h3>
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 text-sm">
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 xl:col-span-1">
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Nama Jurusan</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ $jurusan->nama_jurusan }}</p>
                </div>
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 xl:col-span-2">
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Deskripsi</p>
                    <p class="mt-1 text-slate-700 leading-relaxed">{{ $jurusan->deskripsi ?: 'Belum ada deskripsi jurusan.' }}</p>
                </div>
            </div>
        </x-card>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <x-card>
                <h3 class="text-base font-bold text-slate-900 mb-4">Distribusi Kelas</h3>
                <div class="space-y-3">
                    @forelse($distribusiKelas as $namaKelas => $jumlah)
                        <div class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50 p-3">
                            <span class="font-medium text-slate-700">{{ $namaKelas }}</span>
                            <span class="font-bold text-slate-900">{{ $jumlah }} santri</span>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400 italic">Belum ada distribusi kelas.</p>
                    @endforelse
                </div>
            </x-card>

            <x-card>
                <h3 class="text-base font-bold text-slate-900 mb-4">Status Kesehatan Santri</h3>
                <div class="space-y-3">
                    @forelse($statusKesehatan as $status => $jumlah)
                        <div class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50 p-3">
                            <span class="font-medium text-slate-700">{{ $status }}</span>
                            <span class="font-bold text-slate-900">{{ $jumlah }} santri</span>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400 italic">Belum ada data status kesehatan.</p>
                    @endforelse
                </div>
            </x-card>
        </div>

        <x-card>
            <h3 class="text-base font-bold text-slate-900 mb-4">Kelas Terkait Jurusan</h3>
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
        </x-card>
    </div>
@endsection
