<div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
    <h3 class="font-bold text-slate-900">{{ isset($record) ? 'Edit Laporan Sakit' : 'Tambah Laporan Sakit' }}</h3>
    <button data-modal-close class="text-slate-400 hover:text-slate-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

<form id="sakit-form"
    action="{{ isset($record) ? route('admin.sakit.update', $record->id) : route('admin.sakit.store') }}" method="POST"
    data-ajax="true">
    @csrf
    @if(isset($record))
        @method('PUT')
    @endif

    <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Santri Selection -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Santri</label>
                <select name="santri_id" required
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                    <option value="">Pilih Santri</option>
                    @foreach($santris as $s)
                        <option value="{{ $s->id }}" {{ (isset($record) && $record->santri_id == $s->id) ? 'selected' : '' }}>
                            {{ $s->nis }} - {{ $s->nama_lengkap }} ({{ $s->kelas->nama_kelas ?? 'Tanpa Kelas' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Masuk</label>
                <input type="date" name="tgl_masuk"
                    value="{{ isset($record) ? $record->tgl_masuk->format('Y-m-d') : date('Y-m-d') }}" required
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Diagnosis Utama</label>
            <input type="text" name="diagnosis_utama" value="{{ $record->diagnosis_utama ?? '' }}" required
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                placeholder="Contoh: Demam, Batuk Pilek, dsb.">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Gejala</label>
                <textarea name="gejala" rows="2"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                    placeholder="Suhu 38C, pusing...">{{ $record->gejala ?? '' }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tindakan</label>
                <textarea name="tindakan" rows="2"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                    placeholder="Kompres air hangat, istirahat...">{{ $record->tindakan ?? '' }}</textarea>
            </div>
        </div>

        <!-- Medicine Usage Section -->
        <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100">
            <h4 class="text-xs font-bold text-blue-800 uppercase mb-3 flex items-center justify-between">
                Pemakaian Obat
                <button type="button" id="add-obat-row"
                    class="text-[10px] bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700 transition-all">+
                    Tambah Obat</button>
            </h4>
            <div id="obat-rows-container" class="space-y-2">
                @if(isset($record) && $record->obats->count() > 0)
                    @foreach($record->obats as $o)
                        <div class="flex gap-2 obat-row">
                            <select name="obat_ids[]" class="flex-1 px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                <option value="">Pilih Obat</option>
                                @foreach($obats as $opt)
                                    <option value="{{ $opt->id }}" {{ $o->id == $opt->id ? 'selected' : '' }}>{{ $opt->nama_obat }}
                                        (Stok: {{ $opt->stok }})</option>
                                @endforeach
                            </select>
                            <input type="number" name="obat_jumlahs[]" value="{{ $o->pivot->jumlah }}" placeholder="Jml"
                                class="w-16 px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                            <button type="button" class="remove-obat-row p-1 text-red-500 hover:bg-red-50 rounded"><svg
                                    class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M6 18L18 6M6 6l12 12" />
                                </svg></button>
                        </div>
                    @endforeach
                @endif
            </div>
            <template id="obat-row-template">
                <div class="flex gap-2 obat-row animate-in fade-in slide-in-from-top-1">
                    <select name="obat_ids[]"
                        class="flex-1 px-3 py-1.5 rounded-lg border border-slate-300 text-xs shadow-sm">
                        <option value="">Pilih Obat</option>
                        @foreach($obats as $opt)
                            <option value="{{ $opt->id }}">{{ $opt->nama_obat }} (Stok: {{ $opt->stok }})</option>
                        @endforeach
                    </select>
                    <input type="number" name="obat_jumlahs[]" value="1" placeholder="Jml"
                        class="w-16 px-3 py-1.5 rounded-lg border border-slate-300 text-xs shadow-sm">
                    <button type="button"
                        class="remove-obat-row p-1 text-red-500 hover:bg-red-50 rounded transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Status</label>
                <select name="status" required
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                    <option value="Sakit" {{ (isset($record) && $record->status == 'Sakit') ? 'selected' : '' }}>Sakit (Di
                        UKS)</option>
                    <option value="Pulang" {{ (isset($record) && $record->status == 'Pulang') ? 'selected' : '' }}>Pulang
                        (Rawat Jalan)</option>
                    <option value="Sembuh" {{ (isset($record) && $record->status == 'Sembuh') ? 'selected' : '' }}>Sembuh
                    </option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenis Perawatan</label>
                <select name="jenis_perawatan" required
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                    <option value="UKS" {{ (isset($record) && $record->jenis_perawatan == 'UKS') ? 'selected' : '' }}>UKS
                    </option>
                    <option value="Rumah Sakit" {{ (isset($record) && $record->jenis_perawatan == 'Rumah Sakit') ? 'selected' : '' }}>Dirujuk ke RS</option>
                    <option value="Pulang" {{ (isset($record) && $record->jenis_perawatan == 'Pulang') ? 'selected' : '' }}>Pulang ke Rumah</option>
                </select>
            </div>
        </div>
    </div>

    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
        <button type="button" data-modal-close
            class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
        <x-button type="submit" class="shadow-lg shadow-blue-500/20">Simpan Laporan</x-button>
    </div>
</form>