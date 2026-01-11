@extends('layouts.app-tailwind')

@section('title', 'Tambah Obat')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex items-center gap-6 py-4 animate-slide-in-down">
        <a href="{{ route('web.obat.index') }}" class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-white shadow-xl shadow-gray-200/50 border border-gray-100 text-gray-400 hover:text-blue-500 hover:border-blue-100 transition-all duration-500 group">
            <svg class="w-8 h-8 transform group-hover:-translate-x-1.5 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight leading-none">Tambah Obat Baru</h1>
            <p class="text-gray-500 font-medium mt-2">Daftarkan stok obat medis baru ke inventaris.</p>
        </div>
    </div>

    <!-- Form Card -->
    <x-card variant="premium" title="Detail Obat" subtitle="Spesifikasi & Inventaris">
        <form action="{{ route('web.obat.store') }}" method="POST" class="space-y-8 p-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Nama Obat -->
                <div class="md:col-span-2 space-y-2">
                    <label for="nama_obat" class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 flex items-center gap-1">Nama Obat <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_obat" id="nama_obat" placeholder="Misal: Paracetamol 500mg" 
                        class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-bold text-gray-700 shadow-sm" required>
                </div>

                <!-- Kategori -->
                <div class="space-y-2">
                    <label for="kategori" class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Kategori / Golongan</label>
                    <input type="text" name="kategori" id="kategori" placeholder="Analgasik, Antibiotik, dll" 
                        class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-bold text-gray-700 shadow-sm">
                </div>

                <!-- Satuan -->
                <div class="space-y-2">
                    <label for="satuan" class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Satuan <span class="text-red-500">*</span></label>
                    <input type="text" name="satuan" id="satuan" placeholder="Tablet, Botol, Pcs" 
                        class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-bold text-gray-700 shadow-sm uppercase" required>
                </div>

                <!-- Stok Awal -->
                <div class="space-y-2">
                    <label for="stok" class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 flex items-center gap-1">Stok Awal <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" id="stok" value="0" min="0" 
                        class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-bold text-gray-700 shadow-sm" required>
                </div>

                <!-- Stok Minimum -->
                <div class="space-y-2">
                    <label for="stok_minimum" class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 flex items-center gap-1">Stok Minimum <span class="text-red-500">*</span></label>
                    <input type="number" name="stok_minimum" id="stok_minimum" value="10" min="0" 
                        class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-bold text-gray-700 shadow-sm" required>
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2 space-y-2">
                    <label for="deskripsi" class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Deskripsi / Kegunaan</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Jelaskan kegunaan dan dosis umum obat ini..." 
                        class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-bold text-gray-700 resize-none shadow-sm"></textarea>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-50">
                <a href="{{ route('web.obat.index') }}" class="px-8 py-4 rounded-2xl font-black text-gray-400 uppercase tracking-widest text-[10px] hover:bg-gray-50 transition-all">Batal</a>
                <button type="submit" class="px-10 py-4 rounded-2xl font-black text-white bg-gradient-to-r from-blue-500 to-blue-700 shadow-2xl shadow-blue-200 hover:shadow-blue-300 transition-all duration-500 transform hover:-translate-y-1.5 active:scale-95 uppercase tracking-widest text-[10px]">
                    Simpan Database Obat
                </button>
            </div>
        </form>
    </x-card>
</div>
@endsection
