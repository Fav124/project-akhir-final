<div x-data="themeSwitcher()" x-init="initTheme()" class="relative">
    <button @click="toggleTheme()"
        class="p-2 text-slate-500 hover:text-slate-700  dark:hover:text-slate-200 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
        <!-- Sun (Light) -->
        <svg x-show="theme === 'light'" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <!-- Moon (Dark) -->
        <svg x-show="theme === 'dark'" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
        <!-- System -->
        <svg x-show="theme === 'system'" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
    </button>
</div>

<script>
    function themeSwitcher() {
        return {
            theme: localStorage.getItem('theme') || 'system',

            initTheme() {
                this.applyTheme();
            },

            applyTheme() {
                if (this.theme === 'dark' || (this.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            },

            toggleTheme() {
                if (this.theme === 'light') {
                    this.theme = 'dark';
                } else if (this.theme === 'dark') {
                    this.theme = 'system';
                } else {
                    this.theme = 'light';
                }

                localStorage.setItem('theme', this.theme);
                this.applyTheme();
            }
        }
    }
</script>