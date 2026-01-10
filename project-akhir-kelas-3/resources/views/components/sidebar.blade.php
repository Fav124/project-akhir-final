<aside
    class="w-64 flex-none bg-surface-light dark:bg-surface-dark border-r border-gray-200 dark:border-gray-800 hidden lg:flex flex-col">
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary' : 'text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }}"
            href="{{ route('dashboard') }}">
            <span
                class="material-symbols-outlined {{ request()->routeIs('dashboard') ? '' : 'text-gray-400 group-hover:text-primary' }}">dashboard</span>
            <span>Dashboard</span>
        </a>

        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-text-muted uppercase tracking-wider">Master Data</div>

        @if (Auth::user() && Auth::user()->isAdmin())
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors group {{ request()->routeIs('users.*') ? 'bg-primary/10 text-primary' : 'text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }}"
                href="{{ route('users.index') }}">
                <span
                    class="material-symbols-outlined {{ request()->routeIs('users.*') ? '' : 'text-gray-400 group-hover:text-primary' }}">person</span>
                <span>Data User</span>
            </a>

            <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors group {{ request()->routeIs('jurusan.*') ? 'bg-primary/10 text-primary' : 'text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }}"
                href="{{ route('jurusan.index') }}">
                <span
                    class="material-symbols-outlined {{ request()->routeIs('jurusan.*') ? '' : 'text-gray-400 group-hover:text-primary' }}">school</span>
                <span>Data Jurusan</span>
            </a>

            <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors group {{ request()->routeIs('kelas.*') ? 'bg-primary/10 text-primary' : 'text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }}"
                href="{{ route('kelas.index') }}">
                <span
                    class="material-symbols-outlined {{ request()->routeIs('kelas.*') ? '' : 'text-gray-400 group-hover:text-primary' }}">class</span>
                <span>Data Kelas</span>
            </a>

            <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors group {{ request()->routeIs('diagnosis.*') ? 'bg-primary/10 text-primary' : 'text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }}"
                href="{{ route('diagnosis.index') }}">
                <span
                    class="material-symbols-outlined {{ request()->routeIs('diagnosis.*') ? '' : 'text-gray-400 group-hover:text-primary' }}">stethoscope</span>
                <span>Data Diagnosis</span>
            </a>
        @endif

        <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors group {{ request()->routeIs('santri.*') ? 'bg-primary/10 text-primary' : 'text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }}"
            href="{{ route('santri.index') }}">
            <span
                class="material-symbols-outlined {{ request()->routeIs('santri.*') ? '' : 'text-gray-400 group-hover:text-primary' }}">groups</span>
            <span>Data Santri</span>
        </a>

        <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors group {{ request()->routeIs('obat.*') ? 'bg-primary/10 text-primary' : 'text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }}"
            href="{{ route('obat.index') }}">
            <span
                class="material-symbols-outlined {{ request()->routeIs('obat.*') ? '' : 'text-gray-400 group-hover:text-primary' }}">medication</span>
            <span>Data Obat</span>
        </a>

        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-text-muted uppercase tracking-wider">Health Monitoring
        </div>

        <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors group {{ request()->routeIs('sakit.*') ? 'bg-primary/10 text-primary' : 'text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }}"
            href="{{ route('sakit.index') }}">
            <span
                class="material-symbols-outlined {{ request()->routeIs('sakit.*') ? '' : 'text-gray-400 group-hover:text-red-500' }}">sick</span>
            <span>Santri Sakit</span>
        </a>

        <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors group {{ request()->routeIs('laporan.*') ? 'bg-primary/10 text-primary' : 'text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }}"
            href="{{ route('laporan.report') }}">
            <span
                class="material-symbols-outlined {{ request()->routeIs('laporan.*') ? '' : 'text-gray-400 group-hover:text-primary' }}">description</span>
            <span>Laporan</span>
        </a>

        <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors group {{ request()->routeIs('history.*') ? 'bg-primary/10 text-primary' : 'text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50' }}"
            href="{{ route('history.index') }}">
            <span
                class="material-symbols-outlined {{ request()->routeIs('history.*') ? '' : 'text-gray-400 group-hover:text-primary' }}">history</span>
            <span>Riwayat Aktivitas</span>
        </a>
    </nav>
    <div class="p-4 border-t border-gray-200 dark:border-gray-800">
        <div class="bg-gradient-to-br from-primary/20 to-primary/5 rounded-xl p-4">
            <h4 class="font-bold text-sm text-text-main dark:text-white mb-1">Butuh Bantuan?</h4>
            <p class="text-xs text-text-muted mb-3">Hubungi administrator jika ada kendala.</p>
        </div>
    </div>
</aside>
