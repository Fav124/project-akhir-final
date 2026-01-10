<!-- PAGE HEADER -->
<div class="space-y-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-text-main dark:text-white">{{ $title }}</h1>
            <p class="text-text-muted dark:text-gray-400 mt-1">{{ $subtitle }}</p>
        </div>
        @if (isset($createRoute))
            <a href="{{ route($createRoute) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-green-600 text-text-main font-medium rounded-lg transition-colors w-fit">
                <span class="material-symbols-outlined text-xl">add_circle</span>
                <span>{{ $buttonLabel ?? 'Tambah Data' }}</span>
            </a>
        @endif
    </div>

    @if (session('success'))
        <div
            class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg flex items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.style.display='none'"
                class="text-green-700 dark:text-green-300 hover:text-green-900 dark:hover:text-green-100">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div
            class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg flex items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined">error</span>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.style.display='none'"
                class="text-red-700 dark:text-red-300 hover:text-red-900 dark:hover:text-red-100">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    @endif

    {{ $slot }}
</div>
