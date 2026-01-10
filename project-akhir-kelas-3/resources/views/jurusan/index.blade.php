@extends('layouts.master')

@section('title', 'Data Jurusan - Deisa')

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
                <span class="ml-1 text-sm font-medium text-text-main md:ml-2 dark:text-white">Data Jurusan</span>
            </div>
        </li>
    </ol>
</nav>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h2 class="text-2xl font-bold text-text-main dark:text-white">Data Jurusan</h2>
        <p class="text-text-muted text-sm mt-1">Kelola data kompetensi keahlian.</p>
    </div>
    <a href="{{ route('jurusan.create') }}" class="bg-primary hover:bg-green-400 text-surface-dark font-bold py-2.5 px-5 rounded-lg shadow-lg shadow-primary/20 transition-all active:scale-95 flex items-center gap-2">
        <span class="material-symbols-outlined">add_circle</span>
        Tambah Jurusan
    </a>
</div>

<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden p-4">
    <div class="mb-4">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <span class="material-symbols-outlined text-gray-400">search</span>
            </div>
            <input type="text" id="searchInput" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary" placeholder="Cari jurusan...">
        </div>
    </div>

    <div id="tableContainer">
        @include('jurusan.table')
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Debounce function to limit AJAX calls
        function debounce(func, wait) {
            let timeout;
            return function() {
                const context = this, args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), wait);
            };
        }

        // Fetch data function
        function fetchData(page = 1, search = '') {
            $.ajax({
                url: "{{ route('jurusan.index') }}" + "?page=" + page + "&search=" + search,
                success: function(data) {
                    $('#tableContainer').html(data);
                }
            });
        }

        // Search input handler with debounce
        $('#searchInput').on('keyup', debounce(function() {
            let search = $(this).val();
            fetchData(1, search);
        }, 300));

        // Pagination click handler
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let search = $('#searchInput').val();
            fetchData(page, search);
        });
    });
</script>
@endpush
