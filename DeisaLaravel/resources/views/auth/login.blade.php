@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-deisa-blue p-4">
        <div class="w-full max-w-md">
            <!-- Brand -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center mb-4 transition-transform hover:scale-105 duration-300">
                    <x-logo size="lg" variant="light" />
                </div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Deisa Health</h1>
                <p class="text-blue-100 mt-2">Sistem Informasi Kesehatan Santri</p>
            </div>

            <x-card class="backdrop-blur-sm bg-white/95 border-0 shadow-xl">
                <form action="{{ route('login') }}" method="POST" class="space-y-5" data-ajax="true">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue transition-all"
                            placeholder="admin@deisa.com" required>
                    </div>

                    <div x-data="{ show: false }">
                        <div class="flex justify-between items-center mb-1.5">
                            <label class="block text-sm font-medium text-slate-700">Password</label>
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-deisa-blue hover:text-blue-700 font-medium">Lupa Password?</a>
                        </div>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" name="password"
                                class="w-full pl-4 pr-11 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue transition-all"
                                placeholder="••••••••" required>
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-deisa-blue transition-colors">
                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.888 9.888L2 2l1.414 1.414 18.586 18.586-1.414 1.414-2.227-2.227" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember"
                            class="w-4 h-4 text-deisa-blue border-slate-300 rounded focus:ring-blue-500">
                        <label for="remember" class="ml-2 text-sm text-slate-600">Ingat Saya</label>
                    </div>

                    <x-button class="w-full py-2.5 text-base shadow-lg shadow-blue-500/30">
                        Masuk Aplikasi
                    </x-button>
                </form>

                <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                    <p class="text-sm text-slate-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                            class="font-medium text-deisa-blue hover:text-blue-700 transition-colors">
                            Daftar Akun Baru
                        </a>
                    </p>
                </div>
            </x-card>

            <p class="text-center text-blue-200 text-sm mt-8">
                &copy; {{ date('Y') }} Dar El-Ilmi. All rights reserved.
            </p>
        </div>
    </div>
@endsection