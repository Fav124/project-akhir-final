<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Deisa - Data Santri</title>
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
<a class="flex items-center gap-3 px-4 py-3 text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-lg font-medium transition-colors group" href="#">
<span class="material-symbols-outlined text-gray-400 group-hover:text-primary">dashboard</span>
<span>Dashboard</span>
</a>
<div class="pt-4 pb-2 px-4 text-xs font-semibold text-text-muted uppercase tracking-wider">Master Data</div>
<a class="flex items-center gap-3 px-4 py-3 text-text-main dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-lg font-medium transition-colors group" href="#">
<span class="material-symbols-outlined text-gray-400 group-hover:text-primary">person</span>
<span>Data User</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 bg-primary/10 text-primary rounded-lg font-semibold transition-colors" href="#">
<span class="material-symbols-outlined">groups</span>
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
<nav aria-label="Breadcrumb" class="flex mb-4">
<ol class="inline-flex items-center space-x-1 md:space-x-3">
<li class="inline-flex items-center">
<a class="inline-flex items-center text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white" href="#">
<span class="material-symbols-outlined text-lg mr-2">home</span>
                                Dashboard
                            </a>
</li>
<li>
<div class="flex items-center">
<span class="material-symbols-outlined text-text-muted text-lg">chevron_right</span>
<span class="ml-1 text-sm font-medium text-text-main md:ml-2 dark:text-white">Data Santri</span>
</div>
</li>
</ol>
</nav>
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
<div>
<h2 class="text-2xl font-bold text-text-main dark:text-white">Data Santri</h2>
<p class="text-text-muted text-sm mt-1">Manage student information and health status.</p>
</div>
<button class="bg-primary hover:bg-green-400 text-surface-dark font-bold py-2.5 px-5 rounded-lg shadow-lg shadow-primary/20 transition-all active:scale-95 flex items-center gap-2">
<span class="material-symbols-outlined">add_circle</span>
                        Tambah Santri
                    </button>
</div>
<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-300">
<tr>
<th class="px-6 py-4 font-bold rounded-tl-xl" scope="col">No</th>
<th class="px-6 py-4 font-bold" scope="col">NIS</th>
<th class="px-6 py-4 font-bold" scope="col">Nama Lengkap</th>
<th class="px-6 py-4 font-bold" scope="col">Jenis Kelamin</th>
<th class="px-6 py-4 font-bold" scope="col">Kelas</th>
<th class="px-6 py-4 font-bold" scope="col">Tempat/Tanggal Lahir</th>
<th class="px-6 py-4 font-bold" scope="col">Status</th>
<th class="px-6 py-4 font-bold rounded-tr-xl text-center" scope="col">Aksi</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 dark:divide-gray-800">
<tr class="bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
<td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">1</td>
<td class="px-6 py-4 font-mono">2023001</td>
<td class="px-6 py-4 font-medium text-text-main dark:text-white">Ahmad Fauzan</td>
<td class="px-6 py-4">Laki-laki</td>
<td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">10-A</span></td>
<td class="px-6 py-4">Jakarta, 12 Mei 2008</td>
<td class="px-6 py-4">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
<span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Sehat
                                        </span>
</td>
<td class="px-6 py-4">
<div class="flex items-center justify-center gap-2">
<button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg dark:text-blue-400 dark:hover:bg-blue-900/20 transition-colors" title="View">
<span class="material-symbols-outlined text-[20px]">visibility</span>
</button>
<button class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg dark:text-amber-400 dark:hover:bg-amber-900/20 transition-colors" title="Edit">
<span class="material-symbols-outlined text-[20px]">edit</span>
</button>
<button class="p-2 text-red-600 hover:bg-red-50 rounded-lg dark:text-red-400 dark:hover:bg-red-900/20 transition-colors" title="Delete">
<span class="material-symbols-outlined text-[20px]">delete</span>
</button>
</div>
</td>
</tr>
<tr class="bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
<td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">2</td>
<td class="px-6 py-4 font-mono">2023002</td>
<td class="px-6 py-4 font-medium text-text-main dark:text-white">Siti Aminah</td>
<td class="px-6 py-4">Perempuan</td>
<td class="px-6 py-4"><span class="bg-pink-100 text-pink-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-pink-900 dark:text-pink-300">10-B</span></td>
<td class="px-6 py-4">Bandung, 23 Agustus 2008</td>
<td class="px-6 py-4">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
<span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Sakit
                                        </span>
