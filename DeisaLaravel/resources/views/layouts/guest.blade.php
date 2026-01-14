<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Deisa') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-slate-600 bg-slate-50">
    <div class="min-h-screen flex flex-col items-center justify-center p-6 relative overflow-hidden">
        
        <!-- Decoration -->
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-br from-blue-600 to-slate-800 rounded-b-[4rem] shadow-xl z-0"></div>
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute top-10 left-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute top-40 right-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden z-10 relative border border-slate-100">
            <!-- Header -->
            <div class="p-8 text-center bg-white border-b border-slate-100">
                <a href="/" class="inline-flex items-center gap-2 mb-2 group">
                     <div class="size-10 rounded-xl bg-gradient-to-br from-blue-600 to-slate-800 flex items-center justify-center shadow-lg shadow-blue-500/30 text-white font-bold text-xl group-hover:scale-110 transition-transform">D</div>
                    <span class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-slate-800 font-outfit">DEISA</span>
                </a>
                <p class="text-sm text-slate-500 mt-2">Digital Santri Health System</p>
            </div>
            
            <!-- Content -->
            <div class="p-8">
                 {{ $slot }}
            </div>
        </div>
         <p class="mt-8 text-center text-sm text-slate-500 z-10">
            &copy; {{ date('Y') }} Deisa System. All rights reserved.
        </p>
    </div>
</body>
</html>
