@extends('layouts.master')

@section('title', 'Detail Santri - Deisa')

@section('content')
<nav aria-label="Breadcrumb" class="flex mb-4">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a class="inline-flex items-center text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined text-lg mr-2">home</span>
                Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <span class="material-symbols-outlined text-text-muted text-lg">chevron_right</span>
                <a href="{{ route('santri.index') }}" class="ml-1 text-sm font-medium text-text-muted hover:text-primary md:ml-2 dark:text-gray-400 dark:hover:text-white">Data Santri</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <span class="material-symbols-outlined text-text-muted text-lg">chevron_right</span>
                <span class="ml-1 text-sm font-medium text-text-main md:ml-2 dark:text-white">Detail Santri</span>
            </div>
        </li>
    </ol>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column: Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden p-6 text-center">
            <div class="w-32 h-32 mx-auto rounded-full bg-primary/10 flex items-center justify-center text-primary text-4xl font-bold overflow-hidden mb-4 border-4 border-white dark:border-gray-800 shadow-lg">
                @if($santri->foto)
                    <img src="{{ Storage::url($santri->foto) }}" alt="{{ $santri->nama_lengkap }}" class="w-full h-full object-cover">
                @else
                    {{ substr($santri->nama_lengkap, 0, 1) }}
                @endif
            </div>
            <h2 class="text-2xl font-bold text-text-main dark:text-white">{{ $santri->nama_lengkap }}</h2>
            <p class="text-text-muted mb-4">{{ $santri->nis }}</p>
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium {{ $santri->status == 'sehat' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                <span class="w-2 h-2 rounded-full {{ $santri->status == 'sehat' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                {{ ucfirst($santri->status) }}
            </div>

            <div class="mt-8 flex flex-col gap-3">
                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800/50 text-left">
                    <p class="text-xs text-text-muted uppercase font-bold mb-1">Kelas</p>
                    <p class="text-text-main dark:text-white font-medium">{{ $santri->kelas->nama_kelas ?? '-' }}</p>
                </div>
                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800/50 text-left">
                    <p class="text-xs text-text-muted uppercase font-bold mb-1">TTL</p>
                    <p class="text-text-main dark:text-white font-medium">{{ $santri->tempat_lahir }}, {{ \Carbon\Carbon::parse($santri->tanggal_lahir)->translatedFormat('d F Y') }}</p>
                </div>
                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800/50 text-left">
                    <p class="text-xs text-text-muted uppercase font-bold mb-1">Jenis Kelamin</p>
                    <p class="text-text-main dark:text-white font-medium text-capitalize">{{ $santri->jenis_kelamin }}</p>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('santri.edit', $santri->id) }}" class="flex w-full justify-center items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-medium transition-colors">
                    <span class="material-symbols-outlined text-lg">edit</span>
                    Edit Profil
                </a>
            </div>
        </div>
    </div>

    <!-- Right Column: Details & History -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Guardian Info -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden p-6">
            <h3 class="text-lg font-bold text-text-main dark:text-white mb-4 border-b border-gray-100 dark:border-gray-800 pb-2">Informasi Wali</h3>
            @if($santri->wali)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-text-muted mb-1">Nama Wali</p>
                        <p class="font-medium text-text-main dark:text-white">{{ $santri->wali->nama_wali }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-text-muted mb-1">Hubungan</p>
                        <p class="font-medium text-text-main dark:text-white">{{ $santri->wali->hubungan }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-text-muted mb-1">No. HP</p>
                        <p class="font-medium text-text-main dark:text-white">{{ $santri->wali->no_hp }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-text-muted mb-1">TTL Wali</p>
                        <p class="font-medium text-text-main dark:text-white">{{ $santri->wali->tempat_lahir }}, {{ \Carbon\Carbon::parse($santri->wali->tanggal_lahir)->translatedFormat('d F Y') }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-text-muted mb-1">Alamat</p>
                        <p class="font-medium text-text-main dark:text-white">{{ $santri->wali->alamat }}</p>
                    </div>
                </div>
            @else
                <p class="text-text-muted italic">Data wali belum dilengkapi.</p>
            @endif
        </div>

        <!-- Sick History -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden p-6">
            <h3 class="text-lg font-bold text-text-main dark:text-white mb-4 border-b border-gray-100 dark:border-gray-800 pb-2">Riwayat Kesehatan</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-text-muted uppercase bg-gray-50 dark:bg-gray-800/50">
                        <tr>
                            <th class="px-4 py-3 rounded-l-lg">Tanggal</th>
                            <th class="px-4 py-3">Diagnosis</th>
                            <th class="px-4 py-3">Obat</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 rounded-r-lg text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($santri->sakitSantris as $history)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="px-4 py-3 font-medium text-text-main dark:text-white">
                                {{ \Carbon\Carbon::parse($history->tanggal_mulai_sakit)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-4 py-3 text-text-main dark:text-gray-300">
                                {{ Str::limit($history->diagnosis, 30) }}
                            </td>
                            <td class="px-4 py-3">
                                @if($history->obats->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($history->obats->take(2) as $obat)
                                            <span class="bg-blue-50 text-blue-700 text-[10px] px-1.5 py-0.5 rounded border border-blue-100 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800">
                                                {{ $obat->nama_obat }}
                                            </span>
                                        @endforeach
                                        @if($history->obats->count() > 2)
                                            <span class="text-[10px] text-text-muted">+{{ $history->obats->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-text-muted text-xs italic">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($history->status == 'sakit')
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Sakit</span>
                                @elseif($history->status == 'sembuh')
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Sembuh</span>
                                @else
                                    <span class="bg-amber-100 text-amber-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-amber-900 dark:text-amber-300">Kontrol</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('sakit.edit', $history->id) }}" class="text-xs text-primary hover:text-green-600 font-medium">Buka</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-text-muted">Belum ada riwayat sakit.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