</td>
<td class="px-6 py-4">
<div class="flex items-center justify-center gap-2">
<button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg dark:text-blue-400 dark:hover:bg-blue-900/20 transition-colors" title="View">
<span class="material-symbols-outlined text-[20px]">visibility</span>
</button>
<button class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg dark:text-amber-400 dark:hover:bg-amber-900/20 transition-colors" title="Edit">
<span class="material-symbols-outlined text-[20px]">edit</span>
</button>
<button class="p-2 text-red-600 hover:bg-red-50 rounded-lg dark:text-red-400 dark:hover:bg-red-900/20 transition-colors" title="Delete">
<span class="material-symbols-outlined text-[20px]">delete</span>
</button>
</div>
</td>
</tr>
<tr class="bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
<td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">3</td>
<td class="px-6 py-4 font-mono">2023003</td>
<td class="px-6 py-4 font-medium text-text-main dark:text-white">Muhammad Rizky</td>
<td class="px-6 py-4">Laki-laki</td>
<td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">11-A</span></td>
<td class="px-6 py-4">Surabaya, 05 Januari 2007</td>
<td class="px-6 py-4">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
<span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Sehat
                                        </span>
</td>
<td class="px-6 py-4">
<div class="flex items-center justify-center gap-2">
<button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg dark:text-blue-400 dark:hover:bg-blue-900/20 transition-colors" title="View">
<span class="material-symbols-outlined text-[20px]">visibility</span>
</button>
<button class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg dark:text-amber-400 dark:hover:bg-amber-900/20 transition-colors" title="Edit">
<span class="material-symbols-outlined text-[20px]">edit</span>
</button>
<button class="p-2 text-red-600 hover:bg-red-50 rounded-lg dark:text-red-400 dark:hover:bg-red-900/20 transition-colors" title="Delete">
<span class="material-symbols-outlined text-[20px]">delete</span>
</button>
</div>
</td>
</tr>
<tr class="bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
<td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">4</td>
<td class="px-6 py-4 font-mono">2023004</td>
<td class="px-6 py-4 font-medium text-text-main dark:text-white">Nurul Hidayah</td>
<td class="px-6 py-4">Perempuan</td>
<td class="px-6 py-4"><span class="bg-pink-100 text-pink-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-pink-900 dark:text-pink-300">11-B</span></td>
<td class="px-6 py-4">Yogyakarta, 15 September 2007</td>
<td class="px-6 py-4">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
<span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Sehat
                                        </span>
</td>
<td class="px-6 py-4">
<div class="flex items-center justify-center gap-2">
<button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg dark:text-blue-400 dark:hover:bg-blue-900/20 transition-colors" title="View">
<span class="material-symbols-outlined text-[20px]">visibility</span>
</button>
<button class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg dark:text-amber-400 dark:hover:bg-amber-900/20 transition-colors" title="Edit">
<span class="material-symbols-outlined text-[20px]">edit</span>
</button>
<button class="p-2 text-red-600 hover:bg-red-50 rounded-lg dark:text-red-400 dark:hover:bg-red-900/20 transition-colors" title="Delete">
<span class="material-symbols-outlined text-[20px]">delete</span>
</button>
</div>
</td>
</tr>
<tr class="bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
<td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">5</td>
<td class="px-6 py-4 font-mono">2023005</td>
<td class="px-6 py-4 font-medium text-text-main dark:text-white">Budi Santoso</td>
<td class="px-6 py-4">Laki-laki</td>
<td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">12-A</span></td>
<td class="px-6 py-4">Semarang, 30 Maret 2006</td>
<td class="px-6 py-4">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
<span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Sakit
                                        </span>
</td>
<td class="px-6 py-4">
<div class="flex items-center justify-center gap-2">
<button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg dark:text-blue-400 dark:hover:bg-blue-900/20 transition-colors" title="View">
<span class="material-symbols-outlined text-[20px]">visibility</span>
</button>
<button class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg dark:text-amber-400 dark:hover:bg-amber-900/20 transition-colors" title="Edit">
<span class="material-symbols-outlined text-[20px]">edit</span>
</button>
<button class="p-2 text-red-600 hover:bg-red-50 rounded-lg dark:text-red-400 dark:hover:bg-red-900/20 transition-colors" title="Delete">
<span class="material-symbols-outlined text-[20px]">delete</span>
</button>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<div class="flex items-center justify-between p-4 border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-surface-dark/50">
<span class="text-sm text-text-muted">Showing 5 of 1245 entries</span>
<div class="flex gap-2">
<button class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-surface-dark text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 disabled:opacity-50" disabled="">
                            Previous
                        </button>
<button class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-surface-dark text-sm font-medium text-text-main dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800">
                            Next
                        </button>
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