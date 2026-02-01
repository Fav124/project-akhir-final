@extends('layouts.app')

@section('title', 'Registrasi User Baru')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
            <div>
                <div class="flex justify-center">
                    <div
                        class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 rotate-3 group hover:rotate-6 transition-transform">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-slate-900 tracking-tight">Daftar Akun Baru</h2>
                <p class="mt-2 text-center text-sm text-slate-600">
                    Silakan isi data Anda untuk mendaftar
                </p>
            </div>

            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST" data-ajax="true">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                        <input id="name" name="name" type="text" required
                            class="mt-1 block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all"
                            placeholder="John Doe">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Alamat Email</label>
                        <input id="email" name="email" type="email" required
                            class="mt-1 block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all"
                            placeholder="email@anda.com">
                    </div>
                    <div x-data="{ show: false }">
                        <label for="password" class="block text-sm font-medium text-slate-700">Kata Sandi</label>
                        <div class="relative">
                            <input id="password" name="password" :type="show ? 'text' : 'password'" required
                                class="mt-1 block w-full pl-4 pr-11 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all"
                                placeholder="••••••••">
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-blue-600 transition-colors">
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
                    <div x-data="{ show: false }">
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Konfirmasi Kata
                            Sandi</label>
                        <div class="relative">
                            <input id="password_confirmation" name="password_confirmation"
                                :type="show ? 'text' : 'password'" required
                                class="mt-1 block w-full pl-4 pr-11 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all"
                                placeholder="••••••••">
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-blue-600 transition-colors">
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
                        <input id="request_admin" name="request_admin" type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                        <label for="request_admin" class="ml-2 block text-sm text-slate-900">
                            Daftar sebagai Admin (Memerlukan approval khusus)
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg shadow-blue-200 transition-all duration-200">
                        Daftar Sekarang
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-sm text-slate-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                            class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection