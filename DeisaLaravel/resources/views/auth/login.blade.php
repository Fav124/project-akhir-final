@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
    <div class="min-h-screen flex flex-col md:flex-row bg-white overflow-hidden">
        <!-- Left Side: Information & Branding -->
        <div class="relative hidden md:flex md:w-1/2 lg:w-3/5 bg-slate-900 items-center justify-center p-12 overflow-hidden">
            <!-- Background Decorative Elements -->
            <div class="absolute top-0 left-0 w-full h-full opacity-30 pointer-events-none">
                <div class="absolute -top-24 -left-20 w-[40rem] h-[40rem] rounded-full bg-deisa-blue blur-[120px]"></div>
                <div class="absolute bottom-1/4 -right-20 w-[30rem] h-[30rem] rounded-full bg-blue-500 blur-[100px]"></div>
                <div class="absolute inset-0 z-0 opacity-[0.05]" style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 32px 32px;"></div>
            </div>

            <div class="relative z-10 max-w-xl text-center md:text-left">
                <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white/10 border border-white/20 backdrop-blur-md mb-10 reveal reveal-up">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-400"></span>
                    </span>
                    <span class="text-white text-[10px] font-bold uppercase tracking-[0.2em]">Sistem Informasi Kesehatan Santri</span>
                </div>

                <div class="flex items-center gap-4 mb-8 reveal reveal-up" style="transition-delay: 100ms">
                    <x-logo size="lg" variant="light" />
                    <h1 class="text-4xl font-extrabold text-white tracking-tighter">DEISA</h1>
                </div>

                <h2 class="text-5xl lg:text-6xl font-extrabold text-white leading-[1.1] mb-8 reveal reveal-up" style="transition-delay: 200ms">
                    Kelola Kesehatan <span class="text-blue-400">Pesantren</span> Dengan Lebih Cerdas.
                </h2>

                <p class="text-slate-400 text-lg leading-relaxed mb-10 reveal reveal-up" style="transition-delay: 300ms">
                    Pantau kondisi santri secara real-time, kelola stok obat otomatis, dan buat laporan medis terintegrasi dalam satu platform profesional.
                </p>

                <div class="grid grid-cols-2 gap-6 reveal reveal-up" style="transition-delay: 400ms">
                    <div class="p-6 rounded-3xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <div class="text-blue-400 font-bold mb-1">Riwayat Terintegrasi</div>
                        <div class="text-slate-500 text-sm">Pencatatan medis santri yang rapi dan terukur.</div>
                    </div>
                    <div class="p-6 rounded-3xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <div class="text-blue-400 font-bold mb-1">Keamanan Data</div>
                        <div class="text-slate-500 text-sm">Privasi record kesehatan santri terjamin aman.</div>
                    </div>
                </div>
            </div>
            
            <!-- Floating Illustration Image (Placeholder logic) -->
            <div class="absolute -bottom-20 -right-20 w-96 h-96 opacity-20 pointer-events-none reveal reveal-left" style="transition-delay: 500ms">
                 <x-logo size="lg" variant="light" class="w-full h-full" />
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="flex-1 flex items-center justify-center p-8 lg:p-16 bg-white relative">
            <!-- Mobile Header (hidden on desktop) -->
            <div class="absolute top-8 left-8 md:hidden flex items-center gap-3">
                <x-logo size="md" variant="plain" />
                <span class="text-xl font-bold text-slate-900 tracking-tight">DEISA</span>
            </div>

            <div class="w-full max-w-md">
                <div class="mb-10">
                    <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-3">Selamat Datang Kembali!</h3>
                    <p class="text-slate-500">Silakan masuk menggunakan akun admin Anda untuk mengelola dashboard kesehatan.</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-6" data-ajax="true">
                    @csrf

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 tracking-tight">Email Address</label>
                        <div class="relative group">
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full pl-4 pr-4 py-3.5 rounded-2xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-deisa-blue transition-all duration-300"
                                placeholder="name@deisa.id" required autofocus>
                        </div>
                    </div>

                    <div x-data="{ show: false }" class="space-y-2">
                        <div class="flex justify-between items-center px-1">
                            <label class="block text-sm font-bold text-slate-700 tracking-tight">Password</label>
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-deisa-blue hover:text-blue-700 font-bold transition-colors">Lupa Password?</a>
                        </div>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" name="password"
                                class="w-full pl-4 pr-12 py-3.5 rounded-2xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-deisa-blue transition-all duration-300"
                                placeholder="••••••••" required>
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-deisa-blue transition-colors">
                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.888 9.888L2 2l1.414 1.414 18.586 18.586-1.414 1.414-2.227-2.227"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between px-1">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember"
                                class="w-5 h-5 text-deisa-blue border-slate-200 rounded-lg focus:ring-blue-500 transition-all cursor-pointer">
                            <label for="remember" class="ml-2.5 text-sm text-slate-600 font-medium cursor-pointer">Ingat Perangkat Saya</label>
                        </div>
                    </div>

                    <button type="submit" class="group relative w-full bg-slate-900 text-white py-4 rounded-2xl font-bold overflow-hidden transition-all shadow-xl shadow-slate-900/10 hover:-translate-y-1">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            Masuk Aplikasi
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </span>
                    </button>
                </form>

                <div class="mt-10 pt-10 border-t border-slate-100 flex flex-col items-center gap-4">
                    <p class="text-sm text-slate-500">
                        Belum memiliki akun admin?
                        <a href="{{ route('register') }}"
                            class="font-bold text-deisa-blue hover:text-blue-700 transition-colors">
                            Daftar Disini
                        </a>
                    </p>
                    <a href="{{ route('landing') }}" class="text-sm text-slate-400 hover:text-slate-600 transition-colors inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection