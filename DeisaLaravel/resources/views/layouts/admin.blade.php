@extends('layouts.app')

@section('content')
    <div class="flex h-screen bg-slate-50 overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col flex-shrink-0 z-30">
            <div class="h-16 flex items-center px-6 border-b border-slate-200">
                <div
                    class="w-8 h-8 rounded-lg bg-deisa-blue flex items-center justify-center text-white font-bold mr-3 shadow-md shadow-blue-500/20">
                    D</div>
                <span class="font-bold text-slate-800 text-lg tracking-tight">Deisa Admin</span>
            </div>

            <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-deisa-blue' : 'text-slate-400 group-hover:text-slate-500' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.santri.index') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.santri.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.santri.*') ? 'text-deisa-blue' : 'text-slate-400 group-hover:text-slate-500' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Data Santri
                </a>

                @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.kelas.index') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.kelas.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.kelas.*') ? 'text-deisa-blue' : 'text-slate-400 group-hover:text-slate-500' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Data Kelas
                </a>

                <a href="{{ route('admin.jurusan.index') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.jurusan.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.jurusan.*') ? 'text-deisa-blue' : 'text-slate-400 group-hover:text-slate-500' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2" />
                    </svg>
                    Data Jurusan
                </a>
                @endif

                <a href="{{ route('admin.sakit.index') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.sakit.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.sakit.*') ? 'text-deisa-blue' : 'text-slate-400 group-hover:text-slate-500' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Riwayat Sakit
                </a>

                <a href="{{ route('admin.obat.index') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.obat.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.obat.*') ? 'text-deisa-blue' : 'text-slate-400 group-hover:text-slate-500' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Stok Obat
                </a>

                <a href="{{ route('admin.laporan.index') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.laporan.*') ? 'text-deisa-blue' : 'text-slate-400 group-hover:text-slate-500' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Laporan & Analitik
                </a>

                @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.users.*') ? 'text-deisa-blue' : 'text-slate-400 group-hover:text-slate-500' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Manajemen User
                </a>

                <a href="{{ route('admin.activity.index') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.activity.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.activity.*') ? 'text-deisa-blue' : 'text-slate-400 group-hover:text-slate-500' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Activity Log
                </a>
                @endif
            </nav>

            <div class="p-4 border-t border-slate-200">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-4 py-2 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50">
                        <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Topbar -->
            <header
                class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 z-20 sticky top-0">
                <div class="flex items-center">
                    <button class="md:hidden mr-4 text-slate-500 hover:text-slate-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div>
                        @yield('header')
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <button class="p-2 text-slate-400 hover:text-slate-600 rounded-full hover:bg-slate-100 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-slate-500">{{ ucfirst(auth()->user()->role) }}</div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-slate-200 border-2 border-white shadow-sm overflow-hidden">
                            <!-- Avatar placeholder -->
                            <svg class="w-full h-full text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-slate-50 p-6 md:p-8">
                <!-- Global Alerts -->
                <!-- Global Alerts -->
                @if(session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showAlert('success', "{{ session('success') }}");
                        });
                    </script>
                @endif

                @if(session('error'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showAlert('error', "{{ session('error') }}");
                        });
                    </script>
                @endif

                @if($errors->any())
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let messages = [];
                            @foreach($errors->all() as $error)
                                messages.push("{{ $error }}");
                            @endforeach
                            showAlert('error', messages.join('\n'));
                        });
                    </script>
                @endif

                @yield('admin-content')
            </main>
        </div>
    </div>
@endsection