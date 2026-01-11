<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DEISA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&family=Outfit:wght@700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background: radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.1) 0, transparent 50%), 
                        radial-gradient(at 100% 100%, rgba(59, 130, 246, 0.1) 0, transparent 50%),
                        #f9fafb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        .text-display {
            font-family: 'Outfit', sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 40px 80px -15px rgba(0, 0, 0, 0.08);
        }

        @keyframes slideInUp {
            from { transform: translateY(40px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .animate-up {
            animation: slideInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="antialiased">
    <div class="fixed top-0 right-0 -mt-24 -mr-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="fixed bottom-0 left-0 -mb-24 -ml-24 w-96 h-96 bg-blue-500/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="w-full max-w-md px-6 animate-up">
        <!-- Logo Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl shadow-2xl shadow-emerald-200 mb-8 transform hover:scale-110 transition-transform duration-500">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <h1 class="text-5xl font-black text-display text-gray-900 tracking-tighter mb-2">DEISA</h1>
            <p class="text-gray-400 font-bold uppercase tracking-[0.3em] text-[10px]">Auth Gateway</p>
        </div>

        <!-- Login Card -->
        <div class="glass-card rounded-[3rem] p-12 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            
            <form action="{{ url('/login') }}" method="POST" class="space-y-8 relative z-10">
                @csrf
                
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Secure Email</label>
                    <div class="relative group/input">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-300 group-focus-within/input:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                            </svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="block w-full pl-14 pr-6 py-5 rounded-[1.5rem] border border-gray-100 bg-white/50 focus:bg-white focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition-all outline-none font-bold text-gray-700 shadow-sm"
                            placeholder="your@email.com">
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Encrypted Password</label>
                    <div class="relative group/input">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-300 group-focus-within/input:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" required
                            class="block w-full pl-14 pr-6 py-5 rounded-[1.5rem] border border-gray-100 bg-white/50 focus:bg-white focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition-all outline-none font-bold text-gray-700 shadow-sm"
                            placeholder="••••••••">
                    </div>
                </div>

                @if($errors->any())
                <div class="p-6 rounded-2xl bg-rose-50/50 border border-rose-100 backdrop-blur-md">
                    <div class="flex items-center gap-3 mb-2">
                        <svg class="w-5 h-5 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <span class="text-[10px] font-black uppercase tracking-widest text-rose-600">Terjadi Kesalahan</span>
                    </div>
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="text-xs font-bold text-rose-700 leading-tight">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <button type="submit" 
                    class="group w-full py-6 rounded-[1.5rem] font-black text-white bg-gray-900 shadow-2xl shadow-gray-200 hover:bg-emerald-600 hover:shadow-emerald-200 transition-all duration-500 transform hover:-translate-y-1.5 active:scale-95 uppercase tracking-[0.2em] text-[10px] flex items-center justify-center gap-3">
                    Unlock Portal
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </form>

            <div class="mt-10 pt-10 border-t border-gray-100/50 text-center relative z-10">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-relaxed">
                    Access Denied? <br> 
                    <span class="text-emerald-500 mt-2 inline-block hover:underline cursor-pointer transition-all">Hubungi IT Support Pesantren</span>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center mt-12 text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] opacity-30">
            &copy; {{ date('Y') }} Deisa. High Performance Security.
        </p>
    </div>
</body>
</html>
