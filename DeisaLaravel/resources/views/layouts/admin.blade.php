@extends('layouts.app')

@section('content')
    <div class="flex h-screen bg-white overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col flex-shrink-0 z-30 ">
            <div class="h-16 flex items-center px-6 border-b border-slate-200">
                <x-logo size="sm" />
                <span class="font-bold text-slate-900 text-lg tracking-tight ml-3">Deisa Admin</span>
            </div>

            <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                <div class="px-4 py-2 text-[10px] font-black text-slate-500 uppercase tracking-widest flex items-center">
                    <span>Main Menu</span>
                </div>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-deisa-blue' : 'text-slate-500 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.santri.index') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.santri.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.santri.*') ? 'text-deisa-blue' : 'text-slate-500 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Data Santri
                </a>

                @if(auth()->user()->role === 'admin')
                    <div class="px-4 py-2 mt-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Master Data
                    </div>
                    <a href="{{ route('admin.kelas.index') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.kelas.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.kelas.*') ? 'text-deisa-blue' : 'text-slate-500 group-hover:text-slate-600' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Data Kelas
                    </a>

                    <a href="{{ route('admin.angkatan.index') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.angkatan.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.angkatan.*') ? 'text-deisa-blue' : 'text-slate-500 group-hover:text-slate-600' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Data Angkatan
                    </a>

                    <a href="{{ route('admin.jurusan.index') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.jurusan.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.jurusan.*') ? 'text-deisa-blue' : 'text-slate-400 group-hover:text-slate-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2" />
                        </svg>
                        Data Jurusan
                    </a>
                @endif

                <div class="px-4 py-2 mt-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Operation</div>
                <a href="{{ route('admin.akademik.index') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.akademik.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.akademik.*') ? 'text-deisa-blue' : 'text-slate-500 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Kenaikan Kelas
                </a>

                <a href="{{ route('admin.sakit.index') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.sakit.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.sakit.*') ? 'text-deisa-blue' : 'text-slate-500 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Riwayat Sakit
                </a>

                <a href="{{ route('admin.obat.index') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.obat.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.obat.*') ? 'text-deisa-blue' : 'text-slate-500 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Stok Obat
                </a>

                <a href="{{ route('admin.laporan.index') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.laporan.*') ? 'text-deisa-blue' : 'text-slate-500 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Laporan Silang
                </a>

                @if(auth()->user()->role === 'admin')
                    <div class="px-4 py-2 mt-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">System
                        Management</div>
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.users.*') ? 'text-deisa-blue' : 'text-slate-500 group-hover:text-slate-600' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Manajemen User
                    </a>

                    <a href="{{ route('admin.activity.index') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.activity.*') ? 'bg-blue-50 text-deisa-blue' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.activity.*') ? 'text-deisa-blue' : 'text-slate-500 group-hover:text-slate-600' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Activity Log
                    </a>
                @endif
            </nav>

            <style>
                [x-cloak] {
                    display: none !important;
                }
            </style>

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
                    <button class="md:hidden mr-4 text-slate-600 hover:text-slate-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div>
                        @yield('header')
                    </div>
                </div>
                <div class="flex items-center gap-4" x-data="{}">
                    <!-- Daily Summary Global Trigger -->
                    <button @click="$dispatch('open-focus-mode')"
                        class="flex items-center gap-2 px-4 py-2 bg-deisa-blue hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-blue-500/10 group">
                        <svg class="w-4 h-4 text-blue-400 group-hover:scale-110 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="hidden lg:inline">Summary Harian</span>
                    </button>

                    <!-- Notification Bell -->
                    <div x-data="notifications()" @refresh-reminders.window="fetchReminders()" class="relative">
                        <button @click="open = !open"
                            class="p-2 text-slate-400 hover:text-slate-600 rounded-full hover:bg-slate-100 relative transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            <span x-show="count > 0" class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="absolute right-0 mt-4 w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden z-50">
                            <div class="p-4 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                                <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Reminders</span>
                                <span class="bg-blue-100 text-deisa-blue text-[10px] px-2 py-0.5 rounded-full font-bold"
                                    x-text="count + ' Active'"></span>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                <template x-if="items.length === 0">
                                    <div class="p-8 text-center">
                                        <div class="text-2xl mb-2 text-slate-300">✨</div>
                                        <p class="text-slate-400 text-xs font-medium">All clear! No reminders.</p>
                                    </div>
                                </template>
                                <template x-for="item in items" :key="item.id">
                                    <div
                                        class="p-4 border-b border-slate-50 hover:bg-slate-50 transition-colors flex gap-3">
                                        <div class="flex-1">
                                            <div class="text-sm font-bold text-slate-900" x-text="item.title"></div>
                                            <div class="text-[10px] text-slate-400 mt-1" x-text="item.message"></div>
                                        </div>
                                        <button @click="dismiss(item.id)" class="text-slate-300 hover:text-emerald-500">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <script>
                        function notifications() {
                            return {
                                open: false,
                                items: [],
                                count: 0,
                                async fetchReminders() {
                                    try {
                                        const res = await fetch('{{ route('api.reminders.index') }}');
                                        const json = await res.json();
                                        this.items = json.data;
                                        this.count = this.items.length;
                                    } catch (e) { console.error(e); }
                                },
                                async dismiss(id) {
                                    try {
                                        const res = await fetch('{{ route('api.reminders.dismiss', ':id') }}'.replace(':id', id), {
                                            method: 'POST',
                                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                        });
                                        if (res.ok) this.fetchReminders();
                                    } catch (e) { console.error(e); }
                                },
                                init() {
                                    this.fetchReminders();
                                    setInterval(() => this.fetchReminders(), 30000); // Check every 30s
                                }
                            }
                        }
                    </script>

                    <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-slate-500">{{ ucfirst(auth()->user()->role) }}</div>
                        </div>
                        <a href="{{ route('profile.index') }}"
                            class="w-10 h-10 rounded-full bg-slate-200 border-2 border-white shadow-sm overflow-hidden">
                            @if(auth()->user()->profile?->avatar)
                                <img src="{{ Storage::url(auth()->user()->profile->avatar) }}"
                                    class="w-full h-full object-cover">
                            @else
                                <svg class="w-full h-full text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            @endif
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-slate-50/50 p-6 md:p-8">
                @yield('admin-content')
            </main>
        </div>
    </div>

    @include('components.focus-mode')
@endsection