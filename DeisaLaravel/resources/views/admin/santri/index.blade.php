@extends('layouts.admin')

@section('title', 'Data Santri')

@section('header')
    <h2 class="text-xl font-bold text-slate-900">Data Santri</h2>
    <p class="text-sm text-slate-500 hidden sm:block">Kelola data siswa dan riwayat kesehatan.</p>
@endsection

@section('admin-content')
    <x-card>
        <!-- Toolbar -->
        <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
            <form action="{{ route('admin.santri.index') }}" method="GET" class="flex gap-3 flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIS..."
                    data-realtime-search="true" data-search-target="#table-container"
                    class="w-full max-w-xs px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                <select name="kelas" data-realtime-filter="true"
                    class="px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue bg-white">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->nama_kelas }}" {{ request('kelas') == $class->nama_kelas ? 'selected' : '' }}>
                            {{ $class->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </form>
            <div class="flex gap-3">
                <x-button variant="outline" class="whitespace-nowrap">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Import
                </x-button>
                <x-button class="whitespace-nowrap" data-form-url="{{ route('admin.santri.create') }}">
                    + Tambah Santri
                </x-button>
            </div>
        </div>

        <!-- Table Container -->
        <div id="table-container" class="overflow-x-auto">
            @include('admin.santri._table')
        </div>
    </x-card>
@endsection