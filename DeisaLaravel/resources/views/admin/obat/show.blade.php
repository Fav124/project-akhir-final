@extends('layouts.admin')

@section('title', 'Detail Obat')

@section('header')
    <div class="flex items-center gap-4">
        <a href="/admin/obat" class="text-slate-500 hover:text-slate-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
        </a>
        <h2 class="text-xl font-bold text-slate-900">Paracetamol 500mg</h2>
    </div>
@endsection

@section('admin-content')
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-card class="md:col-span-2">
                <div class="flex flex-col sm:flex-row gap-6">
                    <div
                        class="w-32 h-32 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 font-medium">
                        No Image
                    </div>
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Kode</label>
                            <div class="font-mono text-slate-900 font-medium mt-1">OBT-001</div>
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Kategori</label>
                            <div class="text-slate-900 font-medium mt-1">Tablet</div>
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Stok Saat
                                Ini</label>
                            <div class="text-2xl font-bold text-deisa-blue mt-1">150 Tablet</div>
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Kadaluarsa</label>
                            <div class="text-slate-900 font-medium mt-1">Dec 31, 2026</div>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <x-slot name="header">Penggunaan 30 Hari</x-slot>
                <div class="h-40">
                    <x-obat-chart id="usageChart" :data="[10, 5, 8, 12]" />
                </div>
            </x-card>
        </div>

        <x-card>
            <x-slot name="header">Riwayat Penggunaan</x-slot>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-900 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Tanggal</th>
                            <th class="px-4 py-3 font-semibold">Santri</th>
                            <th class="px-4 py-3 font-semibold">Jumlah</th>
                            <th class="px-4 py-3 font-semibold">Petugas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3">2026-01-14 10:00</td>
                            <td class="px-4 py-3 font-medium text-slate-900">Ahmad Fulan</td>
                            <td class="px-4 py-3 font-mono text-red-600">-2</td>
                            <td class="px-4 py-3">Admin</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection