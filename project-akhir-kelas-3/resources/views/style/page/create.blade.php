<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Deisa - Tambah Data Santri</title>
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
<span class="ml-1 text-sm font-medium text-text-main md:ml-2 dark:text-white">Tambah Data Santri</span>
</div>
</li>
</ol>
</nav>
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
<div>
<h2 class="text-2xl font-bold text-text-main dark:text-white">Tambah Data Santri</h2>
<p class="text-text-muted text-sm mt-1">Fill in the details to register a new student.</p>
</div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
<div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
<div class="p-2 bg-primary/10 rounded-lg text-primary">
<span class="material-symbols-outlined">person</span>
</div>
<h3 class="text-lg font-bold text-text-main dark:text-white">Form Data Santri</h3>
</div>
<form>
<div class="space-y-6">
<div>
<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="foto_santri">Foto Santri</label>
<div class="flex items-center justify-center w-full">
<label class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500" for="foto_santri">
<div class="flex flex-col items-center justify-center pt-5 pb-6">
<span class="material-symbols-outlined text-4xl text-gray-400 mb-2">cloud_upload</span>
<p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
<p class="text-xs text-text-muted dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
</div>
<input class="hidden" id="foto_santri" type="file"/>
</label>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div>
<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="nis">NIS</label>
<input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary" id="nis" placeholder="e.g. 2023001" required="" type="text"/>
</div>
<div>
<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="nama_lengkap">Nama Lengkap</label>
<input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary" id="nama_lengkap" placeholder="Full Name" required="" type="text"/>
</div>
</div>
<div>
<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Kelamin</label>
<div class="flex gap-4">
<div class="flex items-center pl-4 border border-gray-200 rounded-lg dark:border-gray-700 w-full">
<input class="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" id="gender-male" name="gender" type="radio" value="Laki-laki"/>
<label class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="gender-male">Laki-laki</label>
</div>
<div class="flex items-center pl-4 border border-gray-200 rounded-lg dark:border-gray-700 w-full">
<input class="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" id="gender-female" name="gender" type="radio" value="Perempuan"/>
<label class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="gender-female">Perempuan</label>
</div>
</div>
</div>
<div>
<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="kelas">Kelas</label>
<select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary" id="kelas">
<option selected="">Pilih Kelas</option>
<option value="10-A">10-A</option>
<option value="10-B">10-B</option>
<option value="11-A">11-A</option>
<option value="11-B">11-B</option>
<option value="12-A">12-A</option>
</select>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div>
<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="tempat_lahir">Tempat Lahir</label>
<input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary" id="tempat_lahir" placeholder="City of Birth" required="" type="text"/>
</div>
<div>
<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="tanggal_lahir">Tanggal Lahir</label>
<div class="relative max-w-sm">
<div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
<span class="material-symbols-outlined text-gray-500 dark:text-gray-400 text-lg">calendar_today</span>
</div>
<input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary" id="tanggal_lahir" placeholder="Select date" type="date"/>
</div>
</div>
</div>
</div>
</form>
</div>
<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
<div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
<div class="p-2 bg-primary/10 rounded-lg text-primary">
<span class="material-symbols-outlined">supervisor_account</span>
</div>
<h3 class="text-lg font-bold text-text-main dark:text-white">Form Data Wali Santri</h3>
</div>
<form>
<div class="space-y-6">
<div>
<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="foto_wali">Foto Wali Santri</label>
<div class="flex items-center justify-center w-full">
<label class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500" for="foto_wali">
<div class="flex flex-col items-center justify-center pt-5 pb-6">
<span class="material-symbols-outlined text-4xl text-gray-400 mb-2">cloud_upload</span>
<p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
<p class="text-xs text-text-muted dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
</div>
<input class="hidden" id="foto_wali" type="file"/>
</label>
</div>
</div>
<div>
<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="nama_wali">Nama Lengkap Wali</label>
<input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary" id="nama_wali" placeholder="Guardian's Name" required="" type="text"/>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div>
<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="hubungan_wali">Hubungan</label>
<select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary" id="hubungan_wali">
<option selected="">Pilih Hubungan</option>
<option value="Ayah">Ayah</option>
<option value="Ibu">Ibu</option>
<option value="Kakak">Kakak</option>
<option value="Paman">Paman</option>
<option value="Bibi">Bibi</option>
<option value="Lainnya">Lainnya</option>
</select>
</div>
<div>
<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="nomor_hp">Nomor HP</label>
<input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary" id="nomor_hp" placeholder="08xxxxxxxxxx" required="" type="tel"/>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div>
<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="tempat_lahir_wali">Tempat Lahir</label>
<input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary" id="tempat_lahir_wali" placeholder="City of Birth" required="" type="text"/>
</div>
<div>
<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="tanggal_lahir_wali">Tanggal Lahir</label>
<div class="relative max-w-sm">
<div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
<span class="material-symbols-outlined text-gray-500 dark:text-gray-400 text-lg">calendar_today</span>
</div>
<input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary" id="tanggal_lahir_wali" placeholder="Select date" type="date"/>
</div>
</div>
</div>
<div>
<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="alamat">Alamat Lengkap</label>
<textarea class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary" id="alamat" placeholder="Write full address here..." rows="3"></textarea>
</div>
</div>
</form>
</div>
</div>
<div class="mt-8 flex justify-end gap-3">
<button class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 transition-colors" type="button">
                        Cancel
                    </button>
<button class="px-5 py-2.5 text-sm font-medium text-surface-dark bg-primary rounded-lg hover:bg-green-400 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-primary/20 transition-all active:scale-95 flex items-center gap-2" type="submit">
<span class="material-symbols-outlined text-[20px]">save</span>
                        Simpan Data
                    </button>
</div>
<footer class="mt-12 text-center text-xs text-text-muted pb-4">
<p>© 2024 Deisa Health System. All rights reserved.</p>
</footer>
</main>
</div>
</div>
</body></html>