@extends('layouts.admin')

@section('title', 'Edit Jurusan')

@section('header')
    <div class="space-y-1">
        <a href="{{ route('admin.jurusan.show', $jurusan->id) }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-deisa-blue">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Detail Jurusan
        </a>
        <h2 class="text-lg font-bold text-slate-900 leading-tight">Edit Jurusan {{ $jurusan->nama_jurusan }}</h2>
    </div>
@endsection

@section('admin-content')
    <div class="max-w-4xl mx-auto">
        <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/50 rounded-3xl">
            <form action="{{ route('admin.jurusan.update', $jurusan->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center text-violet-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 8h10"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Informasi Jurusan</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kode Jurusan</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h6m-6 4h8"></path></svg>
                                    </span>
                                    <input type="text" name="kode_jurusan" value="{{ old('kode_jurusan', $jurusan->kode_jurusan) }}" required
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                        placeholder="Contoh: RPL, TKJ, AK">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Jurusan</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path></svg>
                                    </span>
                                    <input type="text" name="nama_jurusan" value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}" required
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                        placeholder="Contoh: Rekayasa Perangkat Lunak">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Deskripsi</label>
                            <div class="relative">
                                <span class="absolute top-3 left-3 text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 8h10"></path></svg>
                                </span>
                                <textarea name="deskripsi" rows="4"
                                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                    placeholder="Penjelasan singkat tentang jurusan...">{{ old('deskripsi', $jurusan->deskripsi) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-2">
                    <x-button variant="outline" type="button" href="{{ route('admin.jurusan.show', $jurusan->id) }}"
                        class="rounded-2xl px-8 font-bold border-slate-200">Batal</x-button>
                    <x-button type="submit" class="rounded-2xl px-8 font-black shadow-lg shadow-blue-500/20">
                        Simpan Perubahan
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
