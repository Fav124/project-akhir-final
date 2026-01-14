@extends('layouts.admin-template')

@section('title', 'Manajemen Santri')

@section('content')
<div class="flex flex-col gap-6">
    <!-- Top Header & Actions -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <h1 class="text-text-main dark:text-white text-3xl font-black leading-tight tracking-[-0.033em]">Manajemen Santri</h1>
            <p class="text-text-muted text-sm font-normal">Kelola data santri, status kesehatan, dan informasi akademik.</p>
        </div>
        <div class="flex gap-3">
            <button class="flex items-center gap-2 h-10 px-4 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-surface-dark text-text-main dark:text-white text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[20px]">download</span>
                <span class="hidden sm:inline">Export Data</span>
            </button>
            <a href="{{ route('web.santri.create') }}" class="flex items-center gap-2 h-10 px-4 rounded-lg bg-primary text-white text-sm font-bold shadow-md shadow-blue-200 hover:bg-primary-dark transition-colors">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span>Tambah Santri</span>
            </a>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="flex flex-col gap-1 p-4 rounded-xl border border-border-light dark:border-border-dark bg-white dark:bg-surface-dark shadow-soft">
            <div class="flex items-center justify-between">
                <p class="text-text-muted text-sm font-medium">Total Santri</p>
                <span class="material-symbols-outlined text-primary bg-primary/10 p-1 rounded-md text-[20px]">groups</span>
            </div>
            <div class="flex items-end gap-2 mt-1">
                <p class="text-text-main dark:text-white text-2xl font-bold leading-none">{{ number_format(\App\Models\Santri::count()) }}</p>
            </div>
        </div>
        <div class="flex flex-col gap-1 p-4 rounded-xl border border-border-light dark:border-border-dark bg-white dark:bg-surface-dark shadow-soft ring-1 ring-green-100 dark:ring-green-900/30">
            <div class="flex items-center justify-between">
                <p class="text-text-muted text-sm font-medium">Sehat</p>
                <span class="material-symbols-outlined text-success bg-success/10 p-1 rounded-md text-[20px]">health_and_safety</span>
            </div>
            <div class="flex items-end gap-2 mt-1">
                <p class="text-text-main dark:text-white text-2xl font-bold leading-none">{{ number_format(\App\Models\Santri::where('status_kesehatan', 'Sehat')->count()) }}</p>
                <p class="text-success text-xs font-bold mb-1 bg-success/10 px-1.5 py-0.5 rounded-full">Active</p>
            </div>
        </div>
        <div class="flex flex-col gap-1 p-4 rounded-xl border border-border-light dark:border-border-dark bg-white dark:bg-surface-dark shadow-soft">
            <div class="flex items-center justify-between">
                <p class="text-text-muted text-sm font-medium">Sakit</p>
                <span class="material-symbols-outlined text-danger bg-danger/10 p-1 rounded-md text-[20px]">sick</span>
            </div>
            <div class="flex items-end gap-2 mt-1">
                <p class="text-text-main dark:text-white text-2xl font-bold leading-none">{{ number_format(\App\Models\Santri::where('status_kesehatan', '!=', 'Sehat')->count()) }}</p>
                <p class="text-text-muted text-xs font-normal mb-1">Needs Attention</p>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="flex flex-col sm:flex-row gap-4 justify-between items-center pt-2">
        <div class="flex p-1 bg-background-light dark:bg-gray-800 rounded-lg self-start sm:self-auto">
            <button class="px-4 py-1.5 rounded-md bg-white dark:bg-surface-dark shadow-sm text-text-main dark:text-white text-sm font-semibold transition-all">All</button>
            <button class="px-4 py-1.5 rounded-md text-text-muted hover:text-text-main dark:hover:text-white text-sm font-medium transition-all">Sehat</button>
            <button class="px-4 py-1.5 rounded-md text-text-muted hover:text-text-main dark:hover:text-white text-sm font-medium transition-all">Sakit</button>
        </div>
        <div class="w-full sm:max-w-xs relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-text-muted text-[20px]">search</span>
            </div>
            <input class="block w-full pl-10 pr-3 py-2 border-none ring-1 ring-border-light dark:ring-gray-700 rounded-lg leading-5 bg-white dark:bg-surface-dark placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary sm:text-sm shadow-sm transition-shadow text-text-main dark:text-white" placeholder="Cari nama atau NIS..." type="text"/>
        </div>
    </div>

    <!-- Scrollable Table Container -->
    <div class="border rounded-xl border-border-light dark:border-border-dark bg-white dark:bg-surface-dark shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-border-light dark:divide-border-dark">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-4 text-left w-12" scope="col">
                        <input class="rounded border-gray-300 text-primary focus:ring-primary h-4 w-4" type="checkbox"/>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-text-muted uppercase tracking-wider" scope="col">Santri Info</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-text-muted uppercase tracking-wider" scope="col">Kelas</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-text-muted uppercase tracking-wider" scope="col">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-text-muted uppercase tracking-wider" scope="col">Jenis Kelamin</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-text-muted uppercase tracking-wider" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-light dark:divide-border-dark bg-white dark:bg-surface-dark">
                @forelse(\App\Models\Santri::paginate(10) as $santri)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input class="rounded border-gray-300 text-primary focus:ring-primary h-4 w-4" type="checkbox"/>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-cover bg-center border border-gray-200 dark:border-gray-700" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode($santri->nama_lengkap) }}&background=random');"></div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-text-main dark:text-white">{{ $santri->nama_lengkap }}</div>
                                <div class="text-sm text-text-muted">{{ $santri->nis }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300">
                            {{ $santri->kelas->nama_kelas ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($santri->status_kesehatan == 'Sehat')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 gap-1.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span>
                            Sehat
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 gap-1.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-600"></span>
                            Sakit
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-text-muted">
                        {{ $santri->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('web.santri.edit', $santri->id) }}" class="text-text-muted hover:text-primary transition-colors p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <button class="text-text-muted hover:text-danger transition-colors p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-text-muted">Tidak ada data santri found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <!-- Pagination -->
        <div class="bg-white dark:bg-surface-dark px-4 py-3 border-t border-border-light dark:border-border-dark sm:px-6">
            {{ \App\Models\Santri::paginate(10)->links() }}
        </div>
    </div>
</div>
@endsection
