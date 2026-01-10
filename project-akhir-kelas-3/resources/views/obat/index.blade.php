@extends('layouts.master')

@section('title', 'Data Obat - Deisa')

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
                <span class="ml-1 text-sm font-medium text-text-main md:ml-2 dark:text-white">Data Obat</span>
            </div>
        </li>
    </ol>
</nav>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h2 class="text-2xl font-bold text-text-main dark:text-white">Data Obat</h2>
        <p class="text-text-muted text-sm mt-1">Kelola stok dan informasi obat.</p>
    </div>
    <a href="{{ route('obat.create') }}" class="bg-primary hover:bg-green-400 text-surface-dark font-bold py-2.5 px-5 rounded-lg shadow-lg shadow-primary/20 transition-all active:scale-95 flex items-center gap-2">
        <span class="material-symbols-outlined">add_circle</span>
        Tambah Obat
    </a>
</div>

<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden p-4">
    <div class="flex flex-col md:flex-row gap-4 mb-4">
        <div class="relative flex-grow">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <span class="material-symbols-outlined text-gray-400">search</span>
            </div>
            <input type="text" id="searchInput" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary" placeholder="Cari obat...">
        </div>
        <div class="w-full md:w-64">
            <select id="filterStatus" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary">
                <option value="">Semua Status</option>
                <option value="kadaluarsa">Sudah Kadaluarsa</option>
                <option value="hampir_kadaluarsa">Hampir Kadaluarsa (3 Bln)</option>
                <option value="stok_sedikit">Stok Sedikit</option>
                <option value="aman">Stok Aman</option>
            </select>
        </div>
    </div>

    <div id="tableContainer">
        @include('obat.table')
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        function debounce(func, wait) {
            let timeout;
            return function() {
                const context = this, args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), wait);
            };
        }

        function fetchData(page = 1, search = '', filterStatus = '') {
            $.ajax({
                url: "{{ route('obat.index') }}",
                data: {
                    page: page,
                    search: search,
                    filter_status: filterStatus
                },
                success: function(data) {
                    $('#tableContainer').html(data);
                }
            });
        }

        $('#searchInput').on('keyup', debounce(function() {
            let search = $(this).val();
            let filterStatus = $('#filterStatus').val();
            fetchData(1, search, filterStatus);
        }, 300));

        $('#filterStatus').on('change', function() {
            let search = $('#searchInput').val();
            let filterStatus = $(this).val();
            fetchData(1, search, filterStatus);
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let search = $('#searchInput').val();
            let filterStatus = $('#filterStatus').val();
            fetchData(page, search, filterStatus);
        });
    });
</script>
@endpush
