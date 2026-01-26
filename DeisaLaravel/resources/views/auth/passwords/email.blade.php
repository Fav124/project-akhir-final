@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-deisa-blue p-4">
    <div class="w-full max-w-md">
        <!-- Brand -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 text-white text-3xl font-bold mb-4 backdrop-blur-sm border border-white/20 shadow-lg">
                D
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Setel Ulang Password</h1>
            <p class="text-blue-100 mt-2">Gunakan email yang terdaftar</p>
        </div>

        <x-card class="backdrop-blur-sm bg-white/95 border-0 shadow-xl">
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-emerald-700 bg-emerald-50 rounded-lg border border-emerald-100">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue transition-all"
                        placeholder="admin@deisa.com" required>
                    @error('email')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <x-button class="w-full py-2.5 text-base shadow-lg shadow-blue-500/30">
                    Kirim Permintaan Reset
                </x-button>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                <a href="{{ route('login') }}" class="text-sm font-medium text-deisa-blue hover:text-blue-700 transition-colors flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Login
                </a>
            </div>
        </x-card>
    </div>
</div>
@endsection
