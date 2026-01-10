@extends('layouts.master')
@section('content')
<div class="space-y-6">
    <!-- PAGE HEADER -->
    <div>
        <nav class="flex mb-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white">
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-text-muted text-lg mx-1">chevron_right</span>
                        <a href="{{ route('jurusan.index') }}" class="text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white">Data Jurusan</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-text-muted text-lg mx-1">chevron_right</span>
                        <span class="text-sm font-medium text-text-main dark:text-gray-200">Tambah Jurusan</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-3xl font-bold text-text-main dark:text-white">Tambah Data Jurusan</h1>
        <p class="text-text-muted dark:text-gray-400 mt-1">Tambahkan jurusan baru untuk santri.</p>
    </div>

    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-6 max-w-2xl">
        <form action="{{ route('jurusan.store') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Nama Jurusan <span class="text-red-500">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('nama') border-red-500 @enderror" 
                           id="nama" name="nama" value="{{ old('nama') }}" required
                           placeholder="Contoh: Rekayasa Perangkat Lunak">
                    @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Deskripsi</label>
                    <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('deskripsi') border-red-500 @enderror" 
                              id="deskripsi" name="deskripsi" rows="3"
                              placeholder="Deskripsi singkat tentang jurusan ini">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                     <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('jurusan.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-text-main dark:text-white font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Simpan Jurusan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
