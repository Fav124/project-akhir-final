@extends('layouts.app')

@section('title', 'Profil Petugas')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-24 max-w-lg md:max-w-5xl mx-auto">
        <!-- Header -->
        <header class="bg-white px-6 py-6 border-b border-slate-100 sticky top-0 z-30 flex items-center gap-4 shadow-sm">
            <a href="{{ route('user.dashboard') }}" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-slate-800 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="font-black text-slate-800 text-xl tracking-tight">Akun Petugas</h1>
        </header>

        <div class="p-6">
            <!-- Profile Info Card -->
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm text-center mb-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full -mr-10 -mt-10"></div>
                <div class="w-24 h-24 bg-gradient-to-br from-deisa-blue to-indigo-600 rounded-[2rem] flex items-center justify-center text-white text-3xl font-black mx-auto mb-4 shadow-xl shadow-blue-500/30">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <h2 class="text-2xl font-black text-slate-800">{{ auth()->user()->name }}</h2>
                <p class="text-slate-400 font-medium mb-6">{{ auth()->user()->email }}</p>
                
                <div class="flex items-center justify-center gap-2">
                    <span class="px-3 py-1 bg-blue-50 text-deisa-blue text-[10px] font-black uppercase tracking-widest rounded-full border border-blue-100">
                        {{ auth()->user()->role }}
                    </span>
                    <span class="px-3 py-1 bg-emerald-50 text-emerald-500 text-[10px] font-black uppercase tracking-widest rounded-full border border-emerald-100">
                        Aktif
                    </span>
                </div>
            </div>

            <!-- Settings Group -->
            <div class="space-y-4">
                <h3 class="px-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Pengaturan Akun</h3>
                
                <a href="#" class="flex items-center gap-4 bg-white p-5 rounded-3xl border border-slate-50 hover:border-blue-100 hover:shadow-md transition-all group">
                    <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-blue-50 group-hover:text-deisa-blue transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-slate-800">Detail Personal</div>
                        <div class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">Update info profil</div>
                    </div>
                    <svg class="w-5 h-5 text-slate-300 group-hover:text-deisa-blue transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('profile.index') }}" class="flex items-center gap-4 bg-white p-5 rounded-3xl border border-slate-50 hover:border-blue-100 hover:shadow-md transition-all group">
                    <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-blue-50 group-hover:text-deisa-blue transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.172-1.172a2 2 0 012.828 0l2.828 2.828a2 2 0 010 2.828l-1.172 1.172m-2.828-2.828l-8.486 8.485" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-slate-800">Tampilan & Tema</div>
                        <div class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">Ubah warna aplikasi</div>
                    </div>
                    <svg class="w-5 h-5 text-slate-300 group-hover:text-deisa-blue transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('profile.index') }}" class="flex items-center gap-4 bg-white p-5 rounded-3xl border border-slate-50 hover:border-blue-100 hover:shadow-md transition-all group">
            </div>

            <!-- Danger Zone -->
            <div class="mt-12">
                <form action="{{ route('user.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-rose-50 text-rose-600 p-6 rounded-[2rem] border border-rose-100 font-black text-sm tracking-widest uppercase hover:bg-rose-600 hover:text-white transition-all shadow-xl shadow-rose-900/5 hover:shadow-rose-500/20 active:scale-95">
                        Keluar Aplikasi
                    </button>
                </form>
            </div>
            
            <div class="mt-8 text-center px-8">
                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em] mb-1">Deisa Health System v2.0</p>
                <p class="text-[10px] text-slate-200 font-medium">Focused for Better Student Wellbeing</p>
            </div>
        </div>

        <!-- Mobile Glass Bottom Nav -->
        <div class="fixed bottom-6 left-6 right-6 z-50 md:hidden">
            <nav class="glass-effect rounded-[2rem] border border-white/40 shadow-2xl p-2 flex justify-around items-center">
                <a href="{{ route('user.dashboard') }}" 
                    class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl text-slate-400 hover:bg-slate-50 transition-all">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </a>
                <a href="{{ route('user.sakit.create') }}" 
                    class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl text-slate-400 hover:bg-slate-50 transition-all">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </a>
                <a href="{{ route('user.obat.list') }}" 
                    class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl text-slate-400 hover:bg-slate-50 transition-all">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </a>
                <a href="{{ route('profile.index') }}" 
                    class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl bg-deisa-blue text-white shadow-lg shadow-blue-500/40">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </a>
            </nav>
        </div>
    </div>
@endsection
