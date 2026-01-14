@extends('layouts.admin-template')

@section('title', 'Daftar Santri Sakit')

@section('content')
<div class="flex flex-col gap-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black tracking-tight text-text-main dark:text-white mb-1">Daftar Santri Sakit</h2>
            <p class="text-text-muted text-sm">Kelola data santri yang sedang sakit, dalam perawatan, atau izin pulang.</p>
        </div>
        <a href="{{ route('web.sakit.create') }}" class="bg-primary hover:bg-primary-dark text-white shadow-lg shadow-primary/20 transition-all active:scale-95 h-11 px-6 rounded-lg font-bold text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Tambah Data
        </a>
    </div>

    <!-- Toolbar (Search & Filters) -->
    <div class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-center justify-between">
        <!-- Search -->
        <div class="relative w-full lg:max-w-md group">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-text-muted group-focus-within:text-primary transition-colors">search</span>
            </div>
            <input class="block w-full pl-10 pr-3 py-2.5 border-none rounded-lg bg-surface-light dark:bg-surface-dark ring-1 ring-border-light dark:ring-border-dark text-sm focus:ring-2 focus:ring-primary placeholder-text-muted shadow-sm transition-all text-text-main dark:text-white" placeholder="Cari nama santri, kelas, atau NIS..." type="text"/>
        </div>
        <!-- Filters -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 lg:pb-0 no-scrollbar">
            <div class="flex items-center bg-surface-light dark:bg-surface-dark rounded-lg p-1 ring-1 ring-border-light dark:ring-border-dark shadow-sm gap-2">
                <span class="px-3 text-xs font-semibold text-text-muted uppercase tracking-wider">Filter:</span>
                <div class="h-4 w-px bg-gray-200 dark:bg-gray-700 mx-1"></div>
                <button class="flex items-center gap-1.5 px-3 py-1.5 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-sm font-medium text-text-main dark:text-white">
                    Status
                    <span class="material-symbols-outlined text-[16px] text-text-muted">expand_more</span>
                </button>
                <button class="flex items-center gap-1.5 px-3 py-1.5 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-sm font-medium text-text-main dark:text-white">
                    Lokasi
                    <span class="material-symbols-outlined text-[16px] text-text-muted">expand_more</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Content Area -->
    <div class="bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-xl shadow-sm overflow-hidden">
        <!-- Table Header -->
        <div class="grid grid-cols-12 gap-4 px-6 py-4 border-b border-border-light dark:border-border-dark bg-gray-50/50 dark:bg-white/[0.02]">
            <div class="col-span-3 text-xs font-bold uppercase tracking-wider text-text-muted">Santri</div>
            <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-text-muted">Diagnosa</div>
            <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-text-muted">Durasi & Masuk</div>
            <div class="col-span-1 text-xs font-bold uppercase tracking-wider text-text-muted">Lokasi</div>
            <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-text-muted">Status</div>
            <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-text-muted text-right">Aksi Cepat</div>
        </div>
        <!-- Table Body -->
        <div class="overflow-y-auto">
            @forelse(\App\Models\SantriSakit::with('santri')->paginate(10) as $sakit)
            <div class="group grid grid-cols-12 gap-4 px-6 py-4 border-b border-border-light dark:border-border-dark hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors items-center relative">
                <!-- Santri -->
                <div class="col-span-3 flex items-center gap-3">
                    <div class="relative">
                        <div class="size-10 rounded-full bg-cover bg-center border border-gray-200 dark:border-gray-700" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode($sakit->santri->nama_lengkap) }}&background=random');"></div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-text-main dark:text-white">{{ $sakit->santri->nama_lengkap }}</span>
                        <span class="text-xs text-text-muted">{{ $sakit->santri->kelas->nama_kelas ?? '-' }} • {{ $sakit->santri->nis }}</span>
                    </div>
                </div>
                <!-- Diagnosa -->
                <div class="col-span-2">
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                            {{ $sakit->keluhan }}
                        </span>
                    </div>
                </div>
                <!-- Durasi -->
                <div class="col-span-2">
                    <div class="flex items-center gap-2">
                        <div class="flex flex-col">
                            <p class="text-sm font-bold text-text-main dark:text-white">{{ $sakit->created_at->diffForHumans() }}</p>
                            <p class="text-xs text-text-muted">{{ $sakit->tanggal_sakit }}</p>
                        </div>
                    </div>
                </div>
                <!-- Lokasi -->
                <div class="col-span-1">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        <span class="material-symbols-outlined text-[14px]">local_hospital</span>
                        UKS
                    </span>
                </div>
                <!-- Status -->
                <div class="col-span-2">
                     <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-danger/10 text-danger border border-danger/20">
                        <span class="size-1.5 rounded-full bg-danger animate-pulse"></span>
                        {{ $sakit->status }}
                    </span>
                </div>
                <!-- Aksi -->
                <div class="col-span-2 flex justify-end gap-1">
                    <form action="{{ route('web.sakit.sembuh', $sakit->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="size-8 flex items-center justify-center rounded-lg text-text-muted hover:text-success hover:bg-success/10 transition-colors" title="Tandai Sembuh">
                            <span class="material-symbols-outlined text-[20px]">check_circle</span>
                        </button>
                    </form>
                    <button class="size-8 flex items-center justify-center rounded-lg text-text-muted hover:text-primary hover:bg-primary/10 transition-colors" title="Lihat Detail">
                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                    </button>
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-text-muted">
                Tidak ada data santri sakit.
            </div>
            @endforelse
        </div>
        <!-- Pagination Footer -->
        <div class="px-6 py-4 border-t border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark">
             {{ \App\Models\SantriSakit::paginate(10)->links() }}
        </div>
    </div>
</div>
@endsection
