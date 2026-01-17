@extends('layouts.app')

@section('title', 'Petugas Dashboard')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-24">
        <!-- Header -->
        <header class="bg-deisa-blue px-6 pt-8 pb-20 rounded-b-[2.5rem] relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full blur-3xl -mr-10 -mt-10"></div>
            <div class="relative z-10 flex justify-between items-center mb-4">
                <div>
                    <div class="text-blue-200 text-sm">Assalamu'alaikum,</div>
                    <div class="text-white text-xl font-bold">Fatimah Az-Zahra</div>
                </div>
                <div class="w-10 h-10 rounded-full bg-white/20 border border-white/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                </div>
            </div>
        </header>

        <!-- Quick Stats -->
        <div class="px-6 -mt-12 mb-8 relative z-10">
            <div class="bg-white rounded-2xl shadow-xl p-6 flex justify-between items-center">
                <div>
                    <div class="text-sm text-slate-500 mb-1">Pasien Hari Ini</div>
                    <div class="text-3xl font-bold text-slate-800">12</div>
                </div>
                <div class="h-10 w-px bg-slate-200"></div>
                <div>
                    <div class="text-sm text-slate-500 mb-1">Perlu Tindakan</div>
                    <div class="text-3xl font-bold text-deisa-green">3</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="px-6 mb-8">
            <h3 class="font-bold text-slate-800 mb-4 px-1">Menu Cepat</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('user.sakit.create') }}"
                    class="bg-deisa-blue text-white p-5 rounded-2xl shadow-lg shadow-blue-500/20 active:scale-95 transition-transform flex flex-col items-center justify-center gap-3">
                    <div class="bg-white/20 p-3 rounded-full">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Input Sakit</span>
                </a>
                <a href="{{ route('user.obat.list') }}"
                    class="bg-white text-slate-700 p-5 rounded-2xl shadow-sm border border-slate-100 active:scale-95 transition-transform flex flex-col items-center justify-center gap-3">
                    <div class="bg-blue-50 p-3 rounded-full text-deisa-blue">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <span class="font-semibold">Lihat Obat</span>
                </a>
            </div>
        </div>

        <!-- Recent List -->
        <div class="px-6">
            <div class="flex justify-between items-center mb-4 px-1">
                <h3 class="font-bold text-slate-800">Pasien Terakhir</h3>
                <a href="#" class="text-sm text-deisa-blue font-medium">Lihat Semua</a>
            </div>
            <div class="bg-white rounded-2xl p-2 shadow-sm border border-slate-100 space-y-2">
                @forelse($recentPatients ?? [] as $sakit)
                    <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-lg">🤕</div>
                        <div class="flex-1">
                            <h4 class="font-bold text-slate-800 text-sm">{{ $sakit->santri?->nama_lengkap ?? 'Unknown' }}</h4>
                            <div class="text-xs text-slate-500">{{ Str::limit($sakit->diagnosis_utama, 20) }} •
                                {{ $sakit->santri?->kelas?->nama_kelas ?? 'N/A' }}</div>
                        </div>
                        <span
                            class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $sakit->status == 'darurat' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }}">{{ ucfirst($sakit->status) }}</span>
                    </div>
                @empty
                    <div class="p-4 text-center text-slate-500 text-sm">Belum ada pasien hari ini.</div>
                @endforelse
            </div>
        </div>

        <!-- Bottom Nav -->
        <nav
            class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 pb-safe pt-3 px-6 flex justify-between z-50">
            <a href="{{ route('user.dashboard') }}" class="flex flex-col items-center gap-1 text-deisa-blue">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span class="text-[10px] font-medium">Home</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-1 text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
                <span class="text-[10px] font-medium">Riwayat</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-1 text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-[10px] font-medium">Profil</span>
            </a>
        </nav>
    </div>
@endsection