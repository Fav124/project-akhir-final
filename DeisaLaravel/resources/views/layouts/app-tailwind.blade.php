<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEISA - @yield('title', 'Sistem Manajemen Kesehatan')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <style>
        body {
            background-color: #f1f5f9; /* Slate-100 for better contrast with white cards */
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
        }

        .glass-sidebar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(30px);
            border-right: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 10px 0 40px -10px rgba(0, 0, 0, 0.04);
        }

        .nav-gradient-active {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(20, 184, 166, 0.1) 100%);
            position: relative;
        }

        .nav-gradient-active::after {
            content: '';
            position: absolute;
            left: 0;
            top: 25%;
            height: 50%;
            width: 4px;
            background: #10b981;
            border-radius: 0 4px 4px 0;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
            100% { transform: translateY(0px); }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .text-display {
            font-family: 'Outfit', sans-serif;
        }

        /* Animations */
        @keyframes slideInDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .animate-slide-in-down {
            animation: slideInDown 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 selection:bg-emerald-100 selection:text-emerald-900">
    <div class="min-h-screen text-slate-900 overflow-x-hidden relative">
        <!-- Premium Mesh Gradients -->
        <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-emerald-100/40 rounded-full blur-[120px] animate-float-soft"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-100/30 rounded-full blur-[120px] animate-float-soft" style="animation-delay: -2s"></div>
            <div class="absolute top-[30%] right-[10%] w-[20%] h-[20%] bg-rose-100/20 rounded-full blur-[100px] animate-float-soft" style="animation-delay: -5s"></div>
        </div>

        <div class="relative z-10 flex h-full">
        <!-- Sidebar -->
        <aside class="w-72 glass-sidebar fixed h-screen z-50 transition-all duration-500 overflow-hidden">
            <div class="flex flex-col h-full">
                <!-- Brand -->
                <div class="p-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-xl shadow-emerald-200 group-hover:scale-110 transition-transform duration-500">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-2xl font-black tracking-tighter text-display text-gray-900 leading-none">DEISA</span>
                            <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest mt-1">Health Hub</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 space-y-8 overflow-y-auto pt-4 pb-10">
                    <!-- Main Group -->
                    <div class="space-y-1">
                        <h3 class="px-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Core Management</h3>
                        
                        <x-nav-link-premium href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="dashboard">
                            Dashboard
                        </x-nav-link-premium>

                        <x-nav-link-premium href="{{ route('web.laporan.index') }}" :active="request()->routeIs('web.laporan.index')" icon="laporan">
                            Analytics Hub
                        </x-nav-link-premium>

                        <x-nav-link-premium href="{{ route('web.santri.index') }}" :active="request()->routeIs('web.santri.*')" icon="santri">
                            Data Santri
                        </x-nav-link-premium>

                        <x-nav-link-premium href="{{ route('web.obat.index') }}" :active="request()->routeIs('web.obat.*')" icon="obat">
                            Inventaris Obat
                        </x-nav-link-premium>

                        <x-nav-link-premium href="{{ route('web.sakit.index') }}" :active="request()->routeIs('web.sakit.*')" icon="sakit">
                            Catatan Medis
                        </x-nav-link-premium>
                    </div>

                    <!-- Master Group -->
                    <div class="space-y-1">
                        <h3 class="px-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Master Systems</h3>
                        
                        <x-nav-link-premium href="{{ route('web.master.hub') }}" :active="request()->routeIs('web.master.hub')" icon="master">
                            Master Data Hub
                        </x-nav-link-premium>
                    </div>

                    <!-- Admin Group -->
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <div class="space-y-1">
                        <h3 class="px-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Administration</h3>
                        
                        <x-nav-link-premium href="{{ route('web.admin.registrations') }}" :active="request()->routeIs('web.admin.registrations')" icon="registration">
                            Registrasi Baru
                        </x-nav-link-premium>

                        <x-nav-link-premium href="{{ route('web.admin.users') }}" :active="request()->routeIs('web.admin.users')" icon="users">
                            Manajemen User
                        </x-nav-link-premium>
                    </div>
                    @endif
                </nav>

                <!-- User Profile & Logout -->
                <div class="p-4 border-t border-gray-100/50">
                    <div class="p-4 rounded-3xl bg-gray-50/50 flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center text-gray-600 font-black text-xs">
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-black text-gray-900 truncate tracking-tight">{{ Auth::user()->name ?? 'Guest User' }}</p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest truncate">{{ Auth::user()->role ?? 'Visitor' }}</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full h-12 rounded-2xl flex items-center justify-center gap-2 text-rose-500 font-black text-[10px] uppercase tracking-[0.2em] hover:bg-rose-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Secure Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="ml-72 flex-1 min-h-screen relative z-10">
            <!-- Top Bar -->
            <header class="h-24 px-10 flex items-center justify-between sticky top-0 bg-gray-50/50 backdrop-blur-xl z-40 border-b border-gray-100/50">
                <div class="flex items-center gap-4">
                    <div class="w-1.5 h-8 bg-emerald-500 rounded-full"></div>
                    <div>
                        <h2 class="text-xl font-black text-display text-gray-900 tracking-tight">@yield('page_title', 'Overview')</h2>
                        <div class="flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">
                            <span>Deisa</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span class="text-emerald-500">@yield('page_subtitle', 'Dashboard')</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <!-- Global Search Button -->
                    <button class="w-12 h-12 rounded-2xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-gray-400 hover:text-emerald-500 hover:border-emerald-100 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                    
                    <!-- Notification Button -->
                    <button class="relative w-12 h-12 rounded-2xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-gray-400 hover:text-emerald-500 hover:border-emerald-100 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute top-3 right-3 w-2 h-2 bg-rose-500 rounded-full border-2 border-white"></span>
                    </button>
                </div>
            </header>

            <!-- Page Content -->
            <div class="px-10 py-10 pb-24">
                @if(session('success'))
                    <x-alert-premium type="success" :message="session('success')" />
                @endif
                
                @if(session('error'))
                    <x-alert-premium type="error" :message="session('error')" />
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @livewireScripts
</body>
</html>
