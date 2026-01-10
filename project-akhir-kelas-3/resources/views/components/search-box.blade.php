<div class="relative">
    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-text-muted">
        <span class="material-symbols-outlined">search</span>
    </span>
    <input type="text"
        class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white placeholder:text-text-muted focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors"
        placeholder="{{ $placeholder ?? 'Cari...' }}" id="{{ $id ?? 'searchInput' }}" />
</div>
