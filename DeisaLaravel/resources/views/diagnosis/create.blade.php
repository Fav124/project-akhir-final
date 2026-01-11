@extends('layouts.app-tailwind')

@section('title', 'Tambah Diagnosis')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4 py-4 animate-slide-in-down">
        <a href="{{ route('web.diagnosis.index') }}" class="p-2.5 rounded-xl bg-white shadow-sm border border-gray-100 text-gray-400 hover:text-rose-500 hover:border-rose-100 transition-all duration-300 group">
            <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Tambah Diagnosis</h1>
            <p class="text-gray-500 font-medium mt-1">Daftarkan referensi diagnosa penyakit baru.</p>
        </div>
    </div>

    <!-- Form Card -->
    <x-card variant="premium" title="Daftar Diagnosis Baru" subtitle="Master Data Kesehatan">
        <form action="{{ route('web.diagnosis.store') }}" method="POST" class="space-y-8 p-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Nama Diagnosis -->
                <div class="space-y-2">
                    <label for="nama_diagnosis" class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Nama Diagnosis</label>
                    <input type="text" name="nama_diagnosis" id="nama_diagnosis" placeholder="Misal: Demam Berdarah" 
                        class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-rose-100 focus:border-rose-400 transition-all outline-none font-bold text-gray-700" required>
                </div>

                <!-- Kategori -->
                <div class="space-y-2">
                    <label for="kategori" class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Kategori Keparahan</label>
                    <select name="kategori" id="kategori" 
                        class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-rose-100 focus:border-rose-400 transition-all outline-none font-bold text-gray-700 appearance-none" required>
                        <option value="Ringan">Ringan (Hijau)</option>
                        <option value="Sedang">Sedang (Kuning)</option>
                        <option value="Berat">Berat (Merah)</option>
                    </select>
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2 space-y-2">
                    <label for="deskripsi" class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Deskripsi / Penjelasan</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Berikan penjelasan singkat mengenai penyakit ini dan gejala umumnya..." 
                        class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-rose-100 focus:border-rose-400 transition-all outline-none font-bold text-gray-700 resize-none"></textarea>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-50">
                <a href="{{ route('web.diagnosis.index') }}" class="px-8 py-4 rounded-2xl font-black text-gray-400 uppercase tracking-widest text-xs hover:bg-gray-50 transition-all">Batal</a>
                <button type="submit" class="px-10 py-4 rounded-2xl font-black text-white bg-gradient-to-r from-rose-500 to-red-600 shadow-lg shadow-rose-200 hover:shadow-xl hover:shadow-rose-300 transition-all duration-300 transform hover:-translate-y-1 uppercase tracking-widest text-xs">
                    Simpan Diagnosis
                </button>
            </div>
        </form>
    </x-card>
</div>
@endsection
