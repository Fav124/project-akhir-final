@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-deisa-blue p-4">
        <div class="w-full max-w-md">
            <!-- Brand -->
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 text-white text-3xl font-bold mb-4 backdrop-blur-sm border border-white/20 shadow-lg">
                    <img src="" alt="">
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

                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label class="block text-sm font-medium text-slate-700">Password</label>
                            <a href="#" class="text-sm text-deisa-blue hover:text-blue-700 font-medium">Lupa Password?</a>
                        </div>
                        <input type="password" name="password"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue transition-all"
                            placeholder="••••••••" required>
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