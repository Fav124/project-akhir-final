<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50 dark:bg-gray-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Deisa') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }
        
        /* Glassmorphism Utilities */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .dark .glass {
            background: rgba(30, 41, 59, 0.7);
        }

        .material-symbols-outlined {
            font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24
        }
        .material-symbols-outlined.filled {
            font-variation-settings:
            'FILL' 1,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-600 dark:text-slate-300">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex overflow-hidden">
        
        <!-- Sidebar Backdrop -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/80 z-40 lg:hidden glass"></div>

        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-slate-800 shadow-xl transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col border-r border-slate-200 dark:border-slate-700">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-center h-20 shadow-sm border-b border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 z-10">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-gradient-to-br from-blue-600 to-slate-800 flex items-center justify-center shadow-lg shadow-blue-500/30 text-white font-bold text-xl">D</div>
                    <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-700 to-slate-800 dark:from-blue-400 dark:to-blue-200 font-outfit">DEISA</span>
                </a>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
                <p class="px-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Main</p>
                
                <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 shadow-sm ring-1 ring-blue-200 dark:ring-blue-700' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-white' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('dashboard') ? 'filled' : '' }} mr-3 text-[22px]" style="{{ request()->routeIs('dashboard') ? 'color: currentColor' : '' }}">dashboard</span>
                    Dashboard
                </a>

                <a href="{{ route('web.laporan.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('web.laporan.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 shadow-sm ring-1 ring-blue-200 dark:ring-blue-700' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-white' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('web.laporan.*') ? 'filled' : '' }} mr-3 text-[22px]">analytics</span>
                    Laporan Health
                </a>

                <p class="px-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-6 mb-2">Management</p>

                <a href="{{ route('web.santri.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('web.santri.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 shadow-sm ring-1 ring-blue-200 dark:ring-blue-700' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-white' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('web.santri.*') ? 'filled' : '' }} mr-3 text-[22px]">school</span>
                    Data Santri
                </a>

                <a href="{{ route('web.sakit.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('web.sakit.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 shadow-sm ring-1 ring-blue-200 dark:ring-blue-700' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-white' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('web.sakit.*') ? 'filled' : '' }} mr-3 text-[22px]">sick</span>
                    Santri Sakit
                </a>
                
                <a href="{{ route('web.obat.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('web.obat.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 shadow-sm ring-1 ring-blue-200 dark:ring-blue-700' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-white' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('web.obat.*') ? 'filled' : '' }} mr-3 text-[22px]">medication</span>
                    Stok Obat
                </a>

                <p class="px-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-6 mb-2">Master Data</p>

                <div x-data="{ open: {{ request()->routeIs('web.kelas.*', 'web.jurusan.*', 'web.diagnosis.*', 'web.master.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" type="button" class="group w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-white">
                        <span class="flex items-center">
                            <span class="material-symbols-outlined mr-3 text-[22px]">database</span>
                            Master Data Hub
                        </span>
                        <span class="material-symbols-outlined text-slate-400 transition-transform duration-200 text-[18px]" :class="open ? 'rotate-90' : ''">chevron_right</span>
                    </button>
                    <div x-show="open" class="space-y-1 pl-11" style="display: none;">
                        <a href="{{ route('web.kelas.index') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('web.kelas.*') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }}">Data Kelas</a>
                        <a href="{{ route('web.jurusan.index') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('web.jurusan.*') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }}">Data Jurusan</a>
                        <a href="{{ route('web.diagnosis.index') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('web.diagnosis.*') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }}">Data Diagnosis</a>
                    </div>
                </div>

                <p class="px-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-6 mb-2">Admin</p>

                <div x-data="{ open: {{ request()->routeIs('web.admin.*') ? 'true' : 'false' }} }" class="space-y-1">
                     <button @click="open = !open" type="button" class="group w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-white">
                        <span class="flex items-center">
                            <span class="material-symbols-outlined mr-3 text-[22px]">admin_panel_settings</span>
                            Administrator
                        </span>
                        <span class="material-symbols-outlined text-slate-400 transition-transform duration-200 text-[18px]" :class="open ? 'rotate-90' : ''">chevron_right</span>
                    </button>
                     <div x-show="open" class="space-y-1 pl-11" style="display: none;">
                        <a href="{{ route('web.admin.registrations') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('web.admin.registrations') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }}">Approve Users</a>
                        <a href="{{ route('web.admin.users') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('web.admin.users') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }}">All Users</a>
                    </div>
                </div>

            </nav>
            
            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-slate-200 dark:border-slate-700">
                 <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-danger hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <span class="material-symbols-outlined mr-2 text-[20px]">logout</span>
                        Sign Out
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 bg-gray-50 dark:bg-gray-900">
            <!-- Topbar -->
            <header class="flex items-center justify-between h-20 px-6 border-b border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm z-10">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" type="button" class="lg:hidden p-2 -ml-2 mr-2 text-slate-500 hover:text-slate-600 rounded-md">
                        <span class="sr-only">Open sidebar</span>
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div>
                         @if(isset($header))
                             {{ $header }}
                        @else
                            <h1 class="text-2xl font-bold font-outfit text-slate-800 dark:text-white">@yield('title')</h1>
                             @if(isset($page_subtitle) || View::hasSection('subtitle'))
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">@yield('subtitle', $page_subtitle ?? '')</p>
                             @endif
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Notifications (Placeholder) -->
                    <button class="relative p-2 text-slate-400 hover:text-slate-500 dark:hover:text-slate-300 transition-colors rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <span class="sr-only">View notifications</span>
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute top-2 right-2 size-2 bg-red-500 rounded-full border-2 border-white dark:border-slate-800"></span>
                    </button>

                    <!-- Profile Dropdown (Simplified) -->
                    <div class="flex items-center gap-3 pl-4 border-l border-slate-200 dark:border-slate-700">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ Auth::user()->name ?? 'Guest User' }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ Auth::user()->email ?? 'guest@example.com' }}</p>
                        </div>
                        <div class="size-10 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 font-bold text-lg overflow-hidden">
                             @if(Auth::check())
                                {{ substr(Auth::user()->name, 0, 1) }}
                            @else
                                ?
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 lg:p-8">
                 <!-- Flash Messages -->
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="mb-6 rounded-xl bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 p-4 flex items-start gap-3 shadow-sm">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400 mt-0.5">check_circle</span>
                        <div>
                            <h3 class="text-sm font-medium text-green-800 dark:text-green-300">Success</h3>
                            <p class="text-sm text-green-700 dark:text-green-400 mt-1">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="ml-auto text-green-500 hover:text-green-600">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 p-4 flex items-start gap-3 shadow-sm">
                        <span class="material-symbols-outlined text-red-600 dark:text-red-400 mt-0.5">error</span>
                        <div>
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-300">Error</h3>
                            <p class="text-sm text-red-700 dark:text-red-400 mt-1">{{ session('error') }}</p>
                        </div>
                         <button @click="show = false" class="ml-auto text-red-500 hover:text-red-600">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </button>
                    </div>
                @endif
                
                @if ($errors->any())
                     <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 p-4 flex items-start gap-3 shadow-sm">
                        <span class="material-symbols-outlined text-red-600 dark:text-red-400 mt-0.5">warning</span>
                        <div>
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-300">There were some problems</h3>
                            <ul class="mt-2 list-disc list-inside text-sm text-red-700 dark:text-red-400 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                         <button @click="show = false" class="ml-auto text-red-500 hover:text-red-600">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </button>
                    </div>
                @endif

                @yield('content')
                {{ $slot ?? '' }}
            </main>
        </div>
    </div>
    @livewireScripts
</body>
</html>
