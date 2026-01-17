@extends('layouts.admin')

@section('title', 'Laporan Santri Sakit')

@section('header')
    <h2 class="text-xl font-bold text-slate-900">Data Santri Sakit</h2>
    <p class="text-sm text-slate-500">Pantau dan kelola riwayat kesehatan santri</p>
@endsection

@section('admin-content')
    <div class="space-y-6">
        <x-card>
            <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                <form action="{{ route('admin.sakit.index') }}" method="GET" class="flex flex-wrap gap-3 flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari santri..."
                        data-realtime-search="true" data-search-target="#table-container"
                        class="px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue bg-white text-sm w-full max-w-xs">

                    <select name="status" data-realtime-filter="true"
                        class="px-4 py-2 rounded-lg border border-slate-300 bg-white text-sm outline-none">
                        <option value="">Semua Status</option>
                        <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="Pulang" {{ request('status') == 'Pulang' ? 'selected' : '' }}>Pulang</option>
                        <option value="Sembuh" {{ request('status') == 'Sembuh' ? 'selected' : '' }}>Sembuh</option>
                    </select>
                </form>
                <div class="flex gap-3">
                    <x-button class="whitespace-nowrap" data-form-url="{{ route('admin.sakit.create') }}">
                        + Tambah Laporan
                    </x-button>
                </div>
            </div>

            <div id="table-container">
                @include('admin.sakit._table')
            </div>
        </x-card>
    </div>
@endsection