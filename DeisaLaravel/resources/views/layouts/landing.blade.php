<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Deisa Health') }} - Solusi Kesehatan Pesantren Modern</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }

        .font-outfit {
            font-family: 'Outfit', sans-serif;
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .text-gradient {
            background: linear-gradient(135deg, #0284c7 0%, #0d9488 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Reveal Animations */
        .reveal {
            opacity: 0;
            filter: blur(5px);
            transition: all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
        }
        .reveal-up { transform: translateY(40px); }
        .reveal-down { transform: translateY(-40px); }
        .reveal-left { transform: translateX(40px); }
        .reveal-right { transform: translateX(-40px); }
        
        .reveal.active {
            opacity: 1;
            filter: blur(0);
            transform: translate(0, 0);
        }

        /* Smooth Scroll Padding */
        :target {
            scroll-margin-top: 100px;
        }

        [x-cloak] { display: none !important; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Intersection Observer for Reveal Animations
            const observerOptions = {
                threshold: 0.15,
                rootMargin: "0px 0px -50px 0px"
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        // Optional: unobserve after active
                        // observer.unobserve(entry.target);
                    } else {
                        // Remove active to allow re-animation when scrolling back up
                        entry.target.classList.remove('active');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

            // Smooth Scroll for Internal Links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        const offset = 80; // Header height
                        const bodyRect = document.body.getBoundingClientRect().top;
                        const elementRect = targetElement.getBoundingClientRect().top;
                        const elementPosition = elementRect - bodyRect;
                        const offsetPosition = elementPosition - offset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                        
                        // Close mobile menu if open
                        // This assumes Alpine.js is used for the menu but we handle it generally
                    }
                });
            });
        });
    </script>
</head>

<body class="bg-white text-slate-900 overflow-x-hidden">
    <!-- Navigation -->
    <nav x-data="{ open: false, atTop: true }" x-init="window.pageYOffset > 50 ? atTop = false : atTop = true"
        @scroll.window="window.pageYOffset > 50 ? atTop = false : atTop = true"
        :class="atTop ? 'bg-transparent py-6' : 'glass-header py-4'"
        class="fixed w-full z-50 transition-all duration-300">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex items-center justify-between">
                <a href="{{ route('landing') }}" class="flex items-center space-x-3 group">
                    <x-logo size="sm" variant="light" />
                    <span class="text-xl font-bold tracking-tight transition-colors"
                        :class="atTop ? 'text-white' : 'text-deisa-blue'">Deisa Health</span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-sm font-medium transition-colors"
                        :class="atTop ? 'text-white/90 hover:text-white' : 'text-slate-600 hover:text-deisa-blue'">Beranda</a>
                    <a href="#features" class="text-sm font-medium transition-colors"
                        :class="atTop ? 'text-white/90 hover:text-white' : 'text-slate-600 hover:text-deisa-blue'">Fitur</a>
                    <a href="#stats" class="text-sm font-medium transition-colors"
                        :class="atTop ? 'text-white/90 hover:text-white' : 'text-slate-600 hover:text-deisa-blue'">Statistik</a>
                    <a href="{{ route('login') }}" class="text-sm font-medium transition-colors"
                        :class="atTop ? 'text-white/90 hover:text-white' : 'text-slate-600 hover:text-deisa-blue'">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 rounded-full text-sm font-bold transition-all shadow-lg"
                        :class="atTop ? 'bg-white text-deisa-blue hover:bg-slate-50' : 'bg-deisa-blue text-white hover:bg-blue-600 shadow-blue-500/20'">
                        Mulai Sekarang
                    </a>
                </div>

                <!-- Mobile Toggle -->
                <button @click="open = !open" class="md:hidden transition-colors"
                    :class="atTop ? 'text-white' : 'text-slate-600'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            class="md:hidden bg-white border-b border-slate-100 absolute top-full left-0 w-full p-4 space-y-4 shadow-xl text-slate-600 font-medium">
            <a href="#home" class="block">Beranda</a>
            <a href="#features" class="block">Fitur</a>
            <a href="#stats" class="block">Statistik</a>
            <hr class="border-slate-100">
            <a href="{{ route('login') }}" class="block">Masuk</a>
            <a href="{{ route('register') }}" class="block text-deisa-blue font-bold">Daftar</a>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white pt-20 pb-10">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center space-x-3 mb-6">
                        <x-logo size="sm" variant="light" />
                        <span class="text-xl font-bold tracking-tight">Deisa Health</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed capitalize">
                        Solusi digital pengelolaan kesehatan santri di pesantren secara terpadu, cepat, dan akurat.
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-widest mb-6 text-slate-200">Navigasi</h4>
                    <ul class="space-y-4 text-sm text-slate-400">
                        <li><a href="#home" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#features" class="hover:text-white transition-colors">Fitur Utama</a></li>
                        <li><a href="#stats" class="hover:text-white transition-colors">Statistik</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-widest mb-6 text-slate-200">Legal</h4>
                    <ul class="space-y-4 text-sm text-slate-400">
                        <li><a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-widest mb-6 text-slate-200">Kontak</h4>
                    <ul class="space-y-4 text-sm text-slate-400">
                        <li class="flex items-center space-x-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>support@deisa.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div
                class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-slate-500">
                <p>&copy; 2026 Deisa Health. All rights reserved.</p>
                <p class="mt-4 md:mt-0">Didesain dengan <span class="text-red-500">❤</span> untuk Pesantren</p>
            </div>
        </div>
    </footer>
</body>

</html>