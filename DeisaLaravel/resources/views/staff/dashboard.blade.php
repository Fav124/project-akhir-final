@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')
    <div class="min-h-screen pb-24 bg-white">
        <!-- Header -->
        <header class="bg-emerald-50 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 pt-10 pb-24 rounded-b-[3rem]">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-emerald-400/20 rounded-full blur-2xl -ml-10 -mb-10"></div>
                
                <div class="relative z-10 flex justify-between items-start mb-6">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 bg-white/20 rounded text-[10px] font-bold text-white uppercase tracking-wider">Staff Mode</span>
                        </div>
                        <div class="text-emerald-100 text-sm opacity-80">Selamat bekerja,</div>
                        <div class="text-white text-2xl font-bold tracking-tight">{{ auth()->user()->name }}</div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('profile.index') }}" class="w-11 h-11 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center backdrop-blur-md hover:bg-white/20 transition-all">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </a>
                        <form action="{{ route('user.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-white text-sm font-bold transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-6 0v-1m6-10V5a3 3 0 00-6 0v1" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-6">
            <!-- Stats Cards -->
            <div class="-mt-14 mb-10 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white  rounded-2xl p-6 border border-slate-100  ">
                        <div class="text-xs font-black text-slate-400  uppercase mb-2">Pasien Hari Ini</div>
                        <div class="text-3xl font-black text-slate-800 ">{{ $pasienHariIni }}</div>
                    </div>
                    <div class="bg-white  rounded-2xl p-6 border border-slate-100  ">
                        <div class="text-xs font-black text-slate-400  uppercase mb-2">Perlu Tindakan</div>
                        <div class="text-3xl font-black text-rose-500">{{ $perluTindakan }}</div>
                    </div>
                    <div class="bg-white  rounded-2xl p-6 border border-slate-100  ">
                        <div class="text-xs font-black text-slate-400  uppercase mb-2">Total Obat</div>
                        <div class="text-3xl font-black text-slate-800 ">{{ $totalObat }}</div>
                    </div>
                    <div class="bg-white  rounded-2xl p-6 border border-slate-100  ">
                        <div class="text-xs font-black text-slate-400  uppercase mb-2">Stok Menipis</div>
                        <div class="text-3xl font-black text-amber-500">{{ $obatHampirHabis }}</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-10">
                <h3 class="font-black text-slate-800  text-lg uppercase tracking-tight mb-5">Menu Utama</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('staff.obat.index') }}" class="group bg-white  p-6 rounded-2xl border border-slate-100  hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="bg-blue-50  text-deisa-blue  p-4 rounded-xl mb-4 group-hover:bg-deisa-blue group-hover:text-white transition-colors">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <span class="block font-black text-slate-800  mb-1">Kelola Obat</span>
                        <span class="text-xs text-slate-400 ">CRUD obat & stok</span>
                    </a>

                    <a href="{{ route('staff.santri.index') }}" class="group bg-white  p-6 rounded-2xl border border-slate-100  hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="bg-purple-50  text-purple-600  p-4 rounded-xl mb-4 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <span class="block font-black text-slate-800  mb-1">Data Santri</span>
                        <span class="text-xs text-slate-400 ">Lihat data santri</span>
                    </a>

                    <a href="{{ route('staff.laporan.index') }}" class="group bg-white  p-6 rounded-2xl border border-slate-100  hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="bg-rose-50  text-rose-600  p-4 rounded-xl mb-4 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="block font-black text-slate-800  mb-1">Laporan PDF</span>
                        <span class="text-xs text-slate-400 ">Generate laporan</span>
                    </a>

                    <a href="{{ route('user.sakit.create') }}" class="group bg-white  p-6 rounded-2xl border border-slate-100  hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="bg-emerald-50  text-emerald-600  p-4 rounded-xl mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <span class="block font-black text-slate-800  mb-1">Lapor Sakit</span>
                        <span class="text-xs text-slate-400 ">Input pasien baru</span>
                    </a>
                </div>
            </div>

            <!-- Active Patients -->
            <div class="mb-10">
                <h3 class="font-black text-slate-800  text-lg uppercase tracking-tight mb-5">Pasien Aktif</h3>
                <div class="space-y-4">
                    @forelse($activePatients as $sakit)
                        <div class="bg-white  rounded-2xl p-5 border border-slate-100  ">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-blue-50  flex items-center justify-center">
                                    <svg class="w-6 h-6 text-deisa-blue " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-slate-800 ">{{ $sakit->santri->nama_lengkap }}</h4>
                                    <p class="text-xs text-slate-400 ">{{ $sakit->diagnosis_utama }} • {{ $sakit->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-slate-100/50  rounded-2xl p-12 text-center">
                            <p class="text-slate-400 ">Tidak ada pasien aktif</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
