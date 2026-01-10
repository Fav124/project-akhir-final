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

                    <div class="relative flex py-2 items-center">
                        <div class="flex-grow border-t border-gray-200 dark:border-gray-700"></div>
                        <span class="flex-shrink-0 mx-4 text-text-muted dark:text-gray-500 text-sm">Or continue with</span>
                        <div class="flex-grow border-t border-gray-200 dark:border-gray-700"></div>
                    </div>

                    <a href="{{ route('auth.google') }}" 
                        class="flex w-full cursor-pointer items-center justify-center gap-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-gray-800 text-text-main dark:text-white text-base font-medium h-12 px-6 transition-all active:scale-[0.98]">
                        <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 24 24">
                            <path d="M12.0003 20.45c4.656 0 8.196-3.212 8.196-8.246 0-.756-.072-1.396-.204-1.92h-7.992v3.636h4.632c-.228 1.152-1.02 2.508-2.928 3.324l-.024.156 4.248 3.288.294.03c2.724-2.508 4.248-6.192 4.092-9.282H12.0003v3.636h4.632c-1.032 4.968-5.352 6.816-8.632 4.632l-1.632.852-2.964-1.62-.336-1.548c1.392 2.76 4.236 4.632 7.428 4.632z" fill="#4285F4"/>
                            <path d="M5.448 14.964c-.336-.984-.528-2.04-.528-3.144 0-1.008.192-1.968.48-2.88l-.024-.204-4.524-2.328-.228.144A10.66 10.66 0 0 0 .84 11.4c.036 2.376.924 4.548 2.376 6.276l2.064-1.284.168-1.428z" fill="#FBBC05"/>
                            <path d="M12.0003 4.752c2.436 0 4.14 1.056 5.076 1.944l2.832-2.832C17.916 2.064 15.204.84 12.0003.84 7.548.84 3.612 3.444 1.74 7.212l4.632 3.588c1.176-3.504 4.452-6.048 5.628-6.048z" fill="#EA4335"/>
                            <path d="M12.0003 19.608c-3.18 0-6.452-1.896-5.628-6.048l-4.632-3.588C4.668 15.6 8.532 19.608 11.964 19.644c3.432-.036 7.26-2.568 8.196-8.246h-8.16v3.636h4.632c-1.032 4.968-5.352 6.816-8.632 4.632z" fill="#34A853"/>
                        </svg>
                        Sign in with Google
                    </a>

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
