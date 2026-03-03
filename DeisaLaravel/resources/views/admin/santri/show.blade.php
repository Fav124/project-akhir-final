@extends('layouts.admin')

@section('title', 'Detail Santri')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.santri.index') }}" class="text-slate-500 hover:text-slate-700 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h2 class="text-xl font-bold text-slate-900">Detail Santri</h2>
    </div>
@endsection

@section('admin-content')
    @php
        $status = strtolower((string) $santri->status_kesehatan);
        $statusClass = $status === 'sehat'
            ? 'bg-emerald-100 text-emerald-700 border-emerald-200'
            : ($status === 'pemulihan'
                ? 'bg-blue-100 text-blue-700 border-blue-200'
                : 'bg-rose-100 text-rose-700 border-rose-200');

        $riwayatSakit = $santri->sakit->sortByDesc(fn($item) => $item->tgl_masuk ?? $item->created_at);
        $jumlahRiwayat = $riwayatSakit->count();
        $riwayatSembuh = $riwayatSakit->where('status', 'Sembuh')->count();
        $riwayatPulang = $riwayatSakit->where('status', 'Pulang')->count();

        $hasWali = (bool) $santri->wali;
        $rawPhone = $hasWali ? (string) ($santri->wali->no_hp ?? '') : '';
        $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
        if ($cleanPhone) {
            if (str_starts_with($cleanPhone, '0')) {
                $cleanPhone = '62' . substr($cleanPhone, 1);
            } elseif (!str_starts_with($cleanPhone, '62')) {
                $cleanPhone = '62' . $cleanPhone;
            }
        }
        $waLink = $cleanPhone
            ? ('https://api.whatsapp.com/send?phone=' . $cleanPhone . '&text=' . urlencode("Assalamu'alaikum Bapak/Ibu {$santri->wali->nama_wali}, kami dari UKS DEISA ingin menyampaikan update kondisi {$santri->nama_lengkap}."))
            : null;
    @endphp

    <div class="space-y-6">
        <x-card class="border-none shadow-xl shadow-slate-200/50 rounded-3xl">
            <div class="grid grid-cols-1 lg:grid-cols-[220px_1fr] gap-6">
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div
                        class="w-28 h-28 mx-auto rounded-2xl bg-blue-100 flex items-center justify-center text-deisa-blue text-4xl font-bold shadow-inner overflow-hidden">
                        @if($santri->foto)
                            <img src="{{ asset('storage/' . $santri->foto) }}" class="w-full h-full object-cover rounded-2xl">
                        @else
                            {{ substr($santri->nama_lengkap, 0, 1) }}
                        @endif
                    </div>
                    <div class="text-center mt-3">
                        <p class="font-bold text-slate-900 leading-tight">{{ $santri->nama_lengkap }}</p>
                        <p class="text-xs text-slate-500 mt-1">NIS: {{ $santri->nis }}</p>
                    </div>
                    <div class="mt-3 text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase border {{ $statusClass }}">
                            {{ $santri->status_kesehatan }}
                        </span>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <div class="rounded-xl border border-slate-200 p-3 bg-slate-50">
                            <p class="text-[10px] font-bold uppercase text-slate-400">Total Riwayat Sakit</p>
                            <p class="text-2xl font-black text-slate-900">{{ $jumlahRiwayat }}</p>
                        </div>
                        <div class="rounded-xl border border-slate-200 p-3 bg-emerald-50/50">
                            <p class="text-[10px] font-bold uppercase text-slate-400">Kasus Sembuh</p>
                            <p class="text-2xl font-black text-emerald-600">{{ $riwayatSembuh }}</p>
                        </div>
                        <div class="rounded-xl border border-slate-200 p-3 bg-blue-50/60">
                            <p class="text-[10px] font-bold uppercase text-slate-400">Kasus Pulang</p>
                            <p class="text-2xl font-black text-blue-600">{{ $riwayatPulang }}</p>
                        </div>
                        <div class="rounded-xl border border-slate-200 p-3 bg-amber-50/60">
                            <p class="text-[10px] font-bold uppercase text-slate-400">Tahun Masuk</p>
                            <p class="text-2xl font-black text-amber-600">{{ $santri->tahun_masuk ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 p-4">
                        <h3 class="text-[11px] font-black tracking-wider uppercase text-slate-500 mb-3">Identitas & Akademik</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div><span class="text-slate-400 text-[10px] font-bold uppercase">Nama Lengkap</span><p class="font-semibold text-slate-900">{{ $santri->nama_lengkap }}</p></div>
                            <div><span class="text-slate-400 text-[10px] font-bold uppercase">NIS</span><p class="font-mono text-slate-900">{{ $santri->nis }}</p></div>
                            <div><span class="text-slate-400 text-[10px] font-bold uppercase">Kelas</span><p class="font-semibold text-slate-900">{{ $santri->kelas->nama_kelas ?? '-' }}</p></div>
                            <div><span class="text-slate-400 text-[10px] font-bold uppercase">Jurusan</span><p class="font-semibold text-slate-900">{{ $santri->jurusan->nama_jurusan ?? '-' }}</p></div>
                            <div><span class="text-slate-400 text-[10px] font-bold uppercase">Jenis Kelamin</span><p class="font-semibold text-slate-900">{{ $santri->jenis_kelamin }}</p></div>
                            <div><span class="text-slate-400 text-[10px] font-bold uppercase">Status Akademik</span><p class="font-semibold text-slate-900">{{ $santri->status_akademik ?? '-' }}</p></div>
                            <div><span class="text-slate-400 text-[10px] font-bold uppercase">Tempat, Tgl Lahir</span><p class="font-semibold text-slate-900">{{ $santri->tempat_lahir ?: '-' }}, {{ $santri->tanggal_lahir ? \Carbon\Carbon::parse($santri->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</p></div>
                            <div><span class="text-slate-400 text-[10px] font-bold uppercase">Pernah Tinggal Kelas</span><p class="font-semibold text-slate-900">{{ $santri->is_repeating ? 'Ya' : 'Tidak' }}</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-card class="border-none shadow-xl shadow-slate-200/50 rounded-3xl">
                <h3 class="text-[11px] font-black tracking-wider uppercase text-slate-500 mb-3">Informasi Medis</h3>
                <div class="space-y-3 text-sm">
                    <div class="rounded-xl border border-slate-200 p-3 bg-slate-50">
                        <p class="text-[10px] font-bold uppercase text-slate-400">Golongan Darah</p>
                        <p class="font-semibold text-slate-900">{{ $santri->golongan_darah ?? '-' }}</p>
                    </div>
                    <div class="rounded-xl border border-amber-100 p-3 bg-amber-50/60">
                        <p class="text-[10px] font-bold uppercase text-slate-400">Riwayat Alergi</p>
                        <p class="text-slate-700">{{ $santri->riwayat_alergi ?: 'Tidak ada riwayat alergi yang tercatat.' }}</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 p-3 bg-slate-50">
                        <p class="text-[10px] font-bold uppercase text-slate-400">Alamat</p>
                        <p class="text-slate-700">{{ $santri->alamat ?: '-' }}</p>
                    </div>
                </div>
            </x-card>

            <x-card class="border-none shadow-xl shadow-slate-200/50 rounded-3xl">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div>
                        <h3 class="text-[11px] font-black tracking-wider uppercase text-slate-500">Kontak Wali (Emergency)</h3>
                        <p class="text-xs text-slate-500 mt-1">Data komunikasi utama saat kondisi darurat</p>
                    </div>
                    @if($waLink)
                        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-2 rounded-xl text-xs font-bold transition-all">
                            Hubungi WhatsApp
                        </a>
                    @endif
                </div>

                @if($hasWali)
                    <div class="grid grid-cols-1 gap-3 text-sm">
                        <div class="rounded-xl border border-slate-200 p-3 bg-slate-50"><span class="text-slate-400 text-[10px] font-bold uppercase">Nama Wali</span><p class="font-semibold text-slate-900">{{ $santri->wali->nama_wali }}</p></div>
                        <div class="rounded-xl border border-slate-200 p-3 bg-slate-50"><span class="text-slate-400 text-[10px] font-bold uppercase">Hubungan</span><p class="font-semibold text-slate-900">{{ ucfirst($santri->wali->hubungan ?? '-') }}</p></div>
                        <div class="rounded-xl border border-slate-200 p-3 bg-slate-50"><span class="text-slate-400 text-[10px] font-bold uppercase">No HP / WhatsApp</span><p class="font-semibold text-slate-900">{{ $santri->wali->no_hp ?? '-' }}</p></div>
                    </div>
                @else
                    <div class="text-sm text-slate-500 italic">Data wali belum tersedia.</div>
                @endif
            </x-card>
        </div>

        <x-card class="border-none shadow-xl shadow-slate-200/50 rounded-3xl">
            <h3 class="text-[11px] font-black tracking-wider uppercase text-slate-500 mb-3">Riwayat Kesehatan</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-900 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Tanggal Masuk</th>
                            <th class="px-4 py-3 font-semibold">Diagnosis</th>
                            <th class="px-4 py-3 font-semibold">Perawatan</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($riwayatSakit as $r)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 text-slate-600">{{ $r->tgl_masuk ? $r->tgl_masuk->format('d/m/Y') : '-' }}</td>
                                <td class="px-4 py-3 font-semibold text-slate-900">{{ $r->diagnosis_utama ?: '-' }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $r->jenis_perawatan ?: '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase border {{ $r->status === 'Sembuh' ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : ($r->status === 'Pulang' ? 'bg-blue-100 text-blue-700 border-blue-200' : 'bg-amber-100 text-amber-700 border-amber-200') }}">
                                        {{ $r->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.sakit.show', $r->id) }}" class="text-deisa-blue font-semibold hover:underline">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-slate-400 italic">Belum ada riwayat sakit yang tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection

