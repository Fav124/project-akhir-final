@extends('layouts.admin')

@section('title', 'Tambah Laporan Sakit')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.sakit.index') }}" class="text-slate-500 hover:text-slate-700 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h2 class="text-xl font-bold text-slate-900">Tambah Laporan Sakit</h2>
    </div>
@endsection

@section('admin-content')
    <div class="max-w-5xl mx-auto">
        <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/50 rounded-3xl">
            <form id="sakit-form" action="{{ route('admin.sakit.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="p-6 space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-deisa-blue">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Informasi Pemeriksaan</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Santri</label>
                                <select name="santri_id" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                                    <option value="">Pilih Santri</option>
                                    @foreach($santris as $s)
                                        <option value="{{ $s->id }}" {{ old('santri_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->nis }} - {{ $s->nama_lengkap }} ({{ $s->kelas->nama_kelas ?? 'Tanpa Kelas' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Masuk</label>
                                <input type="date" name="tgl_masuk" value="{{ old('tgl_masuk', date('Y-m-d')) }}" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Diagnosis Utama</label>
                            <input type="text" name="diagnosis_utama" value="{{ old('diagnosis_utama') }}" list="diagnosis-list"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                placeholder="Pilih atau ketik diagnosa...">
                            <datalist id="diagnosis-list">
                                @foreach($diagnoses as $diag)
                                    <option value="{{ $diag->nama_diagnosis }}"></option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Gejala</label>
                                <textarea name="gejala" rows="2"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                    placeholder="Suhu 38C, pusing...">{{ old('gejala') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tindakan</label>
                                <textarea name="tindakan" rows="2"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                    placeholder="Kompres air hangat, istirahat...">{{ old('tindakan') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.5 21a6.5 6.5 0 009.19-9.19l-6-6a6.5 6.5 0 00-9.19 9.19l6 6z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Pemakaian Obat</h4>
                            </div>

                            <button type="button" id="add-obat-row"
                                class="text-[10px] bg-emerald-600 text-white px-2.5 py-1 rounded-lg hover:bg-emerald-700 transition-all">
                                + Tambah Obat
                            </button>
                        </div>

                        <div class="bg-emerald-50/50 p-4 rounded-xl border border-emerald-100">
                            <div id="obat-rows-container" class="space-y-2">
                                @if(is_array(old('obat_ids')))
                                    @foreach(old('obat_ids') as $index => $oldObatId)
                                        <div class="flex gap-2 obat-row">
                                            <select name="obat_ids[]" class="flex-1 px-3 py-2 rounded-lg border border-slate-300 text-xs">
                                                <option value="">Pilih Obat</option>
                                                @foreach($obats as $opt)
                                                    <option value="{{ $opt->id }}" {{ (string) $oldObatId === (string) $opt->id ? 'selected' : '' }}>
                                                        {{ $opt->nama_obat }} (Stok: {{ $opt->stok }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="number" name="obat_jumlahs[]" value="{{ old('obat_jumlahs.' . $index, 1) }}"
                                                placeholder="Jml" class="w-20 px-3 py-2 rounded-lg border border-slate-300 text-xs">
                                            <button type="button" class="remove-obat-row p-2 text-red-500 hover:bg-red-50 rounded">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <template id="obat-row-template">
                                <div class="flex gap-2 obat-row">
                                    <select name="obat_ids[]" class="flex-1 px-3 py-2 rounded-lg border border-slate-300 text-xs">
                                        <option value="">Pilih Obat</option>
                                        @foreach($obats as $opt)
                                            <option value="{{ $opt->id }}">{{ $opt->nama_obat }} (Stok: {{ $opt->stok }})</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="obat_jumlahs[]" value="1" placeholder="Jml"
                                        class="w-20 px-3 py-2 rounded-lg border border-slate-300 text-xs">
                                    <button type="button" class="remove-obat-row p-2 text-red-500 hover:bg-red-50 rounded">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Status Perawatan</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Status</label>
                                <select name="status" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                                    <option value="Sakit" {{ old('status', 'Sakit') == 'Sakit' ? 'selected' : '' }}>Sakit (Di UKS)</option>
                                    <option value="Pulang" {{ old('status') == 'Pulang' ? 'selected' : '' }}>Pulang (Rawat Jalan)</option>
                                    <option value="Sembuh" {{ old('status') == 'Sembuh' ? 'selected' : '' }}>Sembuh</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenis Perawatan</label>
                                <select name="jenis_perawatan" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                                    <option value="UKS" {{ old('jenis_perawatan', 'UKS') == 'UKS' ? 'selected' : '' }}>UKS</option>
                                    <option value="Rumah Sakit" {{ old('jenis_perawatan') == 'Rumah Sakit' ? 'selected' : '' }}>
                                        Dirujuk ke RS
                                    </option>
                                    <option value="Pulang" {{ old('jenis_perawatan') == 'Pulang' ? 'selected' : '' }}>Pulang ke Rumah
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tujuan Rujukan (Opsional)</label>
                            <input type="text" name="tujuan_rujukan" value="{{ old('tujuan_rujukan') }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                placeholder="Contoh: RSUD Kota">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Alasan Dipulangkan</label>
                            <input type="text" name="alasan_pulang" value="{{ old('alasan_pulang') }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                placeholder="Contoh: Observasi lanjutan di rumah / rawat jalan">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Catatan</label>
                            <textarea name="catatan" rows="2"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-2">
                    <x-button variant="outline" type="button" href="{{ route('admin.sakit.index') }}"
                        class="rounded-2xl px-8 font-bold border-slate-200">Batal</x-button>
                    <x-button type="submit" class="rounded-2xl px-8 font-black shadow-lg shadow-blue-500/20">
                        Simpan Laporan
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('sakit-form');
        if (!form) return;

        const container = form.querySelector('#obat-rows-container');
        const template = form.querySelector('#obat-row-template');
        const addButton = form.querySelector('#add-obat-row');

        if (!container || !template || !addButton) return;

        addButton.addEventListener('click', function() {
            const clone = template.content.cloneNode(true);
            container.appendChild(clone);
        });

        container.addEventListener('click', function(e) {
            const removeButton = e.target.closest('.remove-obat-row');
            if (!removeButton) return;
            const row = removeButton.closest('.obat-row');
            if (row) row.remove();
        });
    });
</script>
@endpush
