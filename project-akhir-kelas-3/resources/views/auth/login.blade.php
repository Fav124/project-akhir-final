@extends('layouts.auth')

@section('title', 'Deisa - Login')

@section('content')
    <div class="flex min-h-screen w-full flex-row overflow-hidden">
        <!-- Left Side: Hero/Image Section -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-surface-dark items-center justify-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="w-full h-full bg-cover bg-center opacity-80 mix-blend-overlay"
                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAM1InwB68-F8Wj0tIHpv8UtU7PxEfjE6yUQawBU57mleT9e16Y0s52W9UTuNsch3H8X-mRzntrX9W3sSFKKP6F9Ie6epBu4vwLxEI4xfFcHg13uLAQVVYSTA3AcOYbHxMk9t48W_-8Gh1_BoqtMUONp9TNvG4q-U20KlWLabqlOxmRs5e2R72CE4RTQN1NKpzYX6k_pzL5JUXtpakcw-RU1b2WghvUd-HGlfMKo5dK1HPYmohDGWNjECLy8uPnKjAsMEMcAtlAMdWe");'>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-background-dark/90 via-background-dark/40 to-transparent">
                </div>
            </div>
            <div class="relative z-10 flex flex-col items-start justify-end h-full w-full p-16 pb-24">
                <div
                    class="mb-8 p-4 rounded-xl bg-primary/20 backdrop-blur-sm border border-primary/10 inline-flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-4xl">spa</span>
                </div>
                <h1 class="text-white text-5xl font-bold leading-tight tracking-tight max-w-lg mb-6">
                    Welcome Back, Santri!
                </h1>
                <p class="text-gray-200 text-lg font-medium leading-relaxed max-w-md">
                    Sistem Manajemen Kesehatan Santri Deisa. Pantau kesehatan dan stok obat dengan mudah.
                </p>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div
            class="flex w-full lg:w-1/2 flex-col justify-center items-center p-6 sm:p-12 lg:p-24 bg-background-light dark:bg-background-dark overflow-y-auto">
            <div class="w-full max-w-md flex flex-col gap-8">
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-3 text-text-main dark:text-white mb-2">
                        <div class="size-8 text-primary">
                            <svg class="w-full h-full" fill="none" viewBox="0 0 48 48"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M44 4H30.6666V17.3334H17.3334V30.6666H4V44H44V4Z" fill="currentColor"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold tracking-tight">Deisa</h2>
                    </div>
                    <h1 class="text-3xl font-bold text-text-main dark:text-white tracking-tight">Login ke Akun Anda</h1>
                    <p class="text-text-muted dark:text-gray-400 text-base">Selamat datang kembali! Silakan masukkan detail
                        login Anda.</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
                    @csrf

                    @if ($errors->any())
                        <div class="bg-red-50 text-error p-3 rounded-lg text-sm">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="flex flex-col gap-2">
                        <label class="text-text-main dark:text-gray-200 text-sm font-semibold leading-normal"
                            for="email">Email Address</label>
                        <input
                            class="form-input flex w-full rounded-lg border border-[#cfe7db] dark:border-gray-700 bg-surface-light dark:bg-surface-dark px-4 py-3 text-base text-text-main dark:text-white placeholder:text-text-muted dark:placeholder:text-gray-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary transition-colors h-12 @error('email') border-error @enderror"
                            id="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="user@example.com" type="email" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-text-main dark:text-gray-200 text-sm font-semibold leading-normal"
                            for="password">Password</label>
                        <div class="relative flex items-center">
                            <input
                                class="form-input flex w-full rounded-lg border border-[#cfe7db] dark:border-gray-700 bg-surface-light dark:bg-surface-dark px-4 py-3 pr-12 text-base text-text-main dark:text-white placeholder:text-text-muted dark:placeholder:text-gray-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary transition-colors h-12 @error('password') border-error @enderror"
                                id="password" name="password" required placeholder="Masukkan password" type="password" />
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <label class="inline-flex items-center">
                            <input type="checkbox"
                                class="form-checkbox text-primary border-gray-300 rounded focus:border-primary focus:ring focus:ring-offset-0 focus:ring-primary focus:ring-opacity-50"
                                name="remember">
                            <span class="ml-2 text-sm text-text-muted">Remember me</span>
                        </label>
                        <a class="text-primary hover:text-green-600 text-sm font-semibold hover:underline transition-colors"
                            href="#">Lupa Password?</a>
                    </div>

                    <button type="submit"
                        class="flex w-full cursor-pointer items-center justify-center rounded-lg bg-primary hover:bg-green-400 text-[#0d1b14] text-base font-bold h-12 px-6 transition-all active:scale-[0.98]">
                        Log In
                    </button>
                </form>

                <div class="text-center">
                    <p class="text-text-main dark:text-gray-300 text-sm">
                        Deisa Health Management System v1.0
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
