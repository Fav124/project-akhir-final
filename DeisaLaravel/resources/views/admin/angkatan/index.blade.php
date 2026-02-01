@extends('layouts.admin')

@section('title', 'Data Angkatan - Deisa Health')

@section('header')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 w-full">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Data Angkatan (Batch)</h1>
            <p class="text-xs text-slate-500">Manajemen angkatan santri secara manual dan terstruktur</p>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="p-4 bg-blue-50 border border-blue-100 rounded-2xl flex items-start gap-4 max-w-2xl flex-1">
                <div class="w-10 h-10 bg-deisa-blue rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-deisa-blue">Tentang Sistem Angkatan</h4>
                    <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                        Data Angkatan sekarang dikelola secara manual. Anda dapat menambahkan angkatan baru dan memilihnya
                        saat mendaftarkan santri.
                    </p>
                </div>
            </div>

            <x-button class="whitespace-nowrap shadow-lg shadow-blue-500/20 w-full md:w-auto mt-2 md:mt-0"
                data-form-url="{{ route('admin.angkatan.create') }}">
                + Tambah Angkatan
            </x-button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($angkatans as $a)
                <x-card class="relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-20 h-20 text-deisa-blue" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14l-5-4.87 6.91-1.01L12 2z" />
                        </svg>
                    </div>

                    <div class="flex justify-between items-start mb-4 relative z-10">
                        <div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Entry Year</span>
                            <h3 class="text-2xl font-black text-slate-900">{{ $a->tahun }}</h3>
                        </div>
                        <div class="flex gap-2">
                            <button data-form-url="{{ route('admin.angkatan.edit', $a->id) }}"
                                class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition-colors shadow-sm border border-amber-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </button>
                            <button data-ajax-url="{{ route('admin.angkatan.destroy', $a->id) }}" data-method="DELETE"
                                data-confirm="Apakah Anda yakin ingin menghapus data angkatan ini? Semua santri dan kelas di angkatan ini harus dipindahkan terlebih dahulu."
                                class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors shadow-sm border border-red-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-bold text-slate-700">{{ $a->nama_angkatan }}</h4>
                    </div>

                    <div class="text-center p-3 rounded-xl bg-slate-50 group-hover:bg-blue-50 transition-colors w-full">
                        <div class="text-lg font-black text-slate-900">{{ $a->santris_count ?? 0 }}</div>
                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-tight">Santri Terdaftar</div>
                    </div>
                </x-card>
            @empty
                <div
                    class="col-span-full py-20 bg-white rounded-3xl border border-dashed border-slate-200 flex flex-col items-center justify-center text-slate-400">
                    <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p class="font-medium">Belum ada data angkatan.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection