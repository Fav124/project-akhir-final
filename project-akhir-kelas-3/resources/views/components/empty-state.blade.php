<div
    class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-12 text-center">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
        <span class="material-symbols-outlined text-3xl text-gray-400">inbox</span>
    </div>
    <h3 class="text-lg font-semibold text-text-main dark:text-white mb-2">{{ $title ?? 'Tidak Ada Data' }}</h3>
    <p class="text-text-muted dark:text-gray-400 mb-6">{{ $message ?? 'Mulai dengan menambahkan data baru.' }}</p>
    @if (isset($action) && isset($actionRoute))
        <a href="{{ route($actionRoute) }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-green-600 text-text-main font-medium rounded-lg transition-colors">
            <span class="material-symbols-outlined">add</span>
            {{ $action }}
        </a>
    @endif
</div>
