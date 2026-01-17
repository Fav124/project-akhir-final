@extends('layouts.admin')

@section('title', 'Tambah Obat Baru')

@section('header')
    <div class="flex items-center gap-4">
        <a href="/admin/obat" class="text-slate-500 hover:text-slate-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
        </a>
        <h2 class="text-xl font-bold text-slate-900">Tambah Obat Baru</h2>
    </div>
@endsection

@section('admin-content')
    <div class="max-w-3xl mx-auto">
        <x-card>
            <form action="{{ route('admin.obat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6"
                data-ajax="true">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode & Nama -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kode Obat</label>
                        <input type="text" name="kode" value="OBT-003"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 bg-slate-50 text-slate-500 cursor-not-allowed"
                            readonly>
                        <p class="text-xs text-slate-500 mt-1">Kode digenerate otomatis</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Obat</label>
                        <input type="text" name="nama"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue"
                            required placeholder="Contoh: Paracetamol 500mg">
                    </div>
                </div>

                <!-- Kategori & Satuan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                        <select name="kategori"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue bg-white">
                            <option>Tablet</option>
                            <option>Sirup</option>
                            <option>Kapsul</option>
                            <option>Alat Kesehatan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Satuan</label>
                        <select name="satuan"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue bg-white">
                            <option>Strip</option>
                            <option>Botol</option>
                            <option>Pcs</option>
                            <option>Box</option>
                        </select>
                    </div>
                </div>

                <!-- Stok & Harga -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Stok Awal</label>
                        <input type="number" name="stok"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue"
                            required min="0">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Stok Minimum (Alert)</label>
                        <input type="number" name="stok_min"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue"
                            value="10" min="0">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Harga (Opsional)</label>
                        <input type="number" name="harga"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue"
                            placeholder="Rp">
                    </div>
                </div>

                <!-- Expired & Location -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Kadaluarsa</label>
                        <input type="date" name="kadaluarsa"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Lokasi Rak</label>
                        <input type="text" name="lokasi"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue"
                            placeholder="Rak A2">
                    </div>
                </div>

                <!-- Photo Upload -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Foto Obat</label>
                    <div
                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:bg-slate-50 transition-colors cursor-pointer">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none"
                                viewBox="0 0 48 48" aria-hidden="true">
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600">
                                <label for="file-upload"
                                    class="relative cursor-pointer bg-white rounded-md font-medium text-deisa-blue hover:text-blue-500 focus-within:outline-none">
                                    <span>Upload a file</span>
                                    <input id="file-upload" name="foto" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-slate-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100 gap-4">
                    <x-button variant="outline" type="button" href="/admin/obat">Batal</x-button>
                    <x-button>Simpan Data</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection