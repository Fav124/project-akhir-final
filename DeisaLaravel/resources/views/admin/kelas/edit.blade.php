@extends('layouts.admin')

@section('title', 'Edit Kelas')

@section('header')
    <div class="space-y-1">
        <a href="{{ route('admin.kelas.show', $kelas->id) }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-deisa-blue">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Detail Kelas
        </a>
        <h2 class="text-lg font-bold text-slate-900 leading-tight">Edit Kelas {{ $kelas->nama_kelas ?: '-' }}</h2>
    </div>
@endsection

@section('admin-content')
    <div class="max-w-4xl mx-auto">
        <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/50 rounded-3xl">
            <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-deisa-blue">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Identitas Kelas</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenjang Pendidikan</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21a12.083 12.083 0 01-6.16-10.422L12 14z"></path></svg>
                                    </span>
                                    <select name="jenjang" required
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                                        <option value="">Pilih Jenjang</option>
                                        @foreach(['TK', 'SD', 'SMP', 'SMA', 'SMK', 'Kuliah'] as $j)
                                            <option value="{{ $j }}" {{ old('jenjang', $kelas->jenjang) == $j ? 'selected' : '' }}>{{ $j }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tingkat / Semester</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1 0v14m-7-7h14"></path></svg>
                                    </span>
                                    <input type="number" name="tingkat" value="{{ old('tingkat', $kelas->tingkat) }}" required min="1"
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                        placeholder="Contoh: 1, 7, atau 10">
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Kelas (Opsional)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path></svg>
                                    </span>
                                    <input type="text" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                        placeholder="Contoh: X IPA 1 (Biarkan kosong untuk otomatis)">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Relasi Jurusan & Tahun Ajaran</h4>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Jurusan (Bisa lebih dari satu)</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 p-3 border border-slate-200 rounded-xl bg-slate-50 max-h-44 overflow-y-auto">
                                @foreach($jurusans as $jurusan)
                                    <label class="flex items-center space-x-2 text-sm text-slate-700 cursor-pointer hover:bg-white p-2 rounded-lg transition-colors">
                                        <input type="checkbox" name="jurusan_ids[]" value="{{ $jurusan->id }}"
                                            {{ in_array($jurusan->id, old('jurusan_ids', $kelas->jurusans->pluck('id')->toArray())) ? 'checked' : '' }}
                                            class="rounded border-slate-300 text-deisa-blue focus:ring-deisa-blue">
                                        <span>{{ $jurusan->nama_jurusan }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tahun Ajaran</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </span>
                                <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $kelas->tahun_ajaran) }}"
                                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                    placeholder="Contoh: 2026/2027">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-2">
                    <x-button variant="outline" type="button" href="{{ route('admin.kelas.show', $kelas->id) }}"
                        class="rounded-2xl px-8 font-bold border-slate-200">Batal</x-button>
                    <x-button type="submit" class="rounded-2xl px-8 font-black shadow-lg shadow-blue-500/20">Simpan Perubahan</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
