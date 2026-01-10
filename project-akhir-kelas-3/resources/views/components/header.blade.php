<header
    class="h-16 flex-none bg-surface-light dark:bg-surface-dark border-b border-gray-200 dark:border-gray-800 flex items-center justify-between px-6 z-20 shadow-sm relative">
    <div class="flex items-center gap-3">
        <div class="size-8 text-primary">
            <svg class="w-full h-full" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                <path d="M44 4H30.6666V17.3334H17.3334V30.6666H4V44H44V4Z" fill="currentColor"></path>
            </svg>
        </div>
        <h1 class="text-xl font-bold tracking-tight text-text-main dark:text-white">Deisa</h1>
    </div>
    <div class="flex items-center gap-6">
        <div class="flex items-center gap-3">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-bold text-text-main dark:text-white">{{ Auth::user()->name ?? 'User' }}</p>
                <p class="text-xs text-text-muted dark:text-gray-400 capitalize">{{ Auth::user()->role ?? 'User' }}</p>
            </div>
            <div
                class="h-10 w-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-lg overflow-hidden">
                @if (Auth::user() && Auth::user()->foto)
                    <img src="{{ Storage::url(Auth::user()->foto) }}" alt="User" class="w-full h-full object-cover">
                @else
                    {{ Auth::user() ? substr(Auth::user()->name, 0, 1) : 'U' }}
                @endif
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit"
                class="flex items-center justify-center h-10 w-10 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-text-muted hover:text-red-500 transition-colors"
                title="Logout">
                <span class="material-symbols-outlined">logout</span>
            </button>
        </form>
    </div>
</header>
