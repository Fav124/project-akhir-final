@extends('layouts.admin')

@section('title', 'Detail Laporan Sakit')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.sakit.index') }}" class="text-slate-500 hover:text-slate-700 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h2 class="text-xl font-bold text-slate-900">Detail Laporan Sakit</h2>
    </div>
@endsection

@section('admin-content')
    @php
        $statusColors = [
            'Sakit' => 'bg-amber-100 text-amber-700 border-amber-200',
            'Pulang' => 'bg-blue-100 text-blue-700 border-blue-200',
            'Sembuh' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
        ];
        $color = $statusColors[$record->status] ?? 'bg-slate-100 text-slate-600';
    @endphp

    <div class="space-y-6">
        <x-card class="border-none shadow-xl shadow-slate-200/50 rounded-3xl">
            <div class="flex flex-col md:flex-row md:items-center gap-5 bg-gradient-to-br from-blue-50 to-white p-5 rounded-2xl border border-blue-100 shadow-sm">
                <div class="w-16 h-16 rounded-full bg-deisa-blue flex items-center justify-center text-white text-3xl font-bold shadow-lg shadow-blue-200 ring-4 ring-white">
                    {{ $record->santri ? substr($record->santri->nama_lengkap, 0, 1) : '?' }}
                </div>
                <div class="flex-1">
                    <div class="font-extrabold text-slate-900 text-xl tracking-tight">{{ $record->santri->nama_lengkap ?? 'Santri Tidak Ditemukan' }}</div>
                    <div class="text-sm text-slate-500 flex items-center gap-3 mt-1">
                        <span class="bg-blue-100 text-deisa-blue px-2.5 py-0.5 rounded-md font-bold text-[10px] uppercase tracking-wider">
                            {{ ($record->santri && $record->santri->kelas) ? $record->santri->kelas->nama_kelas : '-' }}
                        </span>
                        <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                        <span class="font-medium">{{ $record->tgl_masuk ? $record->tgl_masuk->format('d M Y') : '-' }}</span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase border-2 shadow-sm {{ $color }} mb-1.5 inline-block">
                        {{ $record->status }}
                    </div>
                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $record->jenis_perawatan }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mt-4">
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                    <div class="text-[10px] uppercase tracking-widest text-slate-400 font-black mb-1">Kode Riwayat</div>
                    <div class="text-sm font-bold text-slate-800">{{ $record->kode_riwayat ?? '-' }}</div>
                </div>
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-3">
                    <div class="text-[10px] uppercase tracking-widest text-blue-500 font-black mb-1">Waktu Pulang</div>
                    <div class="text-sm font-bold text-slate-800">{{ $record->tgl_pulang ? $record->tgl_pulang->format('d M Y H:i') : '-' }}</div>
                </div>
                <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-3">
                    <div class="text-[10px] uppercase tracking-widest text-emerald-600 font-black mb-1">Waktu Kembali</div>
                    <div class="text-sm font-bold text-slate-800">{{ $record->tgl_kembali ? $record->tgl_kembali->format('d M Y H:i') : '-' }}</div>
                </div>
                <div class="bg-amber-50 border border-amber-100 rounded-xl p-3">
                    <div class="text-[10px] uppercase tracking-widest text-amber-600 font-black mb-1">Waktu Sembuh</div>
                    <div class="text-sm font-bold text-slate-800">{{ $record->tgl_sembuh ? $record->tgl_sembuh->format('d M Y H:i') : '-' }}</div>
                </div>
            </div>
        </x-card>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <x-card class="lg:col-span-7 border-none shadow-xl shadow-slate-200/50 rounded-3xl">
                <h3 class="text-[11px] font-black tracking-wider uppercase text-slate-500 mb-3">Kondisi Medis</h3>
                <div class="space-y-3">
                    <div class="rounded-xl border border-slate-200 p-3 bg-slate-50">
                        <div class="text-[10px] uppercase tracking-widest text-slate-400 font-black mb-1">Diagnosis Utama</div>
                        <div class="text-base font-bold text-slate-900">{{ $record->diagnosis_utama ?: '-' }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="rounded-xl border border-slate-200 p-3 bg-white">
                            <div class="text-[10px] uppercase tracking-widest text-slate-400 font-black mb-1">Gejala / Keluhan</div>
                            <div class="text-sm text-slate-700">{{ $record->gejala ?: '-' }}</div>
                        </div>
                        <div class="rounded-xl border border-slate-200 p-3 bg-white">
                            <div class="text-[10px] uppercase tracking-widest text-slate-400 font-black mb-1">Tindakan Medis</div>
                            <div class="text-sm text-slate-700">{{ $record->tindakan ?: '-' }}</div>
                        </div>
                    </div>
                    <div class="rounded-xl border border-slate-200 p-3 bg-slate-50">
                        <div class="text-[10px] uppercase tracking-widest text-slate-400 font-black mb-1">Alasan Dipulangkan</div>
                        <div class="text-sm text-slate-700">{{ $record->alasan_pulang ?: '-' }}</div>
                    </div>
                </div>
            </x-card>

            <x-card class="lg:col-span-5 border-none shadow-xl shadow-slate-200/50 rounded-3xl">
                <h3 class="text-[11px] font-black tracking-wider uppercase text-slate-500 mb-3">Pengobatan</h3>
                <div class="space-y-3">
                    <div class="rounded-xl border border-slate-200 p-3 bg-slate-50">
                        <div class="text-[10px] uppercase tracking-widest text-slate-400 font-black mb-1">Tujuan Rujukan</div>
                        <div class="text-sm text-slate-700">{{ $record->tujuan_rujukan ?: '-' }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase tracking-widest text-slate-400 font-black mb-2">Pemakaian Obat</div>
                        <div class="space-y-2">
                            @forelse($record->obats as $o)
                                <div class="flex items-center justify-between text-xs bg-emerald-50/50 p-2.5 rounded-xl border border-emerald-100">
                                    <span class="font-bold text-slate-700">{{ $o->nama_obat }}</span>
                                    <span class="bg-white px-2 py-0.5 rounded-lg border border-emerald-200 font-black text-emerald-600">
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
                    <div class="rounded-xl border border-amber-100 p-3 bg-amber-50/40">
                        <div class="text-[10px] uppercase tracking-widest text-slate-400 font-black mb-1">Catatan Tambahan</div>
                        <div class="text-sm text-slate-700 italic">{{ $record->catatan ?: 'Tidak ada catatan tambahan.' }}</div>
                    </div>
                </div>
            </x-card>
        </div>

        <x-card class="border-none shadow-xl shadow-slate-200/50 rounded-3xl">
            <div class="flex items-start justify-between gap-3 mb-3">
                <div>
                    <h3 class="text-[11px] font-black tracking-wider uppercase text-slate-500">Kontak Wali (Emergency)</h3>
                    <p class="text-xs text-slate-500 mt-1">Informasi wali untuk tindak lanjut cepat</p>
                </div>
                @if(optional($record->santri)->wali)
                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', $record->santri->wali->no_hp ?? '');
                        if (str_starts_with($cleanPhone, '0')) {
                            $cleanPhone = '62' . substr($cleanPhone, 1);
                        } elseif ($cleanPhone && !str_starts_with($cleanPhone, '62')) {
                            $cleanPhone = '62' . $cleanPhone;
                        }
                        $waLink = $cleanPhone
                            ? "https://wa.me/{$cleanPhone}?text=" . urlencode("Halo Bapak/Ibu {$record->santri->wali->nama_wali}, kami dari UKS DEISA menyampaikan update kondisi {$record->santri->nama_lengkap}.")
                            : null;
                    @endphp
                    @if($waLink)
                        <a href="{{ $waLink }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-2 rounded-xl text-xs font-bold transition-all">
                            Hubungi via WhatsApp
                        </a>
                    @endif
                @endif
            </div>

            @if(optional($record->santri)->wali)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                    <div class="rounded-xl border border-slate-200 p-3 bg-slate-50"><span class="text-slate-400 text-[10px] font-bold uppercase">Nama Wali</span><p class="font-semibold text-slate-900">{{ $record->santri->wali->nama_wali }}</p></div>
                    <div class="rounded-xl border border-slate-200 p-3 bg-slate-50"><span class="text-slate-400 text-[10px] font-bold uppercase">Hubungan</span><p class="font-semibold text-slate-900">{{ ucfirst($record->santri->wali->hubungan ?? '-') }}</p></div>
                    <div class="rounded-xl border border-slate-200 p-3 bg-slate-50"><span class="text-slate-400 text-[10px] font-bold uppercase">No. HP / WhatsApp</span><p class="font-semibold text-slate-900">{{ $record->santri->wali->no_hp ?? '-' }}</p></div>
                </div>
            @else
                <div class="text-sm text-slate-500 italic">Data wali belum tersedia.</div>
            @endif
        </x-card>

        <div class="flex justify-end gap-3">
            <x-button variant="outline" href="{{ route('admin.sakit.index') }}">Kembali</x-button>
            <x-button href="{{ route('admin.sakit.edit', $record->id) }}">Edit Laporan</x-button>
        </div>
    </div>
@endsection

