<div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
    <h3 class="font-bold text-slate-900">Detail Laporan Sakit</h3>
    <button data-modal-close class="text-slate-400 hover:text-slate-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

<div class="p-6 space-y-6 max-h-[80vh] overflow-y-auto">
    <!-- Header Section -->
    <div class="flex items-center gap-4 bg-blue-50 p-4 rounded-2xl border border-blue-100">
        <div
            class="w-14 h-14 rounded-full bg-deisa-blue flex items-center justify-center text-white text-2xl font-bold shadow-lg shadow-blue-200">
            {{ $record->santri ? substr($record->santri->nama_lengkap, 0, 1) : '?' }}
        </div>
        <div class="flex-1">
            <div class="font-bold text-slate-900 text-lg">
                {{ $record->santri->nama_lengkap ?? 'Santri Tidak Ditemukan' }}</div>
            <div class="text-xs text-slate-500 flex items-center gap-2 mt-0.5">
                <span
                    class="bg-blue-100 text-deisa-blue px-2 py-0.5 rounded font-bold uppercase">{{ ($record->santri && $record->santri->kelas) ? $record->santri->kelas->nama_kelas : '-' }}</span>
                <span>•</span>
                <span>{{ $record->tgl_masuk ? $record->tgl_masuk->format('d M Y') : '-' }}</span>
            </div>
        </div>
        <div class="text-right">
            @php
                $statusColors = [
                    'Sakit' => 'bg-amber-100 text-amber-700 border-amber-200',
                    'Pulang' => 'bg-blue-100 text-blue-700 border-blue-200',
                    'Sembuh' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                ];
                $color = $statusColors[$record->status] ?? 'bg-slate-100 text-slate-600';
            @endphp
            <div class="px-3 py-1 rounded-full text-[10px] font-bold uppercase border {{ $color }} mb-1 inline-block">
                {{ $record->status }}
            </div>
            <div class="text-[10px] text-slate-400 font-medium">{{ $record->jenis_perawatan }}</div>
        </div>
    </div>

    <!-- Info Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-4">
            <div>
                <label class="text-slate-400 uppercase text-[10px] font-bold tracking-wider">Diagnosis Utama</label>
                <div class="text-sm text-slate-900 mt-1 font-bold">{{ $record->diagnosis_utama }}</div>
            </div>
            <div>
                <label class="text-slate-400 uppercase text-[10px] font-bold tracking-wider">Gejala / Keluhan</label>
                <div class="text-sm text-slate-700 mt-1 italic">{{ $record->gejala ?: '-' }}</div>
            </div>
            <div>
                <label class="text-slate-400 uppercase text-[10px] font-bold tracking-wider">Tindakan</label>
                <div class="text-sm text-slate-700 mt-1">{{ $record->tindakan ?: '-' }}</div>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <label class="text-slate-400 uppercase text-[10px] font-bold tracking-wider">Pemakaian Obat</label>
                <div class="mt-2 space-y-1.5">
                    @forelse($record->obats as $o)
                        <div
                            class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded-lg border border-slate-100">
                            <span class="font-medium text-slate-700">{{ $o->nama_obat }}</span>
                            <span
                                class="bg-white px-2 py-0.5 rounded border border-slate-200 font-bold text-deisa-blue">{{ $o->pivot->jumlah }}
                                {{ $o->pivot->satuan }}</span>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic">Tidak ada pemakaian obat yang dicatat.</div>
                    @endforelse
                </div>
            </div>
            <div>
                <label class="text-slate-400 uppercase text-[10px] font-bold tracking-wider">Catatan Tambahan</label>
                <div class="text-sm text-slate-600 mt-1 bg-amber-50/50 p-3 rounded-xl border border-amber-100 italic">
                    {{ $record->catatan ?: 'Tidak ada catatan.' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Guardian Info (Important for Pulang status) -->
    @if($record->santri->wali)
        <div class="pt-6 border-t border-slate-100">
            <h4 class="text-xs font-bold text-slate-900 uppercase mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Kontak Wali (Emergency)
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                <div>
                    <div class="text-[10px] text-slate-400 font-bold uppercase">Nama Wali</div>
                    <div class="text-sm font-medium text-slate-900">{{ $record->santri->wali->nama_wali }}</div>
                </div>
                <div>
                    <div class="text-[10px] text-slate-400 font-bold uppercase">Hubungan</div>
                    <div class="text-sm font-medium text-slate-900">{{ ucfirst($record->santri->wali->hubungan) }}</div>
                </div>
                <div>
                    <div class="text-[10px] text-slate-400 font-bold uppercase">No. HP / WhatsApp</div>
                    <div class="text-sm font-bold text-emerald-600">{{ $record->santri->wali->no_hp }}</div>
                </div>
            </div>
        </div>
    @endif

    @if($record->tgl_sembuh)
        <div
            class="pt-4 border-t border-slate-100 flex items-center gap-2 text-emerald-600 text-sm font-bold bg-emerald-50/50 p-4 rounded-xl border border-emerald-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Sembuh pada {{ $record->tgl_sembuh->format('d M Y H:i') }}
        </div>
    @endif
</div>

<div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
    <button type="button" onclick="document.getElementById('global-detail-modal').classList.add('hidden')"
        class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-lg transition-colors border border-slate-200">Tutup</button>
    <x-button variant="primary" data-form-url="{{ route('admin.sakit.edit', $record->id) }}"
        onclick="document.getElementById('global-detail-modal').classList.add('hidden')">Edit Laporan</x-button>
</div>