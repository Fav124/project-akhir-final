<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Laporan PDF - Deisa Health</title>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet"/>
<!-- Material Symbols -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Theme Configuration -->
<script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "#13ec80",
              "primary-dark": "#0dbd63",
              "background-light": "#f6f8f7",
              "background-dark": "#102219",
              "surface-light": "#ffffff",
              "surface-dark": "#1a2c24",
              "border-light": "#e7f3ed",
              "border-dark": "#234033",
            },
            fontFamily: {
              "display": ["Manrope", "sans-serif"]
            },
            borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
          },
        },
      }
    </script>
<style>
        /* Custom scrollbar for sidebar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 font-display transition-colors duration-200">
<div class="flex h-screen w-full overflow-hidden">
<!-- SideNavBar -->
<aside class="w-64 flex-shrink-0 flex flex-col justify-between bg-surface-light dark:bg-surface-dark border-r border-border-light dark:border-border-dark transition-colors duration-200">
<div class="flex flex-col h-full">
<!-- Logo Section -->
<div class="p-6 pb-2">
<div class="flex items-center gap-3">
<div class="bg-center bg-no-repeat bg-cover rounded-full h-10 w-10 bg-primary/20 flex items-center justify-center text-primary font-bold text-xl">
                        D
                    </div>
<div class="flex flex-col">
<h1 class="text-slate-900 dark:text-white text-base font-bold leading-normal">Deisa Health</h1>
<p class="text-slate-500 dark:text-slate-400 text-xs font-medium leading-normal">Admin Panel</p>
</div>
</div>
</div>
<!-- Navigation Links -->
<nav class="flex-1 overflow-y-auto px-4 py-4 gap-1 flex flex-col no-scrollbar">
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg group hover:bg-slate-100 dark:hover:bg-white/5 transition-colors" href="#">
<span class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-hover:text-primary transition-colors">dashboard</span>
<span class="text-slate-600 dark:text-slate-300 text-sm font-medium group-hover:text-slate-900 dark:group-hover:text-white transition-colors">Dashboard</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg group hover:bg-slate-100 dark:hover:bg-white/5 transition-colors" href="#">
<span class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-hover:text-primary transition-colors">group</span>
<span class="text-slate-600 dark:text-slate-300 text-sm font-medium group-hover:text-slate-900 dark:group-hover:text-white transition-colors">Data User</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg group hover:bg-slate-100 dark:hover:bg-white/5 transition-colors" href="#">
<span class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-hover:text-primary transition-colors">person</span>
<span class="text-slate-600 dark:text-slate-300 text-sm font-medium group-hover:text-slate-900 dark:group-hover:text-white transition-colors">Data Santri</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg group hover:bg-slate-100 dark:hover:bg-white/5 transition-colors" href="#">
<span class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-hover:text-primary transition-colors">school</span>
<span class="text-slate-600 dark:text-slate-300 text-sm font-medium group-hover:text-slate-900 dark:group-hover:text-white transition-colors">Data Kelas</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg group hover:bg-slate-100 dark:hover:bg-white/5 transition-colors" href="#">
<span class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-hover:text-primary transition-colors">medication</span>
<span class="text-slate-600 dark:text-slate-300 text-sm font-medium group-hover:text-slate-900 dark:group-hover:text-white transition-colors">Data Obat</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg group hover:bg-slate-100 dark:hover:bg-white/5 transition-colors" href="#">
<span class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-hover:text-primary transition-colors">sick</span>
<span class="text-slate-600 dark:text-slate-300 text-sm font-medium group-hover:text-slate-900 dark:group-hover:text-white transition-colors">Santri Sakit</span>
</a>
<!-- Active State -->
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary/10 dark:bg-primary/20" href="#">
<span class="material-symbols-outlined text-primary-dark dark:text-primary fill-1">description</span>
<span class="text-primary-dark dark:text-primary text-sm font-bold">Laporan</span>
</a>
</nav>
<div class="p-4 border-t border-border-light dark:border-border-dark">
<div class="flex items-center gap-3 px-2 py-2 cursor-pointer hover:opacity-80 transition-opacity">
<span class="material-symbols-outlined text-slate-400 dark:text-slate-500">logout</span>
<p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Log Out</p>
</div>
</div>
</div>
</aside>
<!-- Main Content Wrapper -->
<div class="flex-1 flex flex-col h-full overflow-hidden relative">
<!-- TopNavBar (Simplified for Dashboard context) -->
<header class="flex items-center justify-between px-8 py-4 bg-background-light dark:bg-background-dark z-10 sticky top-0">
<div class="flex items-center gap-4">
<!-- Mobile Menu Trigger (Visible only on small screens conceptually) -->
<button class="lg:hidden p-2 text-slate-500">
<span class="material-symbols-outlined">menu</span>
</button>
<div class="hidden md:flex flex-col">
<h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Laporan</h2>
<p class="text-sm text-slate-500 dark:text-slate-400">Kelola dan unduh laporan kesehatan santri</p>
</div>
</div>
<div class="flex items-center gap-4">
<button class="p-2 rounded-full text-slate-400 hover:bg-white/50 dark:hover:bg-white/10 transition-colors">
<span class="material-symbols-outlined">notifications</span>
</button>
<div class="flex items-center gap-3 pl-4 border-l border-slate-200 dark:border-slate-700">
<div class="text-right hidden sm:block">
<p class="text-sm font-semibold text-slate-900 dark:text-white">Dr. Farhan</p>
<p class="text-xs text-slate-500 dark:text-slate-400">Kepala Klinik</p>
</div>
<div class="h-10 w-10 rounded-full bg-slate-200 dark:bg-slate-700 bg-cover bg-center ring-2 ring-white dark:ring-slate-800" data-alt="Profile picture of the admin user, a doctor" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAvE3CkWFnfvFEzAWq05mEWT5ZpH4JVOYdxp_qR0OX1-tz_Ks65WbrjMBd7Bf2TieitYmxAfGJSYb6YT53BG54YrQTwsSO3PFW-78gBMZDn7cO49tdlxBzwpsKOsh1g_3mSeScMCCQKX8ZGbRSq-1-4yjpHOFv9nwAsjpwmyXYqr1lufOLONnFcGY9CaI7o9IycSOfVZ4otnFZoWcnAbrbl5NiTl9ur-StJXciWq0GynTldMx9BXZqX2YkzObnruc3vSZoqPSg1xUAC');"></div>
</div>
</div>
</header>
<!-- Scrollable Content -->
<main class="flex-1 overflow-y-auto px-4 md:px-8 pb-10">
<!-- Controls Bar -->
<div class="max-w-5xl mx-auto w-full mb-6 mt-4">
<div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 bg-surface-light dark:bg-surface-dark p-4 rounded-xl shadow-sm border border-border-light dark:border-border-dark">
<div class="flex flex-col gap-1 w-full md:w-auto">
<label class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">Periode Laporan</label>
<div class="flex gap-2">
<div class="relative">
<select class="appearance-none h-10 pl-4 pr-10 rounded-lg bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark text-slate-700 dark:text-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary/50 cursor-pointer">
<option>Bulan Ini (Oktober 2023)</option>
<option>Bulan Lalu (September 2023)</option>
<option>Tahun Ini (2023)</option>
</select>
<span class="material-symbols-outlined absolute right-2 top-2.5 text-primary pointer-events-none text-xl">expand_more</span>
</div>
<button class="h-10 px-4 rounded-lg border border-border-light dark:border-border-dark hover:bg-slate-50 dark:hover:bg-white/5 text-slate-600 dark:text-slate-300 transition-colors">
<span class="material-symbols-outlined text-lg align-middle">calendar_today</span>
</button>
</div>
</div>
<button class="flex items-center gap-2 h-10 px-6 bg-primary hover:bg-primary-dark text-slate-900 font-bold text-sm rounded-lg shadow-lg shadow-primary/20 transition-all hover:translate-y-[-1px] active:translate-y-[0px] w-full md:w-auto justify-center">
<span class="material-symbols-outlined text-xl">download</span>
<span>Download PDF</span>
</button>
</div>
</div>
<!-- Report Paper Container -->
<!-- This container simulates a piece of paper for the "Print Preview" feel -->
<div class="max-w-5xl mx-auto w-full bg-white dark:bg-[#15201b] rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-8 md:p-12 relative">
<!-- Report Header -->
<div class="flex justify-between items-start border-b border-slate-100 dark:border-slate-800 pb-6 mb-8">
<div>
<h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Laporan Kesehatan Bulanan</h2>
<p class="text-slate-500 dark:text-slate-400">Periode: <span class="font-medium text-slate-800 dark:text-slate-200">1 Oktober - 31 Oktober 2023</span></p>
</div>
<div class="text-right hidden sm:block">
<div class="text-xl font-bold text-primary mb-1">DEISA</div>
<p class="text-xs text-slate-400">Pondok Pesantren Al-Ikhlas<br/>Jl. Pesantren No. 12, Jawa Timur</p>
</div>
</div>
<!-- Stats Summary Row -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
<!-- Stat 1 -->
<div class="p-5 rounded-xl bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/5 flex flex-col items-center text-center">
<div class="h-10 w-10 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 flex items-center justify-center mb-3">
<span class="material-symbols-outlined">sick</span>
</div>
<p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Santri Sakit</p>
<p class="text-3xl font-bold text-slate-900 dark:text-white mt-1">45</p>
<span class="text-xs text-green-600 font-medium mt-1 flex items-center gap-1">
<span class="material-symbols-outlined text-sm">trending_down</span> -12% dari bulan lalu
                        </span>
</div>
<!-- Stat 2 -->
<div class="p-5 rounded-xl bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/5 flex flex-col items-center text-center">
<div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-3">
<span class="material-symbols-outlined">pill</span>
</div>
<p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Obat Keluar</p>
<p class="text-3xl font-bold text-slate-900 dark:text-white mt-1">128 <span class="text-sm font-normal text-slate-400">item</span></p>
<span class="text-xs text-slate-400 font-medium mt-1">Terbanyak: Paracetamol</span>
</div>
<!-- Stat 3 -->
<div class="p-5 rounded-xl bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/5 flex flex-col items-center text-center">
<div class="h-10 w-10 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center mb-3">
<span class="material-symbols-outlined">thermometer</span>
</div>
<p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Keluhan Utama</p>
<p class="text-3xl font-bold text-slate-900 dark:text-white mt-1">Demam</p>
<span class="text-xs text-slate-400 font-medium mt-1">20 Kasus tercatat</span>
</div>
</div>
<!-- Detailed Tables Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
<!-- Table 1: Top Sickness / Students -->
<div class="flex flex-col gap-4">
<div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
<h3 class="font-bold text-lg text-slate-900 dark:text-white">Santri Sering Sakit</h3>
<a class="text-primary text-sm font-medium hover:underline" href="#">Lihat Semua</a>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr>
<th class="py-3 pr-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama</th>
<th class="py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Kelas</th>
<th class="py-3 pl-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Frekuensi</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 dark:divide-slate-800">
<tr class="group">
<td class="py-3 pr-4">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 bg-cover bg-center" data-alt="Portrait of student Ahmad" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAME0moOvsurXlGpAM0RmpUQj3gZFSiCVZ4oD8Vj_Fqo35jhJOPcu7v7TpHavA8X3NCkPJPiwMEe6vsK7w_V6P3O9DgDhReY2rKXIb7B0nZXU8pylGfZFY1JLCUIGX3dru2_O4tEnIE3V5f_-oSmBgnp5BP6Arm_QfgEGCbIqwlJ_GpFNQj2RiasPC6pn25PdN_ilX6QOJBOgvQ_bXu-nDVLWvp3mlQIVVsJVW5AXlqB83KAOSfmaSbhCrcRopXhFrj95fBoHuZdhNE');"></div>
<p class="text-sm font-medium text-slate-900 dark:text-white">Ahmad Zaky</p>
</div>
</td>
<td class="py-3 px-4 text-sm text-slate-500 dark:text-slate-400">XI-A</td>
<td class="py-3 pl-4 text-right">
<span class="inline-flex items-center justify-center px-2 py-1 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-xs font-bold">4x</span>
</td>
</tr>
<tr class="group">
<td class="py-3 pr-4">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 bg-cover bg-center" data-alt="Portrait of student Budi" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAdUneXByhx8qkPVUteRM-o276gc5v8pHceN3IV0GMK8Dm8XfluLfHNIOP1YUWnd-pXRshNp6ikCmuFpBiZbSY6_HTyWWM93CMh-NpxCe9zWbxHL2KGKluLbdcDftDqlnVceL4SAOI502nEvFcwypF-TDRdFbNvXF36Qv4mZvbdlLZiriUCa1-EBm5XESWERgp3skZe_IqrK9T14_uUNlx50MX7ajelHgNuHNamlCqd1zidOOkr1xpa60N5WJoOeydMlk3aIjXdn_6w');"></div>
<p class="text-sm font-medium text-slate-900 dark:text-white">Budi Santoso</p>
</div>
</td>
<td class="py-3 px-4 text-sm text-slate-500 dark:text-slate-400">X-C</td>
<td class="py-3 pl-4 text-right">
<span class="inline-flex items-center justify-center px-2 py-1 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 text-xs font-bold">3x</span>
</td>
</tr>
<tr class="group">
<td class="py-3 pr-4">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 bg-cover bg-center" data-alt="Portrait of student Siti" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDvPy7pHj0dA4DX8asVbsX3C0JgAlMcnqBgylEpHrVF6vEMxai6bEf6SZq1j_jraIwNsltB2zL3WwRlb-PoamG1RG42juk9VznqC2p5hVmNAXzyM9JfqKJbRdmxyWQHPpSQEublV2GsbXeyzLuSFtA0QM4hOdqizoj0p0uDOZIBybp_BMUQ63Jo1jk3dbBopaioT8A5VDGM5YgoMdURLZ4W2XngFTiN1YqmmuKVs5Vyu9B8wg_U9eB1VXJANG4-p1JQmRS5lrDeFW6V');"></div>
<p class="text-sm font-medium text-slate-900 dark:text-white">Siti Aminah</p>
</div>
</td>
<td class="py-3 px-4 text-sm text-slate-500 dark:text-slate-400">XII-B</td>
<td class="py-3 pl-4 text-right">
<span class="inline-flex items-center justify-center px-2 py-1 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 text-xs font-bold">2x</span>
</td>
</tr>
</tbody>
</table>
</div>
</div>
<!-- Table 2: Medicine Usage -->
<div class="flex flex-col gap-4">
<div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
<h3 class="font-bold text-lg text-slate-900 dark:text-white">Penggunaan Obat</h3>
</div>
<div class="space-y-4">
<!-- Med Item 1 -->
<div class="flex items-center justify-between group">
<div class="flex items-center gap-3">
<div class="h-8 w-8 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-500 flex items-center justify-center">
<span class="material-symbols-outlined text-lg">pill</span>
</div>
<div>
<p class="text-sm font-semibold text-slate-900 dark:text-white">Paracetamol 500mg</p>
<div class="w-32 h-1.5 bg-slate-100 dark:bg-slate-700 rounded-full mt-1 overflow-hidden">
<div class="h-full bg-primary w-[75%] rounded-full"></div>
</div>
</div>
</div>
<div class="text-right">
<p class="text-sm font-bold text-slate-900 dark:text-white">45 pcs</p>
<p class="text-xs text-slate-500">Stok: 120</p>
</div>
</div>
<!-- Med Item 2 -->
<div class="flex items-center justify-between group">
<div class="flex items-center gap-3">
<div class="h-8 w-8 rounded-lg bg-purple-50 dark:bg-purple-900/20 text-purple-500 flex items-center justify-center">
<span class="material-symbols-outlined text-lg">vaccines</span>
</div>
<div>
<p class="text-sm font-semibold text-slate-900 dark:text-white">Amoxicillin</p>
<div class="w-32 h-1.5 bg-slate-100 dark:bg-slate-700 rounded-full mt-1 overflow-hidden">
<div class="h-full bg-purple-400 w-[45%] rounded-full"></div>
</div>
</div>
</div>
<div class="text-right">
<p class="text-sm font-bold text-slate-900 dark:text-white">28 pcs</p>
<p class="text-xs text-slate-500">Stok: 50</p>
</div>
</div>
<!-- Med Item 3 -->
<div class="flex items-center justify-between group">
<div class="flex items-center gap-3">
<div class="h-8 w-8 rounded-lg bg-orange-50 dark:bg-orange-900/20 text-orange-500 flex items-center justify-center">
<span class="material-symbols-outlined text-lg">healing</span>
</div>
<div>
<p class="text-sm font-semibold text-slate-900 dark:text-white">Vitamin C</p>
<div class="w-32 h-1.5 bg-slate-100 dark:bg-slate-700 rounded-full mt-1 overflow-hidden">
<div class="h-full bg-orange-400 w-[30%] rounded-full"></div>
</div>
</div>
</div>
<div class="text-right">
<p class="text-sm font-bold text-slate-900 dark:text-white">15 pcs</p>
<p class="text-xs text-slate-500">Stok: 200</p>
</div>
</div>
<!-- Med Item 4 -->
<div class="flex items-center justify-between group">
<div class="flex items-center gap-3">
<div class="h-8 w-8 rounded-lg bg-teal-50 dark:bg-teal-900/20 text-teal-500 flex items-center justify-center">
<span class="material-symbols-outlined text-lg">water_drop</span>
</div>
<div>
<p class="text-sm font-semibold text-slate-900 dark:text-white">Obat Batuk Sirup</p>
<div class="w-32 h-1.5 bg-slate-100 dark:bg-slate-700 rounded-full mt-1 overflow-hidden">
<div class="h-full bg-teal-400 w-[15%] rounded-full"></div>
</div>
</div>
</div>
<div class="text-right">
<p class="text-sm font-bold text-slate-900 dark:text-white">8 btl</p>
<p class="text-xs text-slate-500">Stok: 30</p>
</div>
</div>
</div>
</div>
</div>
<!-- Footer of Report -->
<div class="mt-12 pt-6 border-t border-slate-100 dark:border-slate-800 flex justify-between items-center text-xs text-slate-400">
<p>Generated by System Deisa Health App</p>
<p>Tanggal Cetak: 24 Oktober 2023</p>
</div>
<!-- Watermark for preview feel -->
<div class="absolute inset-0 pointer-events-none flex items-center justify-center opacity-[0.02] dark:opacity-[0.05] z-0 overflow-hidden">
<span class="text-[120px] font-bold rotate-[-30deg] text-slate-900 dark:text-white select-none whitespace-nowrap">PREVIEW</span>
</div>
</div>
</main>
</div>
</div>
</body></html>