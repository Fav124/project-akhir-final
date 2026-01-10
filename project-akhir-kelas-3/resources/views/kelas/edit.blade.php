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
                        <a href="{{ route('kelas.index') }}" class="text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white">Data Kelas</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-text-muted text-lg mx-1">chevron_right</span>
                        <span class="text-sm font-medium text-text-main dark:text-gray-200">Edit Kelas</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-3xl font-bold text-text-main dark:text-white">Edit Data Kelas</h1>
        <p class="text-text-muted dark:text-gray-400 mt-1">Perbarui informasi kelas.</p>
    </div>

    <!-- FORM CARD -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 max-w-2xl">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
            <div class="p-2 bg-primary/10 rounded-lg text-primary">
                <span class="material-symbols-outlined">edit_square</span>
            </div>
            <h2 class="text-lg font-bold text-text-main dark:text-white">Form Edit Kelas</h2>
        </div>

        <form method="POST" action="{{ route('kelas.update', $kela->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- NAMA KELAS -->
            <div>
                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">
                    Nama Kelas <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-text-muted">
                        <span class="material-symbols-outlined text-lg" style="color: #64748b;">home</span>
                    </span>
                    <input type="text"
                        class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white placeholder:text-text-muted focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors @error('nama_kelas') border-red-500 ring-2 ring-red-500 @enderror"
                        id="nama_kelas" placeholder="Contoh: Kelas 10-A" name="nama_kelas"
                        value="{{ old('nama_kelas', $kela->nama_kelas) }}" required />
                </div>
                @error('nama_kelas')
                    <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                        <span class="material-symbols-outlined text-lg">error</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- JURUSAN SELECTION (Many-to-Many) -->
            <div>
                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-3">
                    Jurusan / Peminatan
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-800">
                    @foreach($jurusans as $j)
                        <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800 cursor-pointer hover:border-primary/50 transition-all group">
                            <input type="checkbox" name="jurusans[]" value="{{ $j->id }}" 
                                {{ in_array($j->id, old('jurusans', $kela->jurusans->pluck('id')->toArray())) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-text-main dark:text-gray-200 group-hover:text-primary transition-colors">{{ $j->nama }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                <p class="text-xs text-text-muted mt-2">Pilih satu atau lebih jurusan yang tersedia untuk kelas ini.</p>
            </div>

            <!-- BUTTON -->
            <div class="flex gap-3 pt-4">
                <a href="{{ route('kelas.index') }}"
                    class="flex-1 px-4 py-3 border border-gray-200 dark:border-gray-700 text-text-main dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Batal
                </a>
                <button type="submit"
                    class="flex-1 px-4 py-3 bg-primary hover:bg-green-600 text-text-main font-medium rounded-lg transition-colors flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
