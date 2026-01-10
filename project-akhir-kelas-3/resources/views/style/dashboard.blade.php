<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Deisa - Dashboard</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec80",
                        "background-light": "#f6f8f7",
                        "background-dark": "#102219",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1a3326",
                        "text-main": "#0d1b14",
                        "text-muted": "#4c9a73",
                    },
                    fontFamily: {
                        "display": ["Manrope", "Noto Sans", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;family=Noto+Sans:wght@300..800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<style>
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .chart-bar {
            transition: height 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-text-main dark:text-gray-100 antialiased selection:bg-primary selection:text-text-main overflow-hidden">
<div class="flex h-screen flex-col">
<header class="h-16 flex-none bg-surface-light dark:bg-surface-dark border-b border-gray-200 dark:border-gray-800 flex items-center justify-between px-6 z-20 shadow-sm relative">
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
<p class="text-sm font-bold text-text-main dark:text-white">Ust. Abdullah</p>
<p class="text-xs text-text-muted dark:text-gray-400">Admin Kesehatan</p>
</div>
<div class="h-10 w-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-lg">
                        A
                    </div>
</div>
<button class="flex items-center justify-center h-10 w-10 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-text-muted hover:text-red-500 transition-colors" title="Logout">
<span class="material-symbols-outlined">logout</span>
</button>
</div>
</header>
<div class="flex flex-1 overflow-hidden">
<aside class="w-64 flex-none bg-surface-light dark:bg-surface-dark border-r border-gray-200 dark:border-gray-800 hidden lg:flex flex-col">
<nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
<a class="flex items-center gap-3 px-4 py-3 bg-primary/10 text-primary rounded-lg font-semibold transition-colors" href="#">
<span class="material-symbols-outlined">dashboard</span>
<span>Dashboard</span>
</a>
<div class="pt-4 pb-2 px-4 text-xs font-semibold text-text-muted uppercase tracking-wider">Master Data</div>
<a class="flex items-center gap-3 px-4 py-3 text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-lg font-medium transition-colors group" href="#">
<span class="material-symbols-outlined text-gray-400 group-hover:text-primary">person</span>
<span>Data User</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-lg font-medium transition-colors group" href="#">
<span class="material-symbols-outlined text-gray-400 group-hover:text-primary">groups</span>
<span>Data Santri</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-lg font-medium transition-colors group" href="#">
<span class="material-symbols-outlined text-gray-400 group-hover:text-primary">school</span>
<span>Data Kelas</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-lg font-medium transition-colors group" href="#">
<span class="material-symbols-outlined text-gray-400 group-hover:text-primary">medication</span>
<span>Data Obat</span>
</a>
<div class="pt-4 pb-2 px-4 text-xs font-semibold text-text-muted uppercase tracking-wider">Health Monitoring</div>
<a class="flex items-center gap-3 px-4 py-3 text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-lg font-medium transition-colors group" href="#">
<span class="material-symbols-outlined text-gray-400 group-hover:text-red-500">sick</span>
<span>Santri Sakit</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-lg font-medium transition-colors group" href="#">
<span class="material-symbols-outlined text-gray-400 group-hover:text-primary">description</span>
<span>Laporan</span>
</a>
</nav>
<div class="p-4 border-t border-gray-200 dark:border-gray-800">
<div class="bg-gradient-to-br from-primary/20 to-primary/5 rounded-xl p-4">
<h4 class="font-bold text-sm text-text-main dark:text-white mb-1">Need Help?</h4>
<p class="text-xs text-text-muted mb-3">Check the documentation for admin guides.</p>
<button class="text-xs font-bold text-primary hover:text-green-600">View Docs →</button>
</div>
</div>
</aside>
<main class="flex-1 overflow-y-auto bg-background-light dark:bg-background-dark p-6 lg:p-10">
<div class="rounded-2xl bg-surface-dark relative overflow-hidden mb-8 shadow-md">
<div class="absolute inset-0 z-0">
<div class="w-full h-full bg-cover bg-center opacity-40 mix-blend-overlay" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAM1InwB68-F8Wj0tIHpv8UtU7PxEfjE6yUQawBU57mleT9e16Y0s52W9UTuNsch3H8X-mRzntrX9W3sSFKKP6F9Ie6epBu4vwLxEI4xfFcHg13uLAQVVYSTA3AcOYbHxMk9t48W_-8Gh1_BoqtMUONp9TNvG4q-U20KlWLabqlOxmRs5e2R72CE4RTQN1NKpzYX6k_pzL5JUXtpakcw-RU1b2WghvUd-HGlfMKo5dK1HPYmohDGWNjECLy8uPnKjAsMEMcAtlAMdWe");'></div>
<div class="absolute inset-0 bg-gradient-to-r from-surface-dark via-surface-dark/90 to-transparent"></div>
</div>
<div class="relative z-10 p-8 sm:p-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
<div>
<h2 class="text-3xl font-bold text-white mb-2">Welcome back, Ust. Abdullah!</h2>
<p class="text-gray-300 max-w-xl">Here is the daily overview of the students' health at Pondok Pesantren Deisa. Monitor sick students and medicine inventory effectively.</p>
</div>
<button class="bg-primary hover:bg-green-400 text-surface-dark font-bold py-3 px-6 rounded-lg shadow-lg shadow-primary/20 transition-all active:scale-95 flex items-center gap-2">
<span class="material-symbols-outlined">add_circle</span>
                            New Record
                        </button>
</div>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
<div class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col">
<div class="flex items-center justify-between mb-4">
<div class="p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
<span class="material-symbols-outlined">groups</span>
</div>
<span class="text-xs font-medium text-green-600 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">+2%</span>
</div>
<div class="mt-auto">
<p class="text-sm font-medium text-text-muted">Total Santri</p>
<h3 class="text-3xl font-bold text-text-main dark:text-white">1,245</h3>
</div>
</div>
<div class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col">
<div class="flex items-center justify-between mb-4">
<div class="p-3 rounded-lg bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400">
<span class="material-symbols-outlined">school</span>
</div>
</div>
<div class="mt-auto">
<p class="text-sm font-medium text-text-muted">Total Classes</p>
<h3 class="text-3xl font-bold text-text-main dark:text-white">42</h3>
</div>
</div>
<div class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col">
<div class="flex items-center justify-between mb-4">
<div class="p-3 rounded-lg bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400">
<span class="material-symbols-outlined">medication</span>
</div>
<span class="text-xs font-medium text-red-500 bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded-full">Low Stock</span>
</div>
<div class="mt-auto">
<p class="text-sm font-medium text-text-muted">Medicines</p>
<h3 class="text-3xl font-bold text-text-main dark:text-white">156</h3>
</div>
</div>
<div class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col relative overflow-hidden">
<div class="absolute right-0 top-0 p-24 bg-red-500/5 rounded-full -mr-10 -mt-10 pointer-events-none"></div>
<div class="flex items-center justify-between mb-4 relative z-10">
<div class="p-3 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-500">
<span class="material-symbols-outlined">sick</span>
</div>
</div>
<div class="mt-auto relative z-10">
<p class="text-sm font-medium text-text-muted">Santri Sakit</p>
<h3 class="text-3xl font-bold text-text-main dark:text-white">12</h3>
<p class="text-xs text-red-400 mt-1">Requires attention</p>
</div>
</div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
<div class="lg:col-span-2 bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
<div class="flex items-center justify-between mb-6">
<div>
<h3 class="text-lg font-bold text-text-main dark:text-white">Health Statistics</h3>
<p class="text-sm text-text-muted">Sick santri vs Medicine Usage (Last 7 Days)</p>
</div>
<select class="form-select text-sm rounded-lg border-gray-200 dark:border-gray-700 bg-transparent text-text-main dark:text-white focus:border-primary focus:ring-primary">
<option>Last 7 Days</option>
<option>Last 30 Days</option>
</select>
</div>
<div class="relative h-64 w-full flex items-end justify-between gap-2 sm:gap-4 px-2">
<div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
<div class="border-b border-gray-100 dark:border-gray-800 w-full h-0"></div>
<div class="border-b border-gray-100 dark:border-gray-800 w-full h-0"></div>
<div class="border-b border-gray-100 dark:border-gray-800 w-full h-0"></div>
<div class="border-b border-gray-100 dark:border-gray-800 w-full h-0"></div>
<div class="border-b border-gray-200 dark:border-gray-700 w-full h-0"></div>
</div>
<div class="relative flex flex-col items-center gap-2 group w-full h-full justify-end">
<div class="flex items-end gap-1 h-full w-full justify-center">
<div class="w-2 sm:w-4 bg-red-400 rounded-t-sm h-[40%] group-hover:bg-red-500 transition-all"></div>
<div class="w-2 sm:w-4 bg-primary rounded-t-sm h-[60%] group-hover:bg-green-500 transition-all"></div>
</div>
<span class="text-xs text-text-muted font-medium">Mon</span>
</div>
<div class="relative flex flex-col items-center gap-2 group w-full h-full justify-end">
<div class="flex items-end gap-1 h-full w-full justify-center">
<div class="w-2 sm:w-4 bg-red-400 rounded-t-sm h-[25%] group-hover:bg-red-500 transition-all"></div>
<div class="w-2 sm:w-4 bg-primary rounded-t-sm h-[45%] group-hover:bg-green-500 transition-all"></div>
</div>
<span class="text-xs text-text-muted font-medium">Tue</span>
</div>
<div class="relative flex flex-col items-center gap-2 group w-full h-full justify-end">
<div class="flex items-end gap-1 h-full w-full justify-center">
<div class="w-2 sm:w-4 bg-red-400 rounded-t-sm h-[55%] group-hover:bg-red-500 transition-all"></div>
<div class="w-2 sm:w-4 bg-primary rounded-t-sm h-[70%] group-hover:bg-green-500 transition-all"></div>
</div>
<span class="text-xs text-text-muted font-medium">Wed</span>
</div>
<div class="relative flex flex-col items-center gap-2 group w-full h-full justify-end">
<div class="flex items-end gap-1 h-full w-full justify-center">
<div class="w-2 sm:w-4 bg-red-400 rounded-t-sm h-[30%] group-hover:bg-red-500 transition-all"></div>
<div class="w-2 sm:w-4 bg-primary rounded-t-sm h-[50%] group-hover:bg-green-500 transition-all"></div>
</div>
<span class="text-xs text-text-muted font-medium">Thu</span>
</div>
<div class="relative flex flex-col items-center gap-2 group w-full h-full justify-end">
<div class="flex items-end gap-1 h-full w-full justify-center">
<div class="w-2 sm:w-4 bg-red-400 rounded-t-sm h-[20%] group-hover:bg-red-500 transition-all"></div>
<div class="w-2 sm:w-4 bg-primary rounded-t-sm h-[35%] group-hover:bg-green-500 transition-all"></div>
</div>
<span class="text-xs text-text-muted font-medium">Fri</span>
</div>
<div class="relative flex flex-col items-center gap-2 group w-full h-full justify-end">
<div class="flex items-end gap-1 h-full w-full justify-center">
<div class="w-2 sm:w-4 bg-red-400 rounded-t-sm h-[15%] group-hover:bg-red-500 transition-all"></div>
<div class="w-2 sm:w-4 bg-primary rounded-t-sm h-[25%] group-hover:bg-green-500 transition-all"></div>
</div>
<span class="text-xs text-text-muted font-medium">Sat</span>
</div>
<div class="relative flex flex-col items-center gap-2 group w-full h-full justify-end">
<div class="flex items-end gap-1 h-full w-full justify-center">
<div class="w-2 sm:w-4 bg-red-400 rounded-t-sm h-[10%] group-hover:bg-red-500 transition-all"></div>
<div class="w-2 sm:w-4 bg-primary rounded-t-sm h-[20%] group-hover:bg-green-500 transition-all"></div>
</div>
<span class="text-xs text-text-muted font-medium">Sun</span>
</div>
</div>
<div class="flex items-center justify-center gap-6 mt-6">
<div class="flex items-center gap-2">
<div class="w-3 h-3 rounded-full bg-red-400"></div>
<span class="text-xs text-text-main dark:text-gray-300">Sick Santri</span>
</div>
<div class="flex items-center gap-2">
<div class="w-3 h-3 rounded-full bg-primary"></div>
<span class="text-xs text-text-main dark:text-gray-300">Medicine Usage</span>
</div>
</div>
</div>
<div class="lg:col-span-1">
<div class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm h-full">
<h3 class="text-lg font-bold text-text-main dark:text-white mb-6">Quick Actions</h3>
<div class="flex flex-col gap-3">
<button class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 hover:border-primary hover:bg-primary/5 transition-all group text-left">
<div class="p-2 rounded-lg bg-surface-light dark:bg-surface-dark shadow-sm text-primary group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined">add_circle</span>
</div>
<div>
<h4 class="font-bold text-sm text-text-main dark:text-white">Add New Santri</h4>
<p class="text-xs text-text-muted">Register a new student</p>
</div>
</button>
<button class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 hover:border-primary hover:bg-primary/5 transition-all group text-left">
<div class="p-2 rounded-lg bg-surface-light dark:bg-surface-dark shadow-sm text-red-500 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined">medical_services</span>
</div>
<div>
<h4 class="font-bold text-sm text-text-main dark:text-white">Report Sickness</h4>
<p class="text-xs text-text-muted">Log a new health issue</p>
</div>
</button>
<button class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 hover:border-primary hover:bg-primary/5 transition-all group text-left">
<div class="p-2 rounded-lg bg-surface-light dark:bg-surface-dark shadow-sm text-purple-500 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined">inventory</span>
</div>
<div>
<h4 class="font-bold text-sm text-text-main dark:text-white">Restock Medicine</h4>
<p class="text-xs text-text-muted">Update inventory levels</p>
</div>
</button>
<button class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 hover:border-primary hover:bg-primary/5 transition-all group text-left">
<div class="p-2 rounded-lg bg-surface-light dark:bg-surface-dark shadow-sm text-orange-500 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined">print</span>
</div>
<div>
<h4 class="font-bold text-sm text-text-main dark:text-white">Print Report</h4>
<p class="text-xs text-text-muted">Generate monthly summary</p>
</div>
</button>
</div>
</div>
</div>
</div>
<footer class="mt-12 text-center text-xs text-text-muted pb-4">
<p>© 2024 Deisa Health System. All rights reserved.</p>
</footer>
</main>
</div>
</div>
</body></html>