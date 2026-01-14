<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>DEISA Santri - @yield('title', 'Admin Dashboard')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            font-size: 24px; 
            vertical-align: middle;
        }
        .material-symbols-outlined.filled {
            font-variation-settings: 'FILL' 1;
        }
        
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-text-main dark:text-gray-100 font-display transition-colors duration-200">
    <div class="flex h-screen w-full overflow-hidden">
        <!-- Sidebar Navigation -->
        <aside class="w-72 bg-white dark:bg-surface-dark border-r border-border-light dark:border-border-dark flex flex-col flex-shrink-0 z-20 shadow-soft">
            <div class="h-16 flex items-center gap-3 px-6 border-b border-border-light dark:border-border-dark">
                <div class="bg-primary/10 rounded-lg p-1.5 text-primary">
                    <span class="material-symbols-outlined filled">local_hospital</span>
                </div>
                <h1 class="text-xl font-bold tracking-tight text-primary-dark">DEISA Santri</h1>
            </div>
            <div class="flex-1 overflow-y-auto no-scrollbar py-6 px-4 flex flex-col gap-6">
                <!-- Main Nav -->
                <div class="flex flex-col gap-1">
                    <p class="px-3 text-xs font-bold text-text-muted uppercase tracking-wider mb-2">Main Menu</p>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary/10 text-primary group transition-all" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined filled text-[20px]">dashboard</span>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 text-text-muted hover:text-text-main transition-all" href="{{ route('web.santri.index') }}">
                        <span class="material-symbols-outlined text-[20px]">group</span>
                        <span class="text-sm font-medium">Manajemen User</span>
                    </a>
                    <!-- Master Data Accordion (Expanded) -->
                    <div class="flex flex-col gap-1 mt-1">
                        <button class="flex items-center justify-between w-full gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 text-text-muted hover:text-text-main transition-all text-left">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-[20px]">database</span>
                                <span class="text-sm font-medium">Master Data</span>
                            </div>
                            <span class="material-symbols-outlined text-[18px]">expand_more</span>
                        </button>
                        <!-- Submenu -->
                        <div class="flex flex-col pl-11 gap-1 border-l-2 border-border-light dark:border-border-dark ml-5">
                            <a class="px-3 py-1.5 text-sm font-medium text-text-muted hover:text-primary transition-colors" href="#">Data Kelas</a>
                            <a class="px-3 py-1.5 text-sm font-medium text-text-muted hover:text-primary transition-colors" href="#">Data Jurusan</a>
                            <a class="px-3 py-1.5 text-sm font-medium text-text-muted hover:text-primary transition-colors" href="{{ route('web.santri.index') }}">Data Santri</a>
                            <a class="px-3 py-1.5 text-sm font-medium text-text-muted hover:text-primary transition-colors" href="#">Diagnosis</a>
                        </div>
                    </div>
                </div>
                <!-- Health & Inventory -->
                <div class="flex flex-col gap-1">
                    <p class="px-3 text-xs font-bold text-text-muted uppercase tracking-wider mb-2">Health Operations</p>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 text-text-muted hover:text-text-main transition-all" href="{{ route('web.obat.index') }}">
                        <span class="material-symbols-outlined text-[20px]">medication_liquid</span>
                        <span class="text-sm font-medium">Inventaris Obat</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 text-text-muted hover:text-text-main transition-all" href="{{ route('web.sakit.index') }}">
                        <span class="material-symbols-outlined text-[20px]">stethoscope</span>
                        <span class="text-sm font-medium">Rekam Medis</span>
                    </a>
                </div>
                <!-- Analytics -->
                <div class="flex flex-col gap-1">
                    <p class="px-3 text-xs font-bold text-text-muted uppercase tracking-wider mb-2">Analytics</p>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 text-text-muted hover:text-text-main transition-all" href="#">
                        <span class="material-symbols-outlined text-[20px]">description</span>
                        <span class="text-sm font-medium">Reports</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 text-text-muted hover:text-text-main transition-all" href="#">
                        <span class="material-symbols-outlined text-[20px]">history</span>
                        <span class="text-sm font-medium">Activity Logs</span>
                    </a>
                </div>
            </div>
            <!-- Profile Snippet Bottom -->
            <div class="p-4 border-t border-border-light dark:border-border-dark">
                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer">
                    <div class="size-9 rounded-full bg-cover bg-center" style="background-image: url('https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=random');"></div>
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-sm font-bold text-text-main dark:text-white truncate">{{ Auth::user()->name ?? 'Guest' }}</span>
                        <span class="text-xs text-text-muted truncate">{{ Auth::user()->email ?? 'No Email' }}</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col h-full overflow-hidden relative">
            <!-- Top Header -->
            <header class="h-16 bg-white dark:bg-surface-dark border-b border-border-light dark:border-border-dark flex items-center justify-between px-8 z-10 shrink-0">
                <!-- Breadcrumbs -->
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-text-muted">Home</span>
                    <span class="text-text-muted">/</span>
                    <span class="font-semibold text-text-main dark:text-white">@yield('title')</span>
                </div>
                <!-- Right Actions -->
                <div class="flex items-center gap-6">
                    <!-- Search -->
                    <div class="hidden md:flex relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-text-muted text-[20px]">search</span>
                        </div>
                        <input class="block w-64 pl-10 pr-3 py-2 border-none ring-1 ring-border-light dark:ring-gray-700 bg-background-light dark:bg-gray-800 rounded-lg text-sm text-text-main placeholder-text-muted focus:ring-2 focus:ring-primary focus:bg-white dark:focus:bg-gray-900 transition-all" placeholder="Search data..." type="text"/>
                    </div>
                    <!-- Notifications -->
                    <button class="relative p-2 text-text-muted hover:text-primary transition-colors rounded-full hover:bg-background-light dark:hover:bg-gray-800">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute top-1.5 right-1.5 size-2.5 bg-danger rounded-full border-2 border-white dark:border-surface-dark"></span>
                    </button>
                    <!-- Help -->
                    <button class="p-2 text-text-muted hover:text-primary transition-colors rounded-full hover:bg-background-light dark:hover:bg-gray-800">
                        <span class="material-symbols-outlined">help</span>
                    </button>
                </div>
            </header>
            
            <!-- Scrollable Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
