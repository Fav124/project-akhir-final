<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Deisa - Detail Data Santri</title>
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
<a class="ml-1 text-sm font-medium text-text-muted hover:text-primary md:ml-2 dark:text-gray-400 dark:hover:text-white" href="#">Data Santri</a>
</div>
</li>
<li>
<div class="flex items-center">
<span class="material-symbols-outlined text-text-muted text-lg">chevron_right</span>
<span class="ml-1 text-sm font-medium text-text-main md:ml-2 dark:text-white">Detail Santri</span>
</div>
</li>
</ol>
</nav>
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
<div>
<h2 class="text-2xl font-bold text-text-main dark:text-white">Detail Santri</h2>
<p class="text-text-muted text-sm mt-1">Informasi lengkap data santri dan wali santri.</p>
</div>
<div class="flex gap-2">
<button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
<span class="material-symbols-outlined text-[20px]">arrow_back</span>
                        Kembali
                    </button>
<button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-surface-dark bg-primary rounded-lg hover:bg-green-400 focus:ring-4 focus:ring-green-300 dark:focus:ring-green-800 shadow-md shadow-primary/20 transition-all active:scale-95">
<span class="material-symbols-outlined text-[20px]">edit</span>
                        Edit Data
                    </button>
</div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
<div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
<div class="p-2 bg-primary/10 rounded-lg text-primary">
<span class="material-symbols-outlined">person</span>
</div>
<h3 class="text-lg font-bold text-text-main dark:text-white">Data Santri</h3>
</div>
<div class="flex flex-col items-center mb-8">
<div class="w-32 h-32 rounded-full p-1 bg-white dark:bg-gray-700 border-2 border-primary/30 shadow-sm mb-4">
<img alt="Foto Santri" class="w-full h-full object-cover rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDtdTBrX-jF0cwwFEZsQ19_S_JEeYMIIAe2Hio6mDPFrqtHeZwBQ7jKMBZxMC5ZC6X461upocuJwsaRT7l2Ei3kmd0gnPzIDGmKG887QOoc51D-i1GsAKt4PcVhCzymBj-ut4AEaP6_XzXc0Ule0KYHBZTV4I5nd1-_Cku0Nw9GIOSTvcY83_7oyAnq8NkgN7S8J8eIpawr3BF_t1ZJ6pxXm17tdhNbHt5QZC1dQqtbVWTYRs5Q38ekg6oS_kojnmtalnnqwkerQkAb"/>
</div>
<h4 class="text-xl font-bold text-text-main dark:text-white">Aisyah Humaira</h4>
<p class="text-sm text-text-muted">Kelas 10-A • NIS: 2023045</p>
</div>
<div class="space-y-5">
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
<div>
<p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">NIS</p>
<p class="text-base font-semibold text-text-main dark:text-white">2023045</p>
</div>
<div>
<p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Kelas</p>
<p class="text-base font-semibold text-text-main dark:text-white">10-A</p>
</div>
</div>
<div>
<p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Nama Lengkap</p>
<p class="text-base font-semibold text-text-main dark:text-white">Aisyah Humaira</p>
</div>
<div>
<p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Jenis Kelamin</p>
<div class="inline-flex items-center gap-2 px-3 py-1 bg-gray-100 dark:bg-gray-800 rounded-full text-sm font-medium text-text-main dark:text-white">
<span class="material-symbols-outlined text-base">female</span>
                                Perempuan
                            </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
<div>
<p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Tempat Lahir</p>
<p class="text-base font-semibold text-text-main dark:text-white">Surabaya</p>
</div>
<div>
<p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Tanggal Lahir</p>
<div class="flex items-center gap-2 text-text-main dark:text-white font-semibold">
<span class="material-symbols-outlined text-base text-text-muted">cake</span>
                                    12 Mei 2008
                                </div>
</div>
</div>
</div>
</div>
<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
<div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
<div class="p-2 bg-primary/10 rounded-lg text-primary">
<span class="material-symbols-outlined">supervisor_account</span>
</div>
<h3 class="text-lg font-bold text-text-main dark:text-white">Data Wali Santri</h3>
</div>
<div class="flex flex-row items-center gap-4 mb-8 p-4 bg-background-light dark:bg-background-dark/50 rounded-lg border border-gray-100 dark:border-gray-700">
<div class="w-16 h-16 rounded-full bg-gray-200 flex-none overflow-hidden border border-gray-200 dark:border-gray-600">
<img alt="Foto Wali" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDPQEcNyp1tNYxwXABacVjAwBU3P0H090I94cOLWHjMKXS-rATIUXTQWJ5RBhQkUpDQ8ZK94eeoY_xYvC3dMYeYmSnjDs3ePK-4TYiLSr3q8nfvfNv6g6NdrBtxbLT4oy50vh5bt36nRHLOI3p9PJdejx2VaQ7xPe4Z74HMYMQ9q3RMzPlkrmVKeMKpFrIOVxlIRD-SAZXRmQrEi7o7bRR8tc9mdJEIJEkv1cGO2fnfvTSevKItcBJxVzcv1hdpdGuYGD-YtMHrAaUn"/>
</div>
<div>
<h4 class="text-lg font-bold text-text-main dark:text-white">Budi Santoso</h4>
<p class="text-sm text-text-muted flex items-center gap-1">
<span class="material-symbols-outlined text-sm">family_restroom</span>
                                Ayah Kandung
                            </p>
</div>
</div>
<div class="space-y-5">
<div>
<p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Nama Lengkap Wali</p>
<p class="text-base font-semibold text-text-main dark:text-white">Budi Santoso</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
<div>
<p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Hubungan</p>
<p class="text-base font-semibold text-text-main dark:text-white">Ayah</p>
</div>
<div>
<p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Nomor HP</p>
<div class="flex items-center gap-2 text-text-main dark:text-white font-semibold">
<span class="material-symbols-outlined text-base text-text-muted">call</span>
                                    0812-3456-7890
                                </div>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
<div>
<p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Tempat Lahir</p>
<p class="text-base font-semibold text-text-main dark:text-white">Malang</p>
</div>
<div>
<p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Tanggal Lahir</p>
<div class="flex items-center gap-2 text-text-main dark:text-white font-semibold">
<span class="material-symbols-outlined text-base text-text-muted">calendar_month</span>
                                    15 Agustus 1978
                                </div>
</div>
</div>
<div>
<p class="text-xs font-medium text-text-muted uppercase tracking-wider mb-1">Alamat Lengkap</p>
<p class="text-base text-text-main dark:text-gray-300 leading-relaxed bg-gray-50 dark:bg-gray-800/50 p-3 rounded-lg border border-gray-100 dark:border-gray-700">
                                Jl. Mawar Melati No. 123, RT 05 RW 02, Kelurahan Sukamaju, Kecamatan Sukasari, Kota Surabaya, Jawa Timur
                            </p>
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