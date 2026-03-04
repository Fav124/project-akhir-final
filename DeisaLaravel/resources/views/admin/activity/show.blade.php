@extends('layouts.admin')

@section('title', 'Detail Aktivitas')

@section('header')
    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
        <div class="space-y-2">
            <a href="{{ route('admin.activity.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-deisa-blue">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Riwayat Aktivitas
            </a>
            <h2 class="text-xl font-bold text-slate-900">Detail Aktivitas</h2>
            <p class="text-sm text-slate-500">Rincian aksi pengguna, waktu kejadian, modul, dan payload perubahan data.</p>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="mx-auto max-w-6xl space-y-6">
        <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/40 rounded-3xl">
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2 rounded-2xl border border-blue-100 bg-blue-50 p-4">
                    <p class="text-xs uppercase tracking-wider text-blue-600 font-bold">Aksi</p>
                    <p class="mt-2 text-2xl font-black text-slate-900 break-all">{{ strtoupper($log->action) }}</p>
                    <p class="text-sm text-slate-500 mt-1">Modul: {{ ucfirst($log->module ?: '-') }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Waktu Kejadian</p>
                    <p class="mt-2 text-base font-black text-slate-900">{{ $log->created_at->format('d M Y H:i:s') }}</p>
                </div>
            </div>
        </x-card>

        <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/30 rounded-3xl">
            <div class="p-6 space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center text-violet-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 8h10"/></svg>
                        </div>
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Metadata Aktivitas</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">User</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ optional($log->user)->name ?: 'System' }}</p>
                            <p class="text-xs text-slate-500 uppercase">{{ optional($log->user)->role ?: '-' }}</p>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">IP Address</p>
                            <p class="mt-1 font-mono font-semibold text-slate-900">{{ $log->ip_address ?: '-' }}</p>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">ID Log</p>
                            <p class="mt-1 font-semibold text-slate-900">#{{ $log->id }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10 0v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6m10 0H7"/></svg>
                        </div>
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Payload / Detail Aktivitas</h3>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <pre class="text-sm text-slate-700 whitespace-pre-wrap break-words leading-relaxed">{{ $log->detail ?: '-' }}</pre>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
@endsection
