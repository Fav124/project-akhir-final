<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEISA - Health Management Ecosystem</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            overflow-x: hidden;
        }

        .text-display {
            font-family: 'Outfit', sans-serif;
        }

        .mesh-gradient {
            background: radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.1) 0, transparent 50%),
                        radial-gradient(at 100% 100%, rgba(59, 130, 246, 0.1) 0, transparent 50%);
        }

        .bento-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.5);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .bento-card:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: rgba(16, 185, 129, 0.3);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.05);
        }

        @keyframes slideUpFade {
            from { transform: translateY(40px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .animate-up {
            animation: slideUpFade 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
    </style>
</head>
<body class="antialiased mesh-gradient">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 h-24 z-50 flex items-center px-10">
        <div class="max-w-7xl w-full mx-auto flex items-center justify-between bg-white/50 backdrop-blur-2xl rounded-3xl border border-white/20 px-8 py-3 shadow-xl shadow-gray-200/20">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <span class="text-2xl font-black text-display tracking-tighter">DEISA</span>
            </div>
            
            <div class="hidden md:flex items-center gap-10">
                <a href="#features" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-emerald-500 transition-colors">Features</a>
                <a href="#about" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-emerald-500 transition-colors">About</a>
                <a href="#contact" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-emerald-500 transition-colors">Contact</a>
            </div>

            <a href="/login" class="px-8 py-3 rounded-2xl bg-gray-900 text-white font-black text-[10px] uppercase tracking-widest hover:bg-emerald-500 hover:shadow-xl hover:shadow-emerald-200 transition-all duration-500 transform active:scale-95">
                Admin Portal
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="min-h-screen flex flex-col items-center justify-center pt-32 px-10 relative">
        <div class="max-w-4xl text-center space-y-8 animate-up">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 border border-emerald-100 mb-4">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600">Enterprise Ready</span>
            </div>
            
            <h1 class="text-6xl md:text-8xl font-black text-display text-gray-900 leading-[0.9] tracking-tighter">
                Sistem Kesehatan <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-blue-600">Terpadu Digital.</span>
            </h1>
            
            <p class="text-lg md:text-xl text-gray-500 font-medium max-w-2xl mx-auto leading-relaxed">
                Platform modern untuk pesantren cerdas. Kelola data santri, inventaris obat, dan laporan medis dalam satu ekosistem yang intuitif dan real-time.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                <a href="/dashboard" class="group px-10 py-5 rounded-3xl bg-emerald-500 text-white font-black text-[11px] uppercase tracking-[0.2em] shadow-2xl shadow-emerald-200 hover:bg-emerald-600 hover:shadow-emerald-300 transition-all duration-500 transform hover:-translate-y-1 active:scale-95 flex items-center gap-3">
                    Buka Dashboard
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                <a href="#" class="px-10 py-5 rounded-3xl bg-white border border-gray-100 text-gray-900 font-black text-[11px] uppercase tracking-[0.2em] shadow-xl shadow-gray-200/20 hover:bg-gray-50 transition-all duration-500">
                    Unduh Mobile App
                </a>
            </div>
        </div>

        <!-- Decorative Floating Elements -->
        <div class="absolute top-1/2 left-10 w-24 h-24 bg-emerald-500/10 rounded-full blur-3xl floating"></div>
        <div class="absolute bottom-1/4 right-10 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl floating" style="animation-delay: 1s"></div>
    </section>

    <!-- Bento Grid Features -->
    <section id="features" class="py-32 px-10 max-w-7xl mx-auto">
        <div class="text-center mb-20 space-y-4">
            <h2 class="text-4xl font-black text-display">Fitur Unggulan</h2>
            <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Teknologi Modern Untuk Pesantren Anda</p>
        </div>

        <div class="grid md:grid-cols-3 md:grid-rows-2 gap-6 h-[800px]">
            <!-- Main Feature -->
            <div class="md:col-span-2 bento-card rounded-[3rem] p-12 flex flex-col justify-end group">
                <div class="w-16 h-16 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 group-hover:rotate-12 transition-transform duration-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <h3 class="text-3xl font-black text-display mb-4">Analytics Real-time</h3>
                <p class="text-gray-500 font-medium max-w-md">Pantau tren kesehatan santri dengan visualisasi data yang cerdas dan mendalam setiap saat.</p>
            </div>

            <!-- Side Card 1 -->
            <div class="bento-card rounded-[3rem] p-10 flex flex-col justify-center bg-gray-900 text-white">
                <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="text-2xl font-black text-display mb-3 tracking-tight">Privasi Data Aman</h3>
                <p class="text-gray-400 text-sm font-medium leading-relaxed">Sistem keamanan enkripsi tingkat lanjut untuk melindungi rekam medis santri.</p>
            </div>

            <!-- Side Card 2 -->
            <div class="bento-card rounded-[3rem] p-10 flex flex-col justify-center">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-2xl font-black text-display mb-3 tracking-tight">Cloud Sync</h3>
                <p class="text-gray-500 text-sm font-medium leading-relaxed">Akses data kapan saja dan di mana saja melalui perangkat web maupun mobile app.</p>
            </div>

            <!-- Bottom Card -->
            <div class="md:col-span-2 bento-card rounded-[3rem] p-12 flex items-center gap-12 group overflow-hidden relative">
                <div class="flex-1 space-y-4 relative z-10">
                    <h3 class="text-3xl font-black text-display">Management Obat Cerdas</h3>
                    <p class="text-gray-500 font-medium">Sistem peringatan stok otomatis dan tracking inventaris medis yang presisi.</p>
                </div>
                <div class="absolute right-0 bottom-0 top-0 w-1/3 bg-gradient-to-l from-emerald-500 to-emerald-400 transform translate-x-12 skew-x-12"></div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-20 px-10 border-t border-gray-100">
        <div class="max-w-7xl mx-auto flex flex-col md:row items-center justify-between gap-10">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <span class="text-xl font-black text-display tracking-tighter">DEISA</span>
            </div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">© 2026 Deisa Ecosystem. Digital Healthcare for Pesantren.</p>
            <div class="flex gap-6">
                 <a href="#" class="text-gray-400 hover:text-emerald-500 transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                 <a href="#" class="text-gray-400 hover:text-emerald-500 transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
            </div>
        </div>
    </footer>
</body>
</html>
