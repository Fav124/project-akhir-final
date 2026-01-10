@extends('layouts.master')

@section('title', 'Detail Riwayat Sakit - Deisa')

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
                <a href="{{ route('sakit.index') }}" class="ml-1 text-sm font-medium text-text-muted hover:text-primary md:ml-2 dark:text-gray-400 dark:hover:text-white">Riwayat Sakit</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <span class="material-symbols-outlined text-text-muted text-lg">chevron_right</span>
                <span class="ml-1 text-sm font-medium text-text-main md:ml-2 dark:text-white">Detail Riwayat</span>
            </div>
        </li>
    </ol>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column: Patient & Status -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Patient Card -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden p-6 relative">
            <div class="absolute top-0 right-0 p-4">
                <a href="{{ route('santri.show', $sakit->santri_id) }}" class="text-xs font-bold text-primary hover:text-green-600 flex items-center gap-1">
                    Lihat Profil <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xl font-bold overflow-hidden border-2 border-white dark:border-gray-800 shadow-md">
                    @if($sakit->santri->foto)
                        <img src="{{ Storage::url($sakit->santri->foto) }}" alt="{{ $sakit->santri->nama_lengkap }}" class="w-full h-full object-cover">
                    @else
                        {{ substr($sakit->santri->nama_lengkap, 0, 1) }}
                    @endif
                </div>
                <div>
                    <h2 class="text-xl font-bold text-text-main dark:text-white">{{ $sakit->santri->nama_lengkap }}</h2>
                    <p class="text-text-muted text-sm">{{ $sakit->santri->nis }} • {{ $sakit->santri->kelas->nama_kelas ?? '-' }}</p>
                </div>
            </div>
            
            <div class="p-3 bg-{{ $sakit->status == 'sakit' ? 'red' : ($sakit->status == 'sembuh' ? 'green' : 'amber') }}-50 dark:bg-opacity-10 rounded-lg text-center border border-{{ $sakit->status == 'sakit' ? 'red' : ($sakit->status == 'sembuh' ? 'green' : 'amber') }}-100 dark:border-opacity-10">
                <span class="block text-xs uppercase font-bold text-{{ $sakit->status == 'sakit' ? 'red' : ($sakit->status == 'sembuh' ? 'green' : 'amber') }}-600 mb-1">Status Saat Ini</span>
                <span class="text-lg font-bold text-{{ $sakit->status == 'sakit' ? 'red' : ($sakit->status == 'sembuh' ? 'green' : 'amber') }}-700">{{ ucfirst($sakit->status) }}</span>
            </div>
        </div>

        <!-- Vital Signs (Placeholder based on schema if exists, else generic info) -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden p-6">
            <h3 class="text-sm font-bold text-text-muted uppercase mb-4">Informasi Medis</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center border-b border-gray-50 dark:border-gray-800 pb-3">
                    <span class="text-sm text-text-muted">Tanggal Sakit</span>
                    <span class="font-medium text-text-main dark:text-white">{{ \Carbon\Carbon::parse($sakit->tanggal_mulai_sakit)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-50 dark:border-gray-800 pb-3">
                    <span class="text-sm text-text-muted">Suhu Tubuh</span>
                    <span class="font-medium text-text-main dark:text-white">{{ $sakit->suhu_tubuh ?? '-' }} °C</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-50 dark:border-gray-800 pb-3">
                    <span class="text-sm text-text-muted">Tanggal Sembuh</span>
                    <span class="font-medium text-text-main dark:text-white">{{ $sakit->tanggal_selesai_sakit ? \Carbon\Carbon::parse($sakit->tanggal_selesai_sakit)->translatedFormat('d F Y') : '-' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-text-muted">Petugas</span>
                    <span class="font-medium text-text-main dark:text-white">{{ $sakit->user->name ?? 'Admin' }}</span>
                </div>
            </div>
            
            @if($sakit->status == 'sakit')
            <div class="mt-6">
                <form action="{{ route('sakit.sembuh', $sakit->id) }}" method="POST" class="w-full">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="w-full flex justify-center items-center gap-2 px-4 py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg font-bold shadow-lg shadow-green-500/20 transition-all active:scale-95">
                        <span class="material-symbols-outlined">check_circle</span>
                        Tandai Sembuh
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>

    <!-- Right Column: Medical Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Diagnosis & Action -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden p-6">
            <h3 class="text-lg font-bold text-text-main dark:text-white mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-red-500">stethoscope</span>
                Diagnosis & Penanganan
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-text-muted uppercase mb-1">Diagnosis</label>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @forelse($sakit->diagnoses as $diag)
                            <span class="px-3 py-1 bg-primary/10 text-primary text-sm font-bold rounded-lg border border-primary/20">
                                {{ $diag->nama }}
                            </span>
                        @empty
                            <p class="text-lg font-medium text-text-main dark:text-white bg-gray-50 dark:bg-gray-800/50 p-3 rounded-lg border border-gray-100 dark:border-gray-700 w-full">
                                {{ $sakit->diagnosis ?? '-' }}
                            </p>
                        @endforelse
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-text-muted uppercase mb-1">Gejala</label>
                    <p class="text-text-main dark:text-gray-300 bg-gray-50 dark:bg-gray-800/50 p-3 rounded-lg h-full">
                        {{ $sakit->gejala }}
                    </p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-text-muted uppercase mb-1">Tindakan</label>
                    <p class="text-text-main dark:text-gray-300 bg-gray-50 dark:bg-gray-800/50 p-3 rounded-lg h-full">
                        {{ $sakit->tindakan }}
                    </p>
                </div>
                @if($sakit->catatan)
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-text-muted uppercase mb-1">Catatan Tambahan</label>
                    <p class="text-text-main dark:text-gray-300 italic bg-yellow-50 dark:bg-yellow-900/10 p-3 rounded-lg border border-yellow-100 dark:border-yellow-900/20 text-sm">
                        {{ $sakit->catatan }}
                    </p>
                </div>
                @endif
            </div>
        </div>

        <!-- Prescribed Medicine -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden p-6">
            <h3 class="text-lg font-bold text-text-main dark:text-white mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-purple-500">pill</span>
                Resep Obat
            </h3>
            
            @if($sakit->obats->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($sakit->obats as $obat)
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700 p-4 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-2 opacity-10 group-hover:opacity-20 transition-opacity">
                            <span class="material-symbols-outlined text-6xl text-primary">medication</span>
                        </div>
                        <div class="relative z-10">
                            <h4 class="font-bold text-text-main dark:text-white">{{ $obat->nama_obat }}</h4>
                            <p class="text-xs text-text-muted mb-2">{{ $obat->satuan }}</p>
                            
                            <div class="flex items-center gap-2 text-sm mt-3">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded text-xs font-bold dark:bg-blue-900/30 dark:text-blue-300">{{ $obat->pivot->jumlah }} {{ $obat->satuan }}</span>
                                @if($obat->pivot->dosis)
                                <span class="text-gray-500 dark:text-gray-400 text-xs">• {{ $obat->pivot->dosis }}</span>
                                @endif
                            </div>
                            @if($obat->pivot->keterangan)
                            <p class="text-xs text-gray-500 mt-2 italic">"{{ $obat->pivot->keterangan }}"</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-dashed border-gray-200 dark:border-gray-700">
                    <span class="material-symbols-outlined text-gray-400 text-4xl mb-2">no_meals</span>
                    <p class="text-text-muted text-sm">Tidak ada obat yang diresepkan.</p>
                </div>
            @endif

            <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-800">
                <label class="block text-xs font-bold text-text-muted uppercase mb-2">Resep (Text)</label>
                <p class="text-text-main dark:text-gray-300 text-sm font-mono bg-gray-50 dark:bg-gray-900 p-3 rounded border border-gray-200 dark:border-gray-700">
                    {{ $sakit->resep_obat ?? '-' }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
