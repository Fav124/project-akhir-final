<div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-white">
    <h3 class="font-bold text-slate-900" id="modal-title">{{ isset($record) ? 'Edit Laporan Sakit' : 'Tambah Laporan Sakit' }}</h3>
    <button data-modal-close class="text-slate-400 hover:text-slate-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

<form id="sakit-form"
    action="{{ isset($record) ? route('admin.sakit.update', $record->id) : route('admin.sakit.store') }}" method="POST"
    data-ajax="true" class="bg-white">
    @csrf
    @if(isset($record))
        @method('PUT')
    @endif

    <div class="p-6 space-y-6 max-h-[75vh] overflow-y-auto">
        <div class="space-y-4">
            <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-deisa-blue">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586"></path>
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
                            <option value="{{ $s->id }}" {{ (isset($record) && $record->santri_id == $s->id) ? 'selected' : '' }}>
                                {{ $s->nis }} - {{ $s->nama_lengkap }} ({{ $s->kelas->nama_kelas ?? 'Tanpa Kelas' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Masuk</label>
                    <input type="date" name="tgl_masuk"
                        value="{{ isset($record) ? $record->tgl_masuk->format('Y-m-d') : date('Y-m-d') }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Diagnosis Utama</label>
                <input type="text" name="diagnosis_utama" value="{{ $record->diagnosis_utama ?? '' }}" list="diagnosis-list"
                    required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                    placeholder="Pilih atau ketik diagnosa...">
                <datalist id="diagnosis-list">
                    @foreach($diagnoses as $diag)
                        <option value="{{ $diag->nama_diagnosis }}">
                    @endforeach
                </datalist>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Gejala</label>
                    <textarea name="gejala" rows="2"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                        placeholder="Suhu 38C, pusing...">{{ $record->gejala ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tindakan</label>
                    <textarea name="tindakan" rows="2"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                        placeholder="Kompres air hangat, istirahat...">{{ $record->tindakan ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 21a6.5 6.5 0 009.19-9.19l-6-6a6.5 6.5 0 00-9.19 9.19l6 6z"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Pemakaian Obat</h4>
                </div>

                <button type="button" id="add-obat-row"
                    class="text-[10px] bg-emerald-600 text-white px-2.5 py-1 rounded-lg hover:bg-emerald-700 transition-all">+ Tambah Obat</button>
            </div>

            <div class="bg-emerald-50/50 p-4 rounded-xl border border-emerald-100">
                <div id="obat-rows-container" class="space-y-2">
                    @if(isset($record) && $record->obats->count() > 0)
                        @foreach($record->obats as $o)
                            <div class="flex gap-2 obat-row">
                                <select name="obat_ids[]" class="flex-1 px-3 py-2 rounded-lg border border-slate-300 text-xs">
                                    <option value="">Pilih Obat</option>
                                    @foreach($obats as $opt)
                                        <option value="{{ $opt->id }}" {{ $o->id == $opt->id ? 'selected' : '' }}>{{ $opt->nama_obat }}
                                            (Stok: {{ $opt->stok }})</option>
                                    @endforeach
                                </select>
                                <input type="number" name="obat_jumlahs[]" value="{{ $o->pivot->jumlah }}" placeholder="Jml"
                                    class="w-20 px-3 py-2 rounded-lg border border-slate-300 text-xs">
                                <button type="button" class="remove-obat-row p-2 text-red-500 hover:bg-red-50 rounded">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>

                <template id="obat-row-template">
                    <div class="flex gap-2 obat-row animate-in fade-in slide-in-from-top-1">
                        <select name="obat_ids[]" class="flex-1 px-3 py-2 rounded-lg border border-slate-300 text-xs shadow-sm">
                            <option value="">Pilih Obat</option>
                            @foreach($obats as $opt)
                                <option value="{{ $opt->id }}">{{ $opt->nama_obat }} (Stok: {{ $opt->stok }})</option>
                            @endforeach
                        </select>
                        <input type="number" name="obat_jumlahs[]" value="1" placeholder="Jml"
                            class="w-20 px-3 py-2 rounded-lg border border-slate-300 text-xs shadow-sm">
                        <button type="button" class="remove-obat-row p-2 text-red-500 hover:bg-red-50 rounded transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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
                        <option value="Sakit" {{ (isset($record) && $record->status == 'Sakit') ? 'selected' : '' }}>Sakit (Di UKS)</option>
                        <option value="Pulang" {{ (isset($record) && $record->status == 'Pulang') ? 'selected' : '' }}>Pulang (Rawat Jalan)</option>
                        <option value="Sembuh" {{ (isset($record) && $record->status == 'Sembuh') ? 'selected' : '' }}>Sembuh</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenis Perawatan</label>
                    <select name="jenis_perawatan" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                        <option value="UKS" {{ (isset($record) && $record->jenis_perawatan == 'UKS') ? 'selected' : '' }}>UKS</option>
                        <option value="Rumah Sakit" {{ (isset($record) && $record->jenis_perawatan == 'Rumah Sakit') ? 'selected' : '' }}>Dirujuk ke RS</option>
                        <option value="Pulang" {{ (isset($record) && $record->jenis_perawatan == 'Pulang') ? 'selected' : '' }}>Pulang ke Rumah</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tujuan Rujukan (Opsional)</label>
                    <input type="text" name="tujuan_rujukan" value="{{ $record->tujuan_rujukan ?? '' }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                        placeholder="Contoh: RSUD Kota">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Alasan Dipulangkan</label>
                    <input type="text" name="alasan_pulang" value="{{ $record->alasan_pulang ?? '' }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                        placeholder="Contoh: Observasi lanjutan di rumah">
                </div>
            </div>
        </div>
    </div>

    <div class="px-6 py-4 bg-white border-t border-slate-100 flex justify-end gap-2">
        <button type="button" data-modal-close
            class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
        <x-button type="submit" class="shadow-lg shadow-blue-500/20">Simpan Laporan</x-button>
    </div>
</form>
