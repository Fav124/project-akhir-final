@extends('layouts.app-tailwind')

@section('title', 'Edit Kelas')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4 py-4 animate-slide-in-down">
        <a href="{{ route('web.kelas.index') }}" class="p-2.5 rounded-xl bg-white shadow-sm border border-gray-100 text-gray-400 hover:text-blue-500 hover:border-blue-100 transition-all duration-300 group">
            <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Edit Kelas</h1>
            <p class="text-gray-500 font-medium mt-1">Ubah informasi pembagian kelas dan tahun ajaran.</p>
        </div>
    </div>

    <!-- Form Card -->
    <x-card variant="premium" title="Edit Informasi Kelas" subtitle="Master Data Akademik">
        <form action="{{ route('web.kelas.update', $kelas) }}" method="POST" class="space-y-8 p-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Nama Kelas -->
                <div class="space-y-2">
                    <label for="nama_kelas" class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Nama Kelas</label>
                    <div class="relative group">
                        <input type="text" name="nama_kelas" id="nama_kelas" value="{{ $kelas->nama_kelas }}"
                            class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-bold text-gray-700" required>
                    </div>
                </div>

                <!-- Tahun Ajaran -->
                <div class="space-y-2">
                    <label for="tahun_ajaran" class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Tahun Ajaran</label>
                    <div class="relative group">
                        <input type="text" name="tahun_ajaran" id="tahun_ajaran" value="{{ $kelas->tahun_ajaran }}"
                            class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-bold text-gray-700" required>
                    </div>
                </div>

                <!-- Jurusan -->
                <div class="md:col-span-2 space-y-2">
                    <label for="jurusan_id" class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Jurusan / Kompetensi Keahlian</label>
                    <select name="jurusan_id" id="jurusan_id" 
                        class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-bold text-gray-700 appearance-none" required>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id }}" {{ $kelas->jurusan_id == $j->id ? 'selected' : '' }}>
                                {{ $j->nama_jurusan }} ({{ $j->kode_jurusan }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-50">
                <a href="{{ route('web.kelas.index') }}" class="px-8 py-4 rounded-2xl font-black text-gray-400 uppercase tracking-widest text-xs hover:bg-gray-50 transition-all">Batal</a>
                <button type="submit" class="px-10 py-4 rounded-2xl font-black text-white bg-gradient-to-r from-blue-500 to-indigo-600 shadow-lg shadow-blue-200 hover:shadow-xl hover:shadow-blue-300 transition-all duration-300 transform hover:-translate-y-1 uppercase tracking-widest text-xs">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </x-card>
</div>
@endsection
