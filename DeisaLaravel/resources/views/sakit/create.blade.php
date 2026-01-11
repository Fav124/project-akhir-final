@extends('layouts.app-tailwind')

@section('title', 'Catat Santri Sakit')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex items-center gap-6 py-4 animate-slide-in-down">
        <a href="{{ route('web.sakit.index') }}" class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-white shadow-xl shadow-gray-200/50 border border-gray-100 text-gray-400 hover:text-rose-500 hover:border-rose-100 transition-all duration-500 group">
            <svg class="w-8 h-8 transform group-hover:-translate-x-1.5 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight leading-none">Catat Santri Sakit</h1>
            <p class="text-gray-500 font-medium mt-2">Rekam detail kejadian dan penanganan medis santri.</p>
        </div>
    </div>

    <form action="{{ route('web.sakit.store') }}" method="POST" id="sakitForm" class="space-y-8 pb-20">
        @csrf
        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Data Kejadian -->
            <div class="space-y-6 animate-fade-in" style="animation-delay: 100ms">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-rose-500 flex items-center justify-center shadow-lg shadow-rose-200">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-black text-gray-800 uppercase tracking-tighter">Informasi Medis</h2>
                </div>

                <x-card variant="premium" title="Informasi Medis" subtitle="Detail kejadian & diagnosa">
                    <div class="space-y-5 p-2">
                        <div class="space-y-2">
                            <label for="santri_id" class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 flex items-center gap-1">Pilih Santri <span class="text-red-500">*</span></label>
                            <select name="santri_id" id="santri_id" class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-rose-100 focus:border-rose-400 transition-all outline-none font-bold text-gray-700 shadow-sm appearance-none" required>
                                <option value="">-- Pilih Santri --</option>
                                @foreach($santris as $s)
                                    <option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label for="tanggal_mulai_sakit" class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 flex items-center gap-1">Tgl Mulai Sakit <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_mulai_sakit" id="tanggal_mulai_sakit" value="{{ date('Y-m-d') }}" 
                                    class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-rose-100 focus:border-rose-400 transition-all outline-none font-bold text-gray-700 shadow-sm" required>
                            </div>
                            <div class="space-y-2">
                                <label for="status" class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 flex items-center gap-1">Status Penanganan <span class="text-red-500">*</span></label>
                                <select name="status" id="status" class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-rose-100 focus:border-rose-400 transition-all outline-none font-bold text-gray-700 shadow-sm appearance-none" required>
                                    <option value="Sakit">Di UKS</option>
                                    <option value="Pulang">Izin Pulang</option>
                                    <option value="Rawat Inap">Rawat Inap</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="tingkat_kondisi" class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Tingkat Keparahan</label>
                            <div class="grid grid-cols-3 gap-3">
                                @foreach(['Ringan', 'Sedang', 'Berat'] as $opt)
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="tingkat_kondisi" value="{{ $opt }}" class="peer sr-only" {{ $opt === 'Ringan' ? 'checked' : '' }}>
                                        <div class="px-4 py-3 text-center border border-gray-100 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all peer-checked:bg-rose-500 peer-checked:text-white peer-checked:border-rose-500 peer-checked:shadow-lg peer-checked:shadow-rose-200 text-gray-400 bg-gray-50/30">
                                            {{ $opt }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="keluhan" class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 flex items-center gap-1">Keluhan / Gejala <span class="text-red-500">*</span></label>
                            <textarea name="keluhan" id="keluhan" rows="3" placeholder="Sebutkan keluhan yang dirasakan..." 
                                class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-rose-100 focus:border-rose-400 transition-all outline-none font-bold text-gray-700 shadow-sm resize-none" required></textarea>
                            <input type="hidden" name="gejala" id="gejala_hidden">
                        </div>

                        <div class="space-y-2">
                            <label for="diagnosis" class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Hasil Diagnosa Awal</label>
                            <textarea name="diagnosis" id="diagnosis" rows="3" placeholder="Kesimpulan pemeriksaan awal..." 
                                class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-rose-100 focus:border-rose-400 transition-all outline-none font-bold text-gray-700 shadow-sm resize-none"></textarea>
                        </div>
                    </div>
                </x-card>
            </div>

            <!-- Penanganan -->
            <div class="space-y-6 animate-fade-in" style="animation-delay: 300ms">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center shadow-lg shadow-emerald-200">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86 .517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 01-.586 1.414l-2.828 2.828a2 2 0 01-1.414.586H8.586a2 2 0 01-1.414-.586L4.344 11.586A2 2 0 013.758 10.172V5L2 4h16"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-black text-gray-800 uppercase tracking-tighter">Penanganan & Obat</h2>
                </div>

                <x-card variant="premium" title="Informasi Medis" subtitle="Detail kejadian & diagnosa">
                    <div class="space-y-5 p-2">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Pilih Obat (Multi-select)</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($obats as $o)
                                    <label class="relative cursor-pointer group">
                                        <input type="checkbox" name="obat_ids[]" value="{{ $o->id }}" class="peer sr-only">
                                        <div class="p-4 rounded-2xl border border-gray-100 bg-gray-50/30 peer-checked:bg-emerald-500 peer-checked:text-white peer-checked:border-emerald-500 peer-checked:shadow-xl peer-checked:shadow-emerald-100 transition-all duration-300">
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1">
                                                    <p class="text-sm font-black tracking-tight leading-none mb-1">{{ $o->nama_obat }}</p>
                                                    <p class="text-[9px] font-bold uppercase opacity-60 tracking-wider">Stok: {{ $o->stok }} {{ $o->satuan }}</p>
                                                </div>
                                                <div class="w-5 h-5 rounded-full border-2 border-gray-200 peer-checked:border-white/50 flex items-center justify-center transition-all bg-white shadow-inner opacity-0 scale-50 group-hover:opacity-100 group-hover:scale-100">
                                                    <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            <p class="text-[9px] font-bold text-gray-400 italic">"Obat yang dipilih akan dikurangi stoknya sebanyak 1 unit per item secara otomatis."</p>
                        </div>

                        <div class="space-y-2">
                            <label for="tindakan" class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Tindakan / Instruksi Perawatan</label>
                            <textarea name="tindakan" id="tindakan" rows="5" placeholder="Pemberian kompres, istirahat total, atau rujukan dokter..." 
                                class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition-all outline-none font-bold text-gray-700 shadow-sm resize-none"></textarea>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>

        <!-- Sticky Footer -->
        <div class="fixed bottom-0 left-0 right-0 md:left-64 p-6 bg-white/80 backdrop-blur-3xl border-t border-gray-100 shadow-[0_-20px_50px_rgba(0,0,0,0.05)] flex items-center justify-center md:justify-end gap-3 z-50 animate-slide-in-up">
            <div class="max-w-6xl w-full flex items-center justify-end gap-3 mx-auto">
                <a href="{{ route('web.sakit.index') }}" class="px-8 py-4 rounded-2xl font-black text-gray-400 uppercase tracking-widest text-[10px] hover:bg-gray-50 transition-all">Batal & Kembali</a>
                <button type="submit" class="group px-10 py-4 rounded-2xl font-black text-white bg-gradient-to-r from-rose-500 to-red-600 shadow-2xl shadow-rose-200 hover:shadow-rose-300 transition-all duration-500 transform hover:-translate-y-1.5 active:scale-95 uppercase tracking-widest text-[10px] flex items-center gap-2">
                    <svg class="w-5 h-5 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Simpan Laporan Sakit
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('sakitForm').addEventListener('submit', function() {
        document.getElementById('gejala_hidden').value = document.getElementById('keluhan').value;
    });
</script>
@endsection
