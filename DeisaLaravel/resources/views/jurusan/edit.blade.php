@extends('layouts.app-tailwind')

@section('title', 'Edit Jurusan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4 py-4 animate-slide-in-down">
        <a href="{{ route('web.jurusan.index') }}" class="p-2.5 rounded-xl bg-white shadow-sm border border-gray-100 text-gray-400 hover:text-indigo-500 hover:border-indigo-100 transition-all duration-300 group">
            <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Edit Jurusan</h1>
            <p class="text-gray-500 font-medium mt-1">Ubah informasi kompetensi keahlian.</p>
        </div>
    </div>

    <!-- Form Card -->
    <x-card variant="premium" title="Update Kompetensi Keahlian" subtitle="Master Data Jurusan">
        <form action="{{ route('web.jurusan.update', $jurusan) }}" method="POST" class="space-y-8 p-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Nama Jurusan -->
                <div class="space-y-2">
                    <label for="nama_jurusan" class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Nama Jurusan</label>
                    <input type="text" name="nama_jurusan" id="nama_jurusan" value="{{ $jurusan->nama_jurusan }}" 
                        class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:border-indigo-400 transition-all outline-none font-bold text-gray-700" required>
                </div>

                <!-- Kode Jurusan -->
                <div class="space-y-2">
                    <label for="kode_jurusan" class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Kode Jurusan</label>
                    <input type="text" name="kode_jurusan" id="kode_jurusan" value="{{ $jurusan->kode_jurusan }}" 
                        class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:border-indigo-400 transition-all outline-none font-bold text-gray-700 uppercase" required>
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2 space-y-2">
                    <label for="deskripsi" class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" 
                        class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:border-indigo-400 transition-all outline-none font-bold text-gray-700 resize-none">{{ $jurusan->deskripsi }}</textarea>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-50">
                <a href="{{ route('web.jurusan.index') }}" class="px-8 py-4 rounded-2xl font-black text-gray-400 uppercase tracking-widest text-xs hover:bg-gray-50 transition-all">Batal</a>
                <button type="submit" class="px-10 py-4 rounded-2xl font-black text-white bg-gradient-to-r from-indigo-500 to-purple-600 shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-300 transition-all duration-300 transform hover:-translate-y-1 uppercase tracking-widest text-xs">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </x-card>
</div>
@endsection
