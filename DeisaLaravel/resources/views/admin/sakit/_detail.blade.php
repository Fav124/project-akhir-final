<div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
    <h3 class="font-bold text-slate-900">Detail Laporan Sakit</h3>
    <button data-modal-close class="text-slate-400 hover:text-slate-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

<div class="p-6 space-y-8 max-h-[80vh] overflow-y-auto">
    <!-- Header Section -->
    <div class="flex items-center gap-5 bg-gradient-to-br from-blue-50 to-white p-5 rounded-2xl border border-blue-100 shadow-sm">
        <div
            class="w-16 h-16 rounded-full bg-deisa-blue flex items-center justify-center text-white text-3xl font-bold shadow-lg shadow-blue-200 ring-4 ring-white">
            {{ $record->santri ? substr($record->santri->nama_lengkap, 0, 1) : '?' }}
        </div>
        <div class="flex-1">
            <div class="font-extrabold text-slate-900 text-xl tracking-tight">
                {{ $record->santri->nama_lengkap ?? 'Santri Tidak Ditemukan' }}</div>
            <div class="text-sm text-slate-500 flex items-center gap-3 mt-1">
                <span
                    class="bg-blue-100 text-deisa-blue px-2.5 py-0.5 rounded-md font-bold text-[10px] uppercase tracking-wider">{{ ($record->santri && $record->santri->kelas) ? $record->santri->kelas->nama_kelas : '-' }}</span>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <span class="font-medium flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ $record->tgl_masuk ? $record->tgl_masuk->format('d M Y') : '-' }}
                </span>
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
            <div class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase border-2 shadow-sm {{ $color }} mb-1.5 inline-block">
                {{ $record->status }}
            </div>
            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $record->jenis_perawatan }}</div>
        </div>
    </div>

    @if($record->tgl_pulang || $record->tgl_kembali || $record->alasan_pulang)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                <div class="text-[10px] uppercase tracking-widest text-blue-600 font-black mb-1">Waktu Pulang</div>
                <div class="text-sm font-bold text-slate-800">
                    {{ $record->tgl_pulang ? $record->tgl_pulang->format('d M Y H:i') : '-' }}
                </div>
            </div>
            <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4">
                <div class="text-[10px] uppercase tracking-widest text-emerald-600 font-black mb-1">Waktu Kembali</div>
                <div class="text-sm font-bold text-slate-800">
                    {{ $record->tgl_kembali ? $record->tgl_kembali->format('d M Y H:i') : '-' }}
                </div>
            </div>
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                <div class="text-[10px] uppercase tracking-widest text-slate-500 font-black mb-1">Alasan Dipulangkan</div>
                <div class="text-sm font-medium text-slate-700">
                    {{ $record->alasan_pulang ?: '-' }}
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Medical Condition Section -->
        <div class="lg:col-span-7 space-y-6">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Kondisi Medis</h4>
            </div>

            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 space-y-5">
                <div>
                    <label class="text-slate-400 uppercase text-[9px] font-black tracking-widest block mb-1">Diagnosis Utama</label>
                    <div class="text-base text-slate-900 font-bold leading-tight">{{ $record->diagnosis_utama }}</div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-slate-400 uppercase text-[9px] font-black tracking-widest block mb-1">Gejala / Keluhan</label>
                        <div class="text-sm text-slate-700 bg-white p-3 rounded-xl border border-slate-200 italic shadow-sm">
                            {{ $record->gejala ?: '-' }}
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-400 uppercase text-[9px] font-black tracking-widest block mb-1">Tindakan Medis</label>
                        <div class="text-sm text-slate-700 bg-white p-3 rounded-xl border border-slate-200 shadow-sm">
                            {{ $record->tindakan ?: '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Treatment & Medicine Section -->
        <div class="lg:col-span-5 space-y-6">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Pengobatan</h4>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="text-slate-400 uppercase text-[9px] font-black tracking-widest block mb-2">Pemakaian Obat</label>
                    <div class="space-y-2">
                        @forelse($record->obats as $o)
                            <div class="flex items-center justify-between text-xs bg-emerald-50/50 p-2.5 rounded-xl border border-emerald-100 transition-all hover:bg-emerald-50 group">
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    <span class="font-bold text-slate-700">{{ $o->nama_obat }}</span>
                                </div>
                                <span class="bg-white px-2 py-0.5 rounded-lg border border-emerald-200 font-black text-emerald-600 shadow-sm">
                                    {{ $o->pivot->jumlah }} {{ $o->pivot->satuan }}
                                </span>
                            </div>
                        @empty
                            <div class="text-xs text-slate-400 italic bg-slate-50 p-3 rounded-xl border border-dashed border-slate-200 text-center">
                                Tidak ada pemakaian obat yang dicatat.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div>
                    <label class="text-slate-400 uppercase text-[9px] font-black tracking-widest block mb-2">Catatan Tambahan</label>
                    <div class="text-xs text-slate-600 bg-amber-50/30 p-4 rounded-xl border border-amber-100 italic leading-relaxed">
                        {{ $record->catatan ?: 'Tidak ada catatan tambahan.' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Guardian Info -->
    @if($record->santri->wali)
        <div class="pt-8 border-t border-slate-100">
            <div class="flex justify-between items-end mb-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Kontak Wali (Emergency)</h4>
                </div>
                
                @php
                    $cleanPhone = preg_replace('/[^0-9]/', '', $record->santri->wali->no_hp);
                    if (str_starts_with($cleanPhone, '0')) {
                        $cleanPhone = '62' . substr($cleanPhone, 1);
                    } elseif (!str_starts_with($cleanPhone, '62')) {
                        $cleanPhone = '62' . $cleanPhone;
                    }
                    $waLink = "https://wa.me/" . $cleanPhone . "?text=" . urlencode("Halo Bapak/Ibu " . $record->santri->wali->nama_wali . ", saya petugas kesehatan dari Deisa ingin menginformasikan kondisi kesehatan " . ($record->santri ? $record->santri->nama_lengkap : 'santri kami') . ".");
                @endphp
                
                <a href="{{ $waLink }}" target="_blank" class="flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-lg shadow-emerald-200 active:scale-95">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    Hubungi via WhatsApp
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 bg-slate-50 p-6 rounded-2xl border border-slate-100 shadow-inner">
                <div>
                    <div class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest mb-1">Nama Wali</div>
                    <div class="text-sm font-bold text-slate-900">{{ $record->santri->wali->nama_wali }}</div>
                </div>
                <div>
                    <div class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest mb-1">Hubungan</div>
                    <div class="text-sm font-medium text-slate-700 flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded-md bg-indigo-100/50 text-indigo-600 text-[10px] font-bold">{{ ucfirst($record->santri->wali->hubungan) }}</span>
                    </div>
                </div>
                <div>
                    <div class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest mb-1">No. HP / WhatsApp</div>
                    <div class="text-sm font-black text-emerald-600 flex items-center gap-1.5">
                        <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                        {{ $record->santri->wali->no_hp }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($record->tgl_sembuh)
        <div
            class="mt-4 flex items-center gap-3 text-emerald-600 text-sm font-bold bg-emerald-50/50 p-5 rounded-2xl border border-emerald-100">
            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <div class="text-[10px] uppercase font-black tracking-widest opacity-70">Status Pemulihan</div>
                <div class="text-sm font-extrabold">Dinyatakan Sembuh pada {{ $record->tgl_sembuh->format('d M Y H:i') }}</div>
            </div>
        </div>
    @endif
</div>

<div class="px-6 py-5 bg-slate-50 border-t border-slate-100 flex justify-end gap-3 rounded-b-3xl">
    <button type="button" onclick="document.getElementById('global-detail-modal').classList.add('hidden')"
        class="px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-all border border-slate-200 hover:shadow-sm">Tutup</button>
    <x-button variant="primary" data-form-url="{{ route('admin.sakit.edit', $record->id) }}"
        onclick="document.getElementById('global-detail-modal').classList.add('hidden')"
        class="px-6 py-2.5 rounded-xl shadow-lg shadow-blue-200 font-bold active:scale-95 transition-all">
        Edit Laporan
    </x-button>
</div>
