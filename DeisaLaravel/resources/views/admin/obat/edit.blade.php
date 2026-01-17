@extends('layouts.admin')

@section('title', 'Edit Obat')

@section('header')
    <div class="flex items-center gap-4">
        <a href="/admin/obat" class="text-slate-500 hover:text-slate-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
        </a>
        <h2 class="text-xl font-bold text-slate-900">Edit Obat: {{ $obat->nama_obat }}</h2>
    </div>
@endsection

@section('admin-content')
    <div class="max-w-3xl mx-auto">
        <x-card>
            <form action="{{ route('admin.obat.update', $obat->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6" data-ajax="true">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode & Nama -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kode Obat</label>
                        <input type="text" name="kode" value="{{ $obat->kode_obat }}"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 bg-slate-50 text-slate-500 cursor-not-allowed"
                            readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Obat</label>
                        <input type="text" name="nama" value="{{ $obat->nama_obat }}"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue"
                            required>
                    </div>
                </div>

                <!-- Kategori & Satuan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                        <select name="kategori"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue bg-white">
                            <option value="Tablet" {{ $obat->kategori == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="Sirup" {{ $obat->kategori == 'Sirup' ? 'selected' : '' }}>Sirup</option>
                            <option value="Alkes" {{ $obat->kategori == 'Alkes' ? 'selected' : '' }}>Alkes</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Satuan</label>
                        <select name="satuan"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue bg-white">
                            <option value="Strip" {{ $obat->satuan == 'Strip' ? 'selected' : '' }}>Strip</option>
                            <option value="Botol" {{ $obat->satuan == 'Botol' ? 'selected' : '' }}>Botol</option>
                            <option value="Tablet" {{ $obat->satuan == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                        </select>
                    </div>
                </div>

                <!-- Stok & Harga -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Stok Saat Ini</label>
                        <input type="number" name="stok" value="{{ $obat->stok }}"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 bg-slate-50 text-slate-500" readonly>
                        <p class="text-xs text-slate-500 mt-1">Gunakan fitur Restock untuk menambah</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Stok Minimum</label>
                        <input type="number" name="stok_min" value="{{ $obat->stok_minimum }}"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Harga Satuan (Rp)</label>
                        <input type="number" name="harga" value="{{ $obat->harga_satuan }}"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                    </div>
                </div>

                <!-- Expired & Location -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Kadaluarsa</label>
                        <input type="date" name="kadaluarsa"
                            value="{{ $obat->tanggal_kadaluarsa ? $obat->tanggal_kadaluarsa->format('Y-m-d') : '' }}"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Lokasi Penyimpanan</label>
                        <input type="text" name="lokasi" value="{{ $obat->lokasi_penyimpanan }}"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100 gap-4">
                    <x-button variant="outline" type="button" href="/admin/obat">Batal</x-button>
                    <x-button>Simpan Perubahan</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection