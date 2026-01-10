@extends('layouts.master')

@section('content')
<div class="space-y-6">
    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-text-main dark:text-white">Riwayat Aktivitas</h1>
            <p class="text-text-muted dark:text-gray-400 mt-1">Pantau semua perubahan data di sistem.</p>
        </div>
    </div>

    <!-- FILTER & SEARCH -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-4">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-text-muted">
                    <span class="material-symbols-outlined text-lg">search</span>
                </span>
                <input type="text" id="searchInput" 
                       class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary transition-all" 
                       placeholder="Cari aktivitas, admin, atau deskripsi...">
            </div>
        </div>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
        <div id="historyTable">
            @include('history.table')
        </div>
    </div>
</div>

@push('js')
<script>
    const searchInput = document.getElementById('searchInput');
    let searchTimeout;

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            fetchLogs();
        }, 500);
    });

    async function fetchLogs(page = 1) {
        const search = searchInput.value;
        const url = `{{ route('history.index') }}?page=${page}&search=${encodeURIComponent(search)}`;
        
        try {
            const res = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const html = await res.text();
            document.getElementById('historyTable').innerHTML = html;
        } catch (e) {
            console.error(e);
        }
    }

    // Handle pagination links
    document.addEventListener('click', (e) => {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            const url = new URL(e.target.closest('.pagination a').href);
            const page = url.searchParams.get('page');
            fetchLogs(page);
        }
    });
</script>
@endpush
@endsection
