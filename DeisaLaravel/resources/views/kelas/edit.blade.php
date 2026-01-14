@extends('layouts.app-tailwind')

@section('title', 'Edit Kelas')
@section('subtitle', 'Update existing student class')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 sm:p-8">
        <form action="{{ route('web.kelas.update', $kelas->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-1">
                <label for="nama_kelas" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Nama Kelas</label>
                <div class="relative">
                     <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <span class="material-symbols-outlined text-[20px]">class</span>
                    </span>
                    <input type="text" name="nama_kelas" id="nama_kelas" class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow" placeholder="e.g. X - IPA" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                </div>
                @error('nama_kelas')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('web.kelas.index') }}" class="px-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium shadow-lg shadow-blue-500/20 transition-all transform hover:-translate-y-0.5">
                    Update Kelas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
