@extends('layouts.app')

@section('title', 'Tambah Obat')

@section('content')
    <div class="min-h-screen bg-slate-50  py-8 ">
        <div class="max-w-3xl mx-auto px-6">
            <div class="mb-8">
                <h1 class="text-2xl font-black text-slate-800 ">Tambah Obat Baru</h1>
                <p class="text-sm text-slate-500 ">Masukkan data obat ke sistem</p>
            </div>

            <div
                class="bg-white  rounded-2xl border border-slate-100  p-8 ">
                <form action="{{ route('staff.obat.store') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700  mb-2">Nama Obat</label>
                            <input type="text" name="nama_obat" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200  bg-white  text-slate-800  focus:ring-2 focus:ring-deisa-blue focus:border-transparent transition-colors"
                                value="{{ old('nama_obat') }}">
                            @error('nama_obat')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700  mb-2">Jenis</label>
                            <input type="text" name="jenis" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200  bg-white  text-slate-800  focus:ring-2 focus:ring-deisa-blue focus:border-transparent transition-colors"
                                value="{{ old('jenis') }}" placeholder="Tablet, Sirup, Kapsul, dll">
                            @error('jenis')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700  mb-2">Stok</label>
                                <input type="number" name="stok" required min="0"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200  bg-white  text-slate-800  focus:ring-2 focus:ring-deisa-blue focus:border-transparent transition-colors"
                                    value="{{ old('stok') }}">
                                @error('stok')
                                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-bold text-slate-700  mb-2">Satuan</label>
                                <input type="text" name="satuan" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200  bg-white  text-slate-800  focus:ring-2 focus:ring-deisa-blue focus:border-transparent transition-colors"
                                    value="{{ old('satuan') }}" placeholder="Butir, ml, box, dll">
                                @error('satuan')
                                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700  mb-2">Keterangan
                                (Opsional)</label>
                            <textarea name="keterangan" rows="3"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200  bg-white  text-slate-800  focus:ring-2 focus:ring-deisa-blue focus:border-transparent transition-colors">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-8">
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-deisa-blue hover:bg-blue-700 text-white rounded-xl font-bold transition-colors">
                            Simpan Obat
                        </button>
                        <a href="{{ route('staff.obat.index') }}"
                            class="px-6 py-3 bg-slate-100  hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700  rounded-xl font-bold transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection