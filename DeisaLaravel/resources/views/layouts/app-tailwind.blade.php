<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEISA - @yield('title', 'Sistem Manajemen Kesehatan')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 fixed h-screen">
            <div class="flex flex-col h-full">
                <!-- Brand -->
                <div class="p-6 border-b border-gray-200">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <span class="text-lg font-semibold">DEISA</span>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <x-nav-link-premium href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="dashboard">
                        Beranda
                    </x-nav-link-premium>

                    <x-nav-link-premium href="{{ route('web.laporan.index') }}" :active="request()->routeIs('web.laporan.index')" icon="laporan">
                        Laporan
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

                    <x-nav-link-premium href="{{ route('web.master.hub') }}" :active="request()->routeIs('web.master.hub')" icon="master">
                        Data Master
                    </x-nav-link-premium>

                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <div class="pt-4 mt-4 border-t border-gray-200">
                        <x-nav-link-premium href="{{ route('web.admin.registrations') }}" :active="request()->routeIs('web.admin.registrations')" icon="registration">
                            Registrasi
                        </x-nav-link-premium>

                        <x-nav-link-premium href="{{ route('web.admin.users') }}" :active="request()->routeIs('web.admin.users')" icon="users">
                            Kelola Pengguna
                        </x-nav-link-premium>
                    </div>
                    @endif
                </nav>

                <!-- User Profile & Logout -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 text-sm font-medium">
                            {{ substr(Auth::user()->name ?? 'T', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name ?? 'Tamu' }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->role ?? 'Pengunjung' }}</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="ml-64 flex-1 min-h-screen">
            <!-- Top Bar -->
            <header class="bg-white border-b border-gray-200 px-6 py-4 sticky top-0 z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">@yield('page_title', 'Beranda')</h1>
                        @hasSection('page_subtitle')
                        <p class="text-sm text-gray-500 mt-1">@yield('page_subtitle')</p>
                        @endif
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-6">
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
