@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-deisa-blue p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center mb-4 transition-transform hover:scale-105 duration-300">
                <x-logo size="lg" variant="light" />
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Buat Password Baru</h1>
            <p class="text-blue-100 mt-2">Masukkan password baru untuk akun Anda.</p>
        </div>

        <x-card class="backdrop-blur-sm bg-white/95 border-0 shadow-xl">
            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $email) }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue transition-all"
                        placeholder="admin@deisa.com" required>
                    @error('email')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Password Baru</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue transition-all"
                        placeholder="Minimal 8 karakter" required>
                    @error('password')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue transition-all"
                        placeholder="Ulangi password baru" required>
                </div>

                <x-button class="w-full py-2.5 text-base shadow-lg shadow-blue-500/30">
                    Simpan Password Baru
                </x-button>
            </form>
        </x-card>
    </div>
</div>
@endsection

