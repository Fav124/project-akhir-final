@extends('layouts.admin')

@section('title', 'Detail Obat')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.obat.index') }}" class="text-slate-500 hover:text-slate-700 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h2 class="text-xl font-bold text-slate-900">{{ $obat->nama_obat }}</h2>
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

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-card class="md:col-span-2 border-none shadow-xl shadow-slate-200/50 rounded-3xl">
                <div class="flex flex-col sm:flex-row gap-6">
                    <div class="w-32 h-32 bg-slate-100 rounded-xl overflow-hidden flex items-center justify-center text-slate-400 font-medium">
                        @if($obat->foto)
                            <img src="{{ asset('storage/' . $obat->foto) }}" alt="{{ $obat->nama_obat }}" class="w-full h-full object-cover">
                        @else
                            No Image
                        @endif
                    </div>
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Kode</label>
                            <div class="font-mono text-slate-900 font-medium mt-1">{{ $obat->kode_obat }}</div>
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Kategori</label>
                            <div class="text-slate-900 font-medium mt-1">{{ $obat->kategori }}</div>
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Stok Saat Ini</label>
                            <div class="text-2xl font-bold {{ $statusStok === 'Kritis' ? 'text-rose-600' : 'text-deisa-blue' }} mt-1">
                                {{ $obat->stok }} {{ $obat->satuan }}
                            </div>
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Kadaluarsa</label>
                            <div class="text-slate-900 font-medium mt-1">{{ $obat->tanggal_kadaluarsa ? $obat->tanggal_kadaluarsa->translatedFormat('d M Y') : '-' }}</div>
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Stok Minimum</label>
                            <div class="text-slate-900 font-medium mt-1">{{ $obat->stok_minimum }} {{ $obat->satuan }}</div>
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Lokasi Penyimpanan</label>
                            <div class="text-slate-900 font-medium mt-1">{{ $obat->lokasi_penyimpanan ?: '-' }}</div>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card class="border-none shadow-xl shadow-slate-200/50 rounded-3xl">
                <x-slot name="header">Status Obat</x-slot>
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
                        <p class="text-base font-bold text-slate-700">
                            {{ is_null($sisaHari) ? '-' : ($sisaHari >= 0 ? $sisaHari . ' hari' : 'Lewat ' . abs($sisaHari) . ' hari') }}
                        </p>
                    </div>
                </div>
            </x-card>
        </div>

        <x-card class="border-none shadow-xl shadow-slate-200/50 rounded-3xl">
            <x-slot name="header">Ringkasan Penggunaan</x-slot>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Dipakai</p>
                            <p class="text-2xl font-black text-slate-900">{{ $totalPemakaian }}</p>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Transaksi</p>
                            <p class="text-2xl font-black text-slate-900">{{ $totalTransaksi }}</p>
                        </div>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Harga Satuan</p>
                        <p class="text-lg font-bold text-slate-900">Rp {{ number_format((float) $obat->harga_satuan, 0, ',', '.') }}</p>
                    </div>
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
                                <div class="h-2 rounded-full bg-slate-200 overflow-hidden">
                                    <div class="h-full bg-deisa-blue rounded-full" style="width: {{ $barWidth }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </x-card>

        <x-card class="border-none shadow-xl shadow-slate-200/50 rounded-3xl">
            <x-slot name="header">Riwayat Penggunaan Terbaru</x-slot>
            <div class="overflow-x-auto">
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
                            <tr>
                                <td colspan="4" class="px-4 py-10 text-center text-slate-400 italic">Belum ada riwayat penggunaan obat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>

        <div class="flex justify-end gap-3">
            <x-button variant="outline" href="{{ route('admin.obat.index') }}">Kembali</x-button>
            <x-button href="{{ route('admin.obat.edit', $obat->id) }}">Edit Obat</x-button>
        </div>
    </div>
@endsection
