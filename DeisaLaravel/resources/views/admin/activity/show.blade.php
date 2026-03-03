@extends(auth()->user()->role == 'admin' ? 'layouts.admin' : 'layouts.app')

@section('title', 'Detail Aktivitas')

@php $mainSection = auth()->user()->role == 'admin' ? 'admin-content' : 'content'; @endphp

@section('header')
    <div class="flex flex-col gap-2">
        <a href="{{ route('admin.activity.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-deisa-blue">
            <span aria-hidden="true">←</span> Kembali ke Riwayat Aktivitas
        </a>
        <h2 class="text-xl font-bold text-slate-900">Detail Aktivitas</h2>
        <p class="text-sm text-slate-500">Rincian aksi pengguna, waktu, modul, dan payload perubahan data.</p>
    </div>
@endsection

@section($mainSection)
    <div class="{{ auth()->user()->role == 'admin' ? '' : 'max-w-5xl mx-auto px-6 pt-10 pb-24' }}">
        <div class="space-y-6">
            <x-card>
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Aksi</p>
                        <p class="mt-1 text-2xl font-black text-slate-900">{{ strtoupper($log->action) }}</p>
                        <p class="text-sm text-slate-500">{{ ucfirst($log->module) }}</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-deisa-blue border border-blue-100 w-max">
                        {{ $log->created_at->format('d M Y H:i:s') }}
                    </span>
                </div>
            </x-card>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
                <x-card>
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">User</p>
                    <p class="mt-2 font-bold text-slate-900">{{ optional($log->user)->name ?: 'System' }}</p>
                    <p class="text-xs text-slate-500 uppercase">{{ optional($log->user)->role ?: '-' }}</p>
                </x-card>
                <x-card>
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">IP Address</p>
                    <p class="mt-2 font-mono font-bold text-slate-900">{{ $log->ip_address ?: '-' }}</p>
                </x-card>
                <x-card>
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">ID Log</p>
                    <p class="mt-2 font-bold text-slate-900">#{{ $log->id }}</p>
                </x-card>
            </div>

            <x-card>
                <h3 class="text-base font-bold text-slate-900 mb-3">Payload / Detail Aktivitas</h3>
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                    <pre class="text-sm text-slate-700 whitespace-pre-wrap break-words leading-relaxed">{{ $log->detail ?: '-' }}</pre>
                </div>
            </x-card>
        </div>
    </div>
@endsection
