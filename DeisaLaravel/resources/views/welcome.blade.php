<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Deisa') }} - Santri Health System</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-600 bg-slate-50 selection:bg-indigo-500 selection:text-white">
    
    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-slate-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="#" class="flex items-center gap-3 group">
                    <div class="size-10 rounded-xl bg-gradient-to-br from-blue-600 to-slate-800 flex items-center justify-center shadow-lg shadow-blue-500/30 text-white font-bold text-xl group-hover:scale-110 transition-transform">D</div>
                    <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-slate-800 font-outfit">DEISA</span>
                </a>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-xl bg-slate-900 text-white font-medium hover:bg-slate-800 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-medium hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-0.5">Log In</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 z-0">
             <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-3xl translate-x-1/2 -translate-y-1/2"></div>
             <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-slate-500/10 rounded-full blur-3xl -translate-x-1/2 translate-y-1/2"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-blue-50 text-blue-600 font-semibold text-sm mb-6 border border-blue-100">
                Digital Health Monitoring System
            </span>
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-slate-900 font-outfit leading-tight mb-8">
                Smart Health for <br>
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-slate-800">Modern Pesantrens</span>
            </h1>
            <p class="text-xl text-slate-500 max-w-2xl mx-auto mb-10 leading-relaxed">
                Streamline health data management, track student wellness, and manage medicine inventory seamlessly with Deisa.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                 @auth
                    <a href="{{ url('/dashboard') }}" class="px-8 py-4 rounded-xl bg-slate-900 text-white font-bold text-lg hover:bg-slate-800 transition-all hover:scale-105 shadow-xl">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-8 py-4 rounded-xl bg-blue-600 text-white font-bold text-lg hover:bg-blue-700 transition-all hover:scale-105 shadow-xl shadow-blue-500/30">
                        Get Started
                    </a>
                    <!-- <a href="#features" class="px-8 py-4 rounded-xl bg-white text-slate-700 border border-slate-200 font-bold text-lg hover:bg-slate-50 transition-all hover:scale-105">
                        Learn More
                    </a> -->
                @endauth
            </div>

            <!-- Dashboard Preview -->
            <div class="mt-20 relative mx-auto max-w-5xl">
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-slate-600 rounded-2xl blur opacity-20"></div>
                <div class="relative rounded-2xl border border-slate-200 shadow-2xl overflow-hidden bg-white">
                     <!-- Using actual screenshot logic if I had it, but here using a mock layout with CSS -->
                     <div class="bg-slate-50 p-4 border-b border-slate-100 flex items-center gap-2">
                         <div class="flex gap-1.5">
                             <div class="size-3 rounded-full bg-red-400"></div>
                             <div class="size-3 rounded-full bg-amber-400"></div>
                             <div class="size-3 rounded-full bg-green-400"></div>
                         </div>
                         <div class="mx-auto bg-white px-3 py-1 rounded-md text-xs text-slate-400 border shadow-sm w-64 text-center">deisa-system.com</div>
                     </div>
                     <div class="grid grid-cols-4 gap-4 p-8 bg-slate-50 aspect-[16/9] items-start">
                         <!-- Sidebar Mock -->
                         <div class="col-span-1 bg-white h-full rounded-xl border border-slate-100 shadow-sm p-4 space-y-3">
                             <div class="h-8 w-8 bg-blue-100 rounded-lg mb-6"></div>
                             <div class="h-2 w-20 bg-slate-100 rounded"></div>
                             <div class="h-2 w-16 bg-slate-100 rounded"></div>
                             <div class="h-2 w-24 bg-slate-100 rounded"></div>
                             <div class="h-2 w-20 bg-slate-100 rounded"></div>
                         </div>
                         <!-- Content Mock -->
                         <div class="col-span-3 space-y-4">
                             <div class="grid grid-cols-3 gap-4">
                                 <div class="h-24 bg-white rounded-xl border border-slate-100 shadow-sm"></div>
                                 <div class="h-24 bg-white rounded-xl border border-slate-100 shadow-sm"></div>
                                 <div class="h-24 bg-white rounded-xl border border-slate-100 shadow-sm"></div>
                             </div>
                             <div class="h-48 bg-white rounded-xl border border-slate-100 shadow-sm"></div>
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 font-outfit mb-4">Everything You Need</h2>
                <p class="text-slate-500 max-w-2xl mx-auto">Comprehensive tools to manage santri health effectively.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group p-8 rounded-2xl bg-slate-50 hover:bg-white hover:shadow-xl transition-all border border-slate-100">
                    <div class="size-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">analytics</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Real-time Analytics</h3>
                    <p class="text-slate-500 leading-relaxed">
                        Monitor health trends, visualize sickness data, and generate reports instantly.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="group p-8 rounded-2xl bg-slate-50 hover:bg-white hover:shadow-xl transition-all border border-slate-100">
                    <div class="size-12 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">inventory</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Inventory Management</h3>
                    <p class="text-slate-500 leading-relaxed">
                        Track medicine stock levels, get low-stock alerts, and manage supplies efficiently.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="group p-8 rounded-2xl bg-slate-50 hover:bg-white hover:shadow-xl transition-all border border-slate-100">
                    <div class="size-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">admin_panel_settings</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Admin Controls</h3>
                    <p class="text-slate-500 leading-relaxed">
                        Manage user roles, approve registrations, and maintain data integrity with ease.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                 <div class="size-8 rounded-lg bg-gradient-to-br from-blue-600 to-slate-800 flex items-center justify-center font-bold text-sm">D</div>
                 <span class="text-xl font-bold font-outfit">DEISA</span>
            </div>
            <p class="text-slate-400 text-sm">
                &copy; {{ date('Y') }} Deisa System. Built with <span class="text-red-500">♥</span> for Pesantrens.
            </p>
        </div>
    </footer>

</body>
</html>
