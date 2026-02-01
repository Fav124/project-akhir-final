@extends('layouts.app')

@section('title', 'Petugas Dashboard')

@section('content')
    <div class="min-h-screen pb-24 bg-white">
        <!-- Header -->
        <header
            class="bg-blue-50 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 pt-10 pb-24 rounded-b-[3rem]">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-blue-400/20 rounded-full blur-2xl -ml-10 -mb-10"></div>

                <div class="relative z-10 flex justify-between items-start mb-6">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span
                                class="px-2 py-0.5 bg-white/20 rounded text-[10px] font-bold text-white uppercase tracking-wider">Petugas
                                Mode</span>
                        </div>
                        <div class="text-blue-100 text-sm opacity-80">Selamat bekerja,</div>
                        <div class="text-white text-2xl font-bold tracking-tight">{{ auth()->user()->name }}</div>
                    </div>
                    <div class="relative flex items-center gap-3" x-data="{ 
                            notifications: { open: false, items: [], count: 0 },
                            async fetchReminders() {
                                try {
                                    const res = await fetch('{{ route('api.reminders.index') }}');
                                    const json = await res.json();
                                    this.notifications.items = json.data;
                                    this.notifications.count = this.notifications.items.length;
                                } catch (e) { console.error(e); }
                            },
                            async dismiss(id) {
                                try {
                                    const res = await fetch('{{ route('api.reminders.dismiss', ':id') }}'.replace(':id', id), {
                                        method: 'POST',
                                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                    });
                                    if(res.ok) this.fetchReminders();
                                } catch (e) { console.error(e); }
                            }
                        }" x-init="fetchReminders(); setInterval(() => fetchReminders(), 30000)"
                        @refresh-reminders.window="fetchReminders()">
                        <!-- Daily Summary Button -->
                        <button @click="$dispatch('open-focus-mode')"
                            class="flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white rounded-xl text-sm font-bold transition-all backdrop-blur-md">
                            <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Summary Harian
                        </button>

                        <!-- Notification Bell -->
                        <div class="relative">
                            <button @click="notifications.open = !notifications.open"
                                class="w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center backdrop-blur-md hover:bg-white/20 transition-all relative">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                    </path>
                                </svg>
                                <span x-show="notifications.count > 0"
                                    class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full"></span>
                            </button>

                            <!-- Dropdown -->
                            <div x-show="notifications.open" @click.away="notifications.open = false" x-cloak
                                class="absolute right-0 mt-4 w-72 bg-white  rounded-2xl shadow-2xl border border-slate-100  overflow-hidden z-50 text-left ">
                                <div
                                    class="p-4 bg-slate-50  border-b border-slate-100 ">
                                    <span
                                        class="text-xs font-black text-slate-400  uppercase tracking-widest">Pengingat</span>
                                </div>
                                <div class="max-h-80 overflow-y-auto">
                                    <template x-if="notifications.items.length === 0">
                                        <div class="p-6 text-center">
                                            <p class="text-[10px] text-slate-400  font-bold uppercase">
                                                Tidak ada pengingat</p>
                                        </div>
                                    </template>
                                    <template x-for="item in notifications.items" :key="item.id">
                                        <div
                                            class="p-4 border-b border-slate-50  hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors flex gap-3">
                                            <div class="flex-1">
                                                <div class="text-xs font-bold text-slate-800 "
                                                    x-text="item.title"></div>
                                                <div class="text-[10px] text-slate-400 "
                                                    x-text="item.message"></div>
                                            </div>
                                            <button @click="dismiss(item.id)" class="text-slate-300 hover:text-emerald-500">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Desktop Logout -->
                        <div class="hidden md:block">
                            <form action="{{ route('user.logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-white text-sm font-bold transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-6 0v-1m6-10V5a3 3 0 00-6 0v1" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>

                        <!-- Refresh Stats Button -->
                        <button onclick="window.location.reload()"
                            class="w-11 h-11 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center backdrop-blur-md hover:bg-white/20 transition-all">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-6">
            <!-- Dynamic Metrics -->
            <div class="-mt-14 mb-10 relative z-10">
                <div
                    class="bg-white/70  backdrop-blur-xl rounded-[2rem] shadow-2xl shadow-blue-900/10 dark:shadow-black/30 p-1 border border-white/50  ">
                    <div
                        class="flex flex-wrap justify-between items-center p-8 md:p-12 bg-white  rounded-[1.8rem] ">
                        <div class="flex-1 min-w-[150px] text-center mb-6 md:mb-0">
                            <div
                                class="text-[11px] font-black text-slate-400  uppercase tracking-widest mb-2">
                                Pasien Hari Ini</div>
                            <div class="text-4xl md:text-6xl font-black text-slate-800 ">
                                {{ $pasienHariIni }}</div>
                        </div>
                        <div class="hidden md:block h-20 w-px bg-slate-100  mx-8"></div>
                        <div class="flex-1 min-w-[150px] text-center">
                            <div
                                class="text-[11px] font-black text-slate-400  uppercase tracking-widest mb-2">
                                Menunggu Sembuh</div>
                            <div class="text-4xl md:text-6xl font-black text-rose-500">{{ $perluTindakan }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Left Content: Active Patients -->
                <div class="lg:col-span-2">
                    <div class="flex justify-between items-center mb-5 px-1">
                        <h3 class="font-black text-slate-800  text-lg uppercase tracking-tight">Pasien Sedang Sakit</h3>
                        <div class="flex items-center gap-1">
                            <span class="w-2 h-2 bg-rose-500 rounded-full animate-pulse"></span>
                            <span class="text-[10px] font-bold text-rose-500 uppercase">Monitoring Live</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @forelse($activePatients as $sakit)
                            <div
                                class="bg-white  rounded-[1.8rem] p-5 border border-slate-100  shadow-sm hover:shadow-md transition-all">
                                <div class="flex items-center gap-4 mb-4">
                                    <div
                                        class="w-14 h-14 rounded-2xl bg-blue-50  flex items-center justify-center border border-blue-100 ">
                                        <svg class="w-7 h-7 text-deisa-blue " fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-slate-800  text-lg leading-tight">
                                            {{ $sakit->santri->nama_lengkap }}</h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs font-medium text-slate-400 ">Kelas
                                                {{ $sakit->santri->kelas->nama_kelas }}</span>
                                            <span class="w-1 h-1 bg-slate-200  rounded-full"></span>
                                            <span
                                                class="text-[10px] font-bold text-deisa-blue  uppercase tracking-wider">{{ $sakit->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 bg-slate-50  rounded-2xl border border-slate-100  mb-4">
                                    <div class="text-[10px] font-black text-slate-400  uppercase mb-1">Diagnosis Awal</div>
                                    <p class="text-sm text-slate-700  font-medium">{{ $sakit->diagnosis_utama }}</p>
                                </div>
                                <div class="flex gap-3">
                                    <button
                                        data-ajax-url="{{ route('admin.sakit.setStatus', ['id' => $sakit->id, 'status' => 'Sembuh']) }}"
                                        data-confirm-required="true" data-confirm="Konfirmasi pasien telah sembuh?"
                                        data-reload="true"
                                        class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white py-3 rounded-2xl font-bold text-sm shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Pasien Sembuh
                                    </button>
                                    <button
                                        class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:text-deisa-blue hover:border-deisa-blue transition-all"
                                        data-detail-url="{{ route('admin.sakit.show', $sakit->id) }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div
                                class="bg-slate-100/50 rounded-[2.5rem] p-12 text-center border-2 border-dashed border-slate-200">
                                <div
                                    class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                    <span class="text-3xl">🍃</span>
                                </div>
                                <h4 class="font-bold text-slate-800 mb-1">Semua Sehat Wal'afiat</h4>
                                <p class="text-xs text-slate-400 max-w-[200px] mx-auto leading-relaxed">Saat ini tidak ada
                                    santri yang sedang dalam perawatan UKS.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Recent Activity Summary -->
                    <div class="mt-10 mb-5 px-1">
                        <h3 class="font-black text-slate-800  text-lg uppercase tracking-tight">Aktivitas Terakhir</h3>
                    </div>
                    <div class="bg-white  rounded-[2rem] border border-slate-100  overflow-hidden ">
                        @foreach($recentPatients as $recent)
                            <div class="p-4 border-b border-slate-50 last:border-0 flex items-center gap-4 hover:bg-slate-50/50 transition-colors cursor-pointer"
                                data-detail-url="{{ route('admin.sakit.show', $recent->id) }}">
                                <div
                                    class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-xs font-black text-slate-400">
                                    {{ substr($recent->santri->nama_lengkap, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-bold text-slate-800 truncate">{{ $recent->santri->nama_lengkap }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $recent->created_at->format('d M H:i') }} •
                                        {{ $recent->status }}</div>
                                </div>
                                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right Content: Actions -->
                <div>
                    <div class="sticky top-24 space-y-6">
                        <div class="flex items-center justify-between px-1">
                            <h3 class="font-black text-slate-800  text-lg uppercase tracking-tight">Menu Utama</h3>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <a href="{{ route('user.sakit.create') }}"
                                class="group relative overflow-hidden bg-white  p-6 rounded-[2rem] border border-slate-100  shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                                <div
                                    class="absolute -right-4 -bottom-4 w-24 h-24 bg-rose-500/5 rounded-full group-hover:scale-150 transition-transform duration-500">
                                </div>
                                <div class="flex items-center gap-5">
                                    <div
                                        class="bg-rose-50 text-rose-500 p-4 rounded-2xl group-hover:bg-rose-500 group-hover:text-white transition-colors duration-300">
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block font-black text-slate-800">Lapor Sakit</span>
                                        <span class="text-xs text-slate-400 tracking-tight">Input data pasien baru</span>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('user.obat.list') }}"
                                class="group relative overflow-hidden bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                                <div
                                    class="absolute -right-4 -bottom-4 w-24 h-24 bg-deisa-blue/5 rounded-full group-hover:scale-150 transition-transform duration-500">
                                </div>
                                <div class="flex items-center gap-5">
                                    <div
                                        class="bg-blue-50 text-deisa-blue p-4 rounded-2xl group-hover:bg-deisa-blue group-hover:text-white transition-colors duration-300">
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block font-black text-slate-800">Cek Obat</span>
                                        <span class="text-xs text-slate-400 tracking-tight">Pantau ketersediaan stok</span>
                                    </div>
                                </div>
                            </a>

                            <div
                                class="p-6 bg-gradient-to-br from-slate-800 to-slate-900 rounded-[2rem] text-white overflow-hidden relative">
                                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-10 -mt-10"></div>
                                <h4 class="font-bold mb-2">Butuh Bantuan?</h4>
                                <p class="text-xs text-slate-400 mb-4 leading-relaxed">Gunakan fitur ini untuk melaporkan
                                    kerusakan stok atau kendala teknis.</p>
                                <button
                                    class="w-full py-2 bg-white/10 hover:bg-white/20 rounded-xl text-xs font-bold transition-all border border-white/10">Buka
                                    Support</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Glass Bottom Nav -->
        <div class="fixed bottom-6 left-6 right-6 z-50 md:hidden">
            <nav class="glass-effect rounded-[2rem] border border-white/40 shadow-2xl p-2 flex justify-around items-center">
                <a href="{{ route('user.dashboard') }}"
                    class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl {{ request()->routeIs('user.dashboard') ? 'bg-deisa-blue text-white shadow-lg shadow-blue-500/40' : 'text-slate-400' }}">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                </a>
                <a href="{{ route('user.sakit.create') }}"
                    class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl {{ request()->routeIs('user.sakit.*') ? 'bg-deisa-blue text-white shadow-lg shadow-blue-500/40' : 'text-slate-400' }}">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </a>
                <a href="{{ route('user.obat.list') }}"
                    class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl {{ request()->routeIs('user.obat.*') ? 'bg-deisa-blue text-white shadow-lg shadow-blue-500/40' : 'text-slate-400' }}">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </a>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl text-slate-400 hover:bg-slate-50 transition-all">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </button>
                    <!-- Mobile Profile/Logout Menu -->
                    <div x-show="open" @click.away="open = false"
                        class="absolute bottom-20 right-0 w-48 bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden py-2"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        <a href="{{ route('profile.index') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 font-medium">
                            Profil Saya
                        </a>
                        <hr class="border-slate-50 my-1">
                        <form action="{{ route('user.logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-3 text-sm text-rose-600 hover:bg-rose-50 font-bold">
                                Keluar Aplikasi
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
    </div>
@endsection