@extends('layouts.admin')

@section('title', 'Edit Obat')

@section('header')
    <div class="space-y-1">
        <a href="{{ route('admin.obat.show', $obat->id) }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-deisa-blue">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Detail Obat
        </a>
        <h2 class="text-lg font-bold text-slate-900 leading-tight">Edit Obat {{ $obat->nama_obat }}</h2>
    </div>
@endsection

@section('admin-content')
    <div class="max-w-4xl mx-auto">
        <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/50 rounded-3xl">
            <form action="{{ route('admin.obat.update', $obat->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-deisa-blue">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Informasi Utama</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kode Obat</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h6m-6 4h8"></path></svg>
                                    </span>
                                    <input type="text" value="{{ $obat->kode_obat }}" readonly
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 bg-slate-50 text-slate-500 cursor-not-allowed">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Obat</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"></path></svg>
                                    </span>
                                    <input type="text" name="nama" value="{{ old('nama', $obat->nama_obat) }}" required
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kategori</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7"></path></svg>
                                    </span>
                                    <select name="kategori" required
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                                        @foreach(['Tablet', 'Sirup', 'Kapsul', 'Alkes'] as $kategori)
                                            <option value="{{ $kategori }}" {{ old('kategori', $obat->kategori) == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Satuan</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8m-8 5h8m-8 5h8"></path></svg>
                                    </span>
                                    <select name="satuan" required
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                                        @foreach(['Strip', 'Botol', 'Tablet', 'Pcs'] as $satuan)
                                            <option value="{{ $satuan }}" {{ old('satuan', $obat->satuan) == $satuan ? 'selected' : '' }}>{{ $satuan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Stok & Logistik</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Stok Saat Ini</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3m0 0c0 1.657 1.343 3 3 3m-3-3h6"></path></svg>
                                    </span>
                                    <input type="number" value="{{ $obat->stok }}" readonly
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 bg-slate-50 text-slate-500 cursor-not-allowed">
                                </div>
                                <p class="text-[10px] text-slate-500 mt-1">Gunakan fitur restock untuk menambah stok.</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Stok Minimum</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m-4-4h8"></path></svg>
                                    </span>
                                    <input type="number" name="stok_min" value="{{ old('stok_min', $obat->stok_minimum) }}" required
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Harga Satuan (Rp)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 text-xs font-bold">Rp</span>
                                    <input type="number" name="harga" value="{{ old('harga', $obat->harga_satuan) }}"
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Kadaluarsa</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </span>
                                    <input type="date" name="kadaluarsa"
                                        value="{{ old('kadaluarsa', optional($obat->tanggal_kadaluarsa)->format('Y-m-d')) }}"
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Lokasi Penyimpanan</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </span>
                                    <input type="text" name="lokasi" value="{{ old('lokasi', $obat->lokasi_penyimpanan) }}"
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue"
                                        placeholder="Contoh: Rak A1">
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Foto Obat</label>
                                <input type="file" name="foto" accept="image/*"
                                    class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-deisa-blue hover:file:bg-blue-100">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-2">
                    <x-button variant="outline" type="button" href="{{ route('admin.obat.show', $obat->id) }}"
                        class="rounded-2xl px-8 font-bold border-slate-200">Batal</x-button>
                    <x-button type="submit" class="rounded-2xl px-8 font-black shadow-lg shadow-blue-500/20">Simpan Perubahan</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
