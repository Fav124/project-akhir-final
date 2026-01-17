@extends('layouts.admin')

@section('title', 'Manajemen Obat')

@section('header')
    <h2 class="text-xl font-bold text-slate-900">Stok Obat</h2>
    <p class="text-sm text-slate-500 hidden sm:block">Kelola persediaan obat dan alat kesehatan</p>
@endsection

@section('admin-content')
    <x-card>
        <!-- Toolbar -->
        <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
            <div class="flex gap-3 flex-1">
                <input type="text" id="searchObat" name="search" value="{{ request('search') }}" placeholder="Cari obat..."
                    data-realtime-search="true" data-search-target="#table-container"
                    class="w-full max-w-xs px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                <select name="filter" data-realtime-filter="true"
                    class="px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue bg-white text-sm">
                    <option value="">Semua Status</option>
                    <option value="aman" {{ request('filter') == 'aman' ? 'selected' : '' }}>Stok Aman</option>
                    <option value="kritis" {{ request('filter') == 'kritis' ? 'selected' : '' }}>Stok Kritis</option>
                    <option value="kadaluarsa" {{ request('filter') == 'kadaluarsa' ? 'selected' : '' }}>Kadaluarsa</option>
                </select>
            </div>
            <div class="flex gap-3">
                <x-button variant="outline">Export CSV</x-button>
                <x-button href="/admin/obat/create">+ Tambah Obat</x-button>
            </div>
        </div>

        <!-- Table Container -->
        <div id="table-container">
            @include('admin.obat._table')
        </div>
    </x-card>

    <!-- Restock Modal Partial -->
    @include('admin.obat._restock-modal')

@endsection

@push('scripts')
    <script>
        document.getElementById('searchObat').addEventListener('input', function (e) {
            console.log('Searching for: ' + e.target.value);
        });
    </script>
@endpush