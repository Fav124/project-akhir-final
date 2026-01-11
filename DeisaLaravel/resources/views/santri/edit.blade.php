@extends('layouts.app-tailwind')

@section('title', 'Edit Santri')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    <!-- Header Section -->
    <div class="flex items-center gap-6 py-4 animate-slide-in-down">
        <a href="{{ route('web.santri.index') }}" class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-white shadow-xl shadow-gray-200/50 border border-gray-100 text-gray-400 hover:text-amber-500 hover:border-amber-100 transition-all duration-500 group">
            <svg class="w-8 h-8 transform group-hover:-translate-x-1.5 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight leading-none">Edit Data Santri</h1>
            <p class="text-gray-500 font-medium mt-2">Memperbarui informasi profil {{ $santri->nama_lengkap }}</p>
        </div>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="animate-shake">
            <x-alert type="error" title="Validasi Gagal!">
                <ul class="list-disc list-inside space-y-1 text-sm font-bold opacity-90">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        </div>
    @endif

    <form action="{{ route('web.santri.update', $santri) }}" method="POST" class="space-y-8 pb-20">
        @csrf
        @method('PUT')
        
        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Data Pribadi -->
            <x-card variant="default" title="Data Pribadi" subtitle="Edit informasi dasar santri">
                <div class="space-y-4">
                    <div>
                        <label for="nis" class="block text-sm font-medium text-gray-700 mb-2">
                            NIS <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nis" 
                            name="nis" 
                            value="{{ old('nis', $santri->nis) }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all {{ $errors->has('nis') ? 'border-red-500' : '' }}"
                            required>
                        @error('nis')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nama_lengkap" 
                            name="nama_lengkap" 
                            value="{{ old('nama_lengkap', $santri->nama_lengkap) }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all {{ $errors->has('nama_lengkap') ? 'border-red-500' : '' }}"
                            required>
                        @error('nama_lengkap')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Panggilan
                        </label>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            value="{{ old('nama', $santri->nama) }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="jenis_kelamin" 
                                name="jenis_kelamin" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all {{ $errors->has('jenis_kelamin') ? 'border-red-500' : '' }}"
                                required>
                                <option value="L" {{ old('jenis_kelamin', $santri->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $santri->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="golongan_darah" class="block text-sm font-medium text-gray-700 mb-2">
                                Golongan Darah
                            </label>
                            <input 
                                type="text" 
                                id="golongan_darah" 
                                name="golongan_darah" 
                                value="{{ old('golongan_darah', $santri->golongan_darah) }}"
                                placeholder="O, A, B, AB"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                        </div>
                    </div>

                    <div>
                        <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Kelas <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="kelas_id" 
                            name="kelas_id" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all {{ $errors->has('kelas_id') ? 'border-red-500' : '' }}"
                            required>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id', $santri->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jurusan_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Jurusan <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="jurusan_id" 
                            name="jurusan_id" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all {{ $errors->has('jurusan_id') ? 'border-red-500' : '' }}"
                            required>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}" {{ old('jurusan_id', $santri->jurusan_id) == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                            @endforeach
                        </select>
                        @error('jurusan_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-card>

            <!-- Data Wali -->
            <x-card variant="default" title="Data Wali Santri" subtitle="Edit informasi kontak wali">
                <div class="space-y-4">
                    <div>
                        <label for="nama_wali" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Wali <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nama_wali" 
                            name="nama_wali" 
                            value="{{ old('nama_wali', $santri->wali?->nama_wali) }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all {{ $errors->has('nama_wali') ? 'border-red-500' : '' }}"
                            required>
                        @error('nama_wali')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="no_telp_wali" class="block text-sm font-medium text-gray-700 mb-2">
                            No. Telepon Wali <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="no_telp_wali" 
                            name="no_telp_wali" 
                            value="{{ old('no_telp_wali', $santri->wali?->no_telp_wali) }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all {{ $errors->has('no_telp_wali') ? 'border-red-500' : '' }}"
                            required>
                        @error('no_telp_wali')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="hubungan_wali" class="block text-sm font-medium text-gray-700 mb-2">
                            Hubungan Wali <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="hubungan_wali" 
                            name="hubungan_wali" 
                            value="{{ old('hubungan_wali', $santri->wali?->hubungan) }}"
                            placeholder="Ayah / Ibu / Paman / Nenek"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all {{ $errors->has('hubungan_wali') ? 'border-red-500' : '' }}"
                            required>
                        @error('hubungan_wali')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="pekerjaan_wali" class="block text-sm font-medium text-gray-700 mb-2">
                            Pekerjaan Wali
                        </label>
                        <input 
                            type="text" 
                            id="pekerjaan_wali" 
                            name="pekerjaan_wali" 
                            value="{{ old('pekerjaan_wali', $santri->wali?->pekerjaan) }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                    </div>

                    <div>
                        <label for="alamat_wali" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Wali
                        </label>
                        <textarea 
                            id="alamat_wali" 
                            name="alamat_wali" 
                            rows="3"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all resize-none">{{ old('alamat_wali', $santri->wali?->alamat) }}</textarea>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 justify-end">
            <a href="{{ route('web.santri.index') }}" class="px-6 py-2.5 rounded-lg font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
                Batal
            </a>
            <button 
                type="submit" 
                class="inline-flex items-center px-6 py-2.5 rounded-lg font-medium text-white bg-gradient-to-r from-amber-500 to-amber-600 hover:shadow-lg hover:shadow-amber-500/30 transition-all duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Perbarui Data Santri
            </button>
        </div>
    </form>
</div>
@endsection
