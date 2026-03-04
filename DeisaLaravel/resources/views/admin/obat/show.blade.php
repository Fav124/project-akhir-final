@extends('layouts.admin')

@section('title', 'Detail Obat')

@section('header')
    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
        <div class="space-y-2">
            <a href="{{ route('admin.obat.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-deisa-blue">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Manajemen Obat
            </a>
            <h2 class="text-xl font-bold text-slate-900">Detail Obat {{ $obat->nama_obat }}</h2>
            <p class="text-sm text-slate-500">Informasi stok, status kadaluarsa, dan ringkasan penggunaan obat.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.obat.edit', $obat->id) }}"
               class="inline-flex items-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Edit Obat
            </a>
        </div>
    </div>
@endsection

@section('admin-content')
    @php
        $statusStok = $obat->stok <= $obat->stok_minimum ? 'Kritis' : 'Aman';
        $statusKadaluarsa = $obat->tanggal_kadaluarsa
            ? ($obat->tanggal_kadaluarsa->isPast() ? 'Kadaluarsa' : 'Aktif')
            : 'Tanpa Tanggal';
        $sisaHari = $obat->tanggal_kadaluarsa
            ? now()->diffInDays($obat->tanggal_kadaluarsa, false)
            : null;
        $maxUsage = max(1, collect($usageValues)->max());
    @endphp

    <div class="mx-auto max-w-6xl space-y-6">
        <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/40 rounded-3xl">
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 flex flex-col sm:flex-row gap-6">
                    <div class="w-32 h-32 bg-slate-100 rounded-xl overflow-hidden flex items-center justify-center text-slate-400 font-medium">
                        @if($obat->foto)
                            <img src="{{ asset('storage/' . $obat->foto) }}" alt="{{ $obat->nama_obat }}" class="w-full h-full object-cover">
                        @else
                            No Image
                        @endif
                    </div>
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3"><p class="text-[10px] uppercase tracking-widest text-slate-400 font-black">Kode</p><p class="font-mono text-slate-900 font-medium mt-1">{{ $obat->kode_obat }}</p></div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3"><p class="text-[10px] uppercase tracking-widest text-slate-400 font-black">Kategori</p><p class="text-slate-900 font-medium mt-1">{{ $obat->kategori }}</p></div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3"><p class="text-[10px] uppercase tracking-widest text-slate-400 font-black">Stok Saat Ini</p><p class="text-2xl font-bold {{ $statusStok === 'Kritis' ? 'text-rose-600' : 'text-deisa-blue' }} mt-1">{{ $obat->stok }} {{ $obat->satuan }}</p></div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3"><p class="text-[10px] uppercase tracking-widest text-slate-400 font-black">Kadaluarsa</p><p class="text-slate-900 font-medium mt-1">{{ $obat->tanggal_kadaluarsa ? $obat->tanggal_kadaluarsa->translatedFormat('d M Y') : '-' }}</p></div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3"><p class="text-[10px] uppercase tracking-widest text-slate-400 font-black">Stok Minimum</p><p class="text-slate-900 font-medium mt-1">{{ $obat->stok_minimum }} {{ $obat->satuan }}</p></div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3"><p class="text-[10px] uppercase tracking-widest text-slate-400 font-black">Lokasi Penyimpanan</p><p class="text-slate-900 font-medium mt-1">{{ $obat->lokasi_penyimpanan ?: '-' }}</p></div>
                    </div>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="rounded-xl border p-3 {{ $statusStok === 'Kritis' ? 'border-rose-200 bg-rose-50' : 'border-emerald-200 bg-emerald-50' }}">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Status Stok</p>
                        <p class="text-base font-bold {{ $statusStok === 'Kritis' ? 'text-rose-600' : 'text-emerald-600' }}">{{ $statusStok }}</p>
                    </div>
                    <div class="rounded-xl border p-3 {{ $statusKadaluarsa === 'Kadaluarsa' ? 'border-rose-200 bg-rose-50' : 'border-slate-200 bg-slate-50' }}">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Status Kadaluarsa</p>
                        <p class="text-base font-bold {{ $statusKadaluarsa === 'Kadaluarsa' ? 'text-rose-600' : 'text-slate-700' }}">{{ $statusKadaluarsa }}</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Sisa Umur Simpan</p>
                        <p class="text-base font-bold text-slate-700">{{ is_null($sisaHari) ? '-' : ($sisaHari >= 0 ? $sisaHari . ' hari' : 'Lewat ' . abs($sisaHari) . ' hari') }}</p>
                    </div>
                </div>
            </div>
        </x-card>

        <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/30 rounded-3xl">
            <div class="p-6 space-y-4">
                <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-deisa-blue">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h6m-6 4h10M5 6h.01M5 10h.01M5 14h.01M5 18h.01"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Ringkasan Penggunaan</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3"><p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Dipakai</p><p class="text-2xl font-black text-slate-900">{{ $totalPemakaian }}</p></div>
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3"><p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Transaksi</p><p class="text-2xl font-black text-slate-900">{{ $totalTransaksi }}</p></div>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3"><p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Harga Satuan</p><p class="text-lg font-bold text-slate-900">Rp {{ number_format((float) $obat->harga_satuan, 0, ',', '.') }}</p></div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Penggunaan 6 Bulan</p>
                        <div class="space-y-2">
                            @foreach($usageLabels as $i => $label)
                                @php
                                    $value = $usageValues[$i] ?? 0;
                                    $barWidth = max(3, (int) round(($value / $maxUsage) * 100));
                                @endphp
                                <div>
                                    <div class="flex items-center justify-between text-xs mb-1">
                                        <span class="font-semibold text-slate-700">{{ $label }}</span>
                                        <span class="font-black text-slate-900">{{ $value }}</span>
                                    </div>
                                    <div class="h-2 rounded-full bg-slate-200 overflow-hidden"><div class="h-full bg-deisa-blue rounded-full" style="width: {{ $barWidth }}%"></div></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </x-card>

        <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/30 rounded-3xl">
            <div class="p-6 space-y-4">
                <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10 0v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6m10 0H7"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Riwayat Penggunaan Terbaru</h3>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-100">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-900 border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Tanggal</th>
                                <th class="px-4 py-3 font-semibold">Santri</th>
                                <th class="px-4 py-3 font-semibold">Jumlah</th>
                                <th class="px-4 py-3 font-semibold">Laporan Sakit</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($penggunaanTerbaru as $p)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3">{{ $p->created_at?->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-3 font-medium text-slate-900">{{ $p->santri_sakit?->santri?->nama_lengkap ?? '-' }}</td>
                                    <td class="px-4 py-3 font-mono text-rose-600">-{{ $p->jumlah }} {{ $p->satuan ?: $obat->satuan }}</td>
                                    <td class="px-4 py-3">
                                        @if($p->santri_sakit_id)
                                            <a href="{{ route('admin.sakit.show', $p->santri_sakit_id) }}" class="text-deisa-blue hover:underline font-semibold">Lihat</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-10 text-center text-slate-400 italic">Belum ada riwayat penggunaan obat.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </x-card>
    </div>
@endsection
