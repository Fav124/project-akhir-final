@extends('layouts.app-tailwind')

@section('title', 'Edit Diagnosis')
@section('subtitle', 'Update diagnosis details')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 sm:p-8">
        <form action="{{ route('web.diagnosis.update', $diagnosis->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-1">
                <label for="nama_diagnosis" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Diagnosis Name</label>
                <div class="relative">
                     <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <span class="material-symbols-outlined text-[20px]">stethoscope</span>
                    </span>
                    <input type="text" name="nama_diagnosis" id="nama_diagnosis" class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow" placeholder="e.g. Demam Berdarah" value="{{ old('nama_diagnosis', $diagnosis->nama_diagnosis) }}" required>
                </div>
                @error('nama_diagnosis')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label for="kategori" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Category</label>
                <div class="relative">
                     <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <span class="material-symbols-outlined text-[20px]">category</span>
                    </span>
                    <select name="kategori" id="kategori" class="block w-full pl-10 pr-10 py-2.5 border border-slate-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow appearance-none" required>
                        <option value="Ringan" {{ old('kategori', $diagnosis->kategori) == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                        <option value="Sedang" {{ old('kategori', $diagnosis->kategori) == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="Berat" {{ old('kategori', $diagnosis->kategori) == 'Berat' ? 'selected' : '' }}>Berat</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                         <span class="material-symbols-outlined text-slate-500">expand_more</span>
                    </div>
                </div>
                @error('kategori')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('web.diagnosis.index') }}" class="px-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium shadow-lg shadow-blue-500/20 transition-all transform hover:-translate-y-0.5">
                    Update Diagnosis
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
