@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-24 max-w-lg md:max-w-5xl mx-auto">
        <header class="bg-white px-6 py-6 border-b border-slate-100 sticky top-0 z-30 flex items-center gap-4 shadow-sm">
            <a href="{{ route('user.dashboard') }}" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-slate-800 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="font-black text-slate-800 text-xl tracking-tight">Pengaturan Akun</h1>
                <p class="text-xs text-slate-500">Kelola data user, personalisasi aplikasi, dan keamanan akun</p>
            </div>
        </header>

        <div class="p-6 space-y-6">
            <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-blue-100/40"></div>
                <div class="relative flex flex-col md:flex-row md:items-center gap-4">
                    <div class="w-20 h-20 bg-gradient-to-br from-deisa-blue to-indigo-600 rounded-[1.5rem] flex items-center justify-center text-white text-2xl font-black shadow-lg shadow-blue-500/30">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-800">{{ auth()->user()->name }}</h2>
                        <p class="text-sm text-slate-500">{{ auth()->user()->email }}</p>
                        <div class="mt-2 inline-flex items-center px-3 py-1 bg-blue-50 text-deisa-blue text-[10px] font-black uppercase tracking-widest rounded-full border border-blue-100">
                            {{ auth()->user()->role }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <h3 class="px-1 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Navigasi Setting</h3>

                <a href="{{ route('profile.index', ['tab' => 'user']) }}" class="profile-hub-card group">
                    <div class="profile-hub-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-slate-800">Data User</div>
                        <div class="text-[11px] text-slate-500">Profil, kontak, dan informasi pribadi</div>
                    </div>
                    <svg class="w-5 h-5 text-slate-300 group-hover:text-deisa-blue transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('profile.index', ['tab' => 'personalization']) }}" class="profile-hub-card group">
                    <div class="profile-hub-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-slate-800">Personalisasi Aplikasi</div>
                        <div class="text-[11px] text-slate-500">Tema warna dan tampilan aplikasi</div>
                    </div>
                    <svg class="w-5 h-5 text-slate-300 group-hover:text-deisa-blue transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('profile.index', ['tab' => 'settings']) }}" class="profile-hub-card group">
                    <div class="profile-hub-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6.364-3.636l-1.414 1.414M18.364 13.364l1.414 1.414M6 12H4m16 0h-2M6.343 6.343L4.929 4.929m12.728 1.414l1.414-1.414M12 7V5m0 14v-2" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-slate-800">Pengaturan</div>
                        <div class="text-[11px] text-slate-500">Keamanan akun dan kata sandi</div>
                    </div>
                    <svg class="w-5 h-5 text-slate-300 group-hover:text-deisa-blue transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <form action="{{ route('user.logout') }}" method="POST" class="pt-2">
                @csrf
                <button type="submit" class="w-full bg-rose-50 text-rose-600 p-4 rounded-2xl border border-rose-100 font-black text-xs tracking-widest uppercase hover:bg-rose-600 hover:text-white transition-all">
                    Keluar Aplikasi
                </button>
            </form>
        </div>

        <div class="fixed bottom-6 left-6 right-6 z-50 md:hidden">
            <nav class="glass-effect rounded-[2rem] border border-white/40 shadow-2xl p-2 flex justify-around items-center">
                <a href="{{ route('user.dashboard') }}" class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl text-slate-400 hover:bg-slate-50 transition-all">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </a>
                <a href="{{ route('profile.index') }}" class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl bg-deisa-blue text-white shadow-lg shadow-blue-500/40">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </a>
            </nav>
        </div>
    </div>
@endsection
