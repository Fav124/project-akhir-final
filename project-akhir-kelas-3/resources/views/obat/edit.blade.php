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
                        <a href="{{ route('obat.index') }}" class="text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white">Data Obat</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-text-muted text-lg mx-1">chevron_right</span>
                        <span class="text-sm font-medium text-text-main dark:text-gray-200">Edit Obat</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-3xl font-bold text-text-main dark:text-white">Edit Data Obat</h1>
        <p class="text-text-muted dark:text-gray-400 mt-1">Perbarui informasi obat dan stok.</p>
    </div>

    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-6 max-w-3xl">
        <form method="POST" action="{{ route('obat.update', $obat->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Foto Obat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Foto Obat</label>
                    <div class="flex items-center gap-4">
                        <div class="w-24 h-24 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-700">
                            @if($obat->foto)
                                <img src="{{ asset('storage/' . $obat->foto) }}" alt="{{ $obat->nama_obat }}" class="w-full h-full object-cover" id="previewFoto">
                            @else
                                <span class="material-symbols-outlined text-gray-400 text-4xl" id="previewPlaceholder">medication</span>
                                <img src="" alt="Preview" class="w-full h-full object-cover hidden" id="previewFoto">
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" name="foto" id="fotoInput" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-green-600 transition-all">
                            <p class="text-xs text-text-muted mt-2">Format: JPG, PNG, WEBP. Maks: 5MB.</p>
                        </div>
                    </div>
                    @error('foto')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Nama Obat</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <span class="material-symbols-outlined text-lg">medication</span>
                        </span>
                        <input type="text" class="w-full pl-10 pr-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('nama_obat') border-red-500 @enderror" 
                               placeholder="Contoh: Paracetamol" name="nama_obat"
                               value="{{ old('nama_obat', $obat->nama_obat) }}" required>
                    </div>
                    @error('nama_obat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Deskripsi</label>
                    <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('deskripsi') border-red-500 @enderror" 
                               rows="2" placeholder="Deskripsi obat" name="deskripsi">{{ old('deskripsi', $obat->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Stok Saat Ini</label>
                    <input type="number" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('stok') border-red-500 @enderror" 
                           placeholder="0" name="stok" min="0" value="{{ old('stok', $obat->stok) }}" required>
                    @error('stok')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Satuan</label>
                    <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('satuan') border-red-500 @enderror" name="satuan" required>
                        <option selected disabled>-- Pilih Satuan --</option>
                        @foreach(['Tablet', 'Kapsul', 'Botol', 'Strip', 'Box', 'Pcs', 'Ampul', 'Tube'] as $s)
                            <option value="{{ $s }}" {{ old('satuan', $obat->satuan) == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Stok Minimum</label>
                    <input type="number" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" placeholder="10" min="0" name="stok_minimum" value="{{ old('stok_minimum', $obat->stok_minimum) }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Harga Satuan (Rp)</label>
                    <input type="number" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" placeholder="5000" min="0" name="harga_satuan" value="{{ old('harga_satuan', $obat->harga_satuan) }}">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tanggal Kadaluarsa</label>
                    <input type="date" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa', $obat->tanggal_kadaluarsa ? $obat->tanggal_kadaluarsa->format('Y-m-d') : '') }}">
                </div>
            </div>

            <div class="flex gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('obat.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-text-main dark:text-white font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-primary hover:bg-green-600 text-white font-bold rounded-lg transition-all shadow-lg shadow-primary/20 flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <script>
            document.getElementById('fotoInput').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const preview = document.getElementById('previewFoto');
                        const placeholder = document.getElementById('previewPlaceholder');
                        preview.src = event.target.result;
                        preview.classList.remove('hidden');
                        if (placeholder) placeholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    </div>
</div>
@endsection
