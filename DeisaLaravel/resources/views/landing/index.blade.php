@extends('layouts.app')

@section('title', 'DEISA - Digital Health Ecosystem Dar El-Ilmi')

@section('content')
    <div class="bg-[#FBFCFF] overflow-hidden" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 50)">
        
        <!-- Premium Navigation -->
        <nav :class="scrolled ? 'bg-white/80 backdrop-blur-xl border-b border-slate-100 py-4 shadow-sm' : 'bg-transparent py-8'" 
             class="fixed top-0 left-0 w-full z-[100] transition-all duration-500">
            <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
                <a href="#" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-deisa-blue rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/40 group-hover:rotate-12 transition-transform duration-500">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-black text-2xl tracking-tighter text-slate-900">DEISA<span class="text-deisa-blue">SYSTEM</span></span>
                </a>
                
                <div class="flex items-center gap-6">
                    <a href="{{ route('landing.features') }}" class="text-sm font-bold text-slate-500 hover:text-deisa-blue transition-colors">Fitur</a>
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-500 hover:text-deisa-blue transition-colors hidden sm:block">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-deisa-blue hover:bg-blue-700 text-white px-8 py-3 rounded-2xl text-sm font-black shadow-2xl shadow-blue-500/30 transition-all active:scale-95">Mulai Sekarang</a>
                </div>
            </div>
        </nav>

        <!-- Dynamic Hero Section -->
        <section class="relative pt-32 pb-20 lg:pt-56 lg:pb-40 overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-100/40 rounded-full blur-[120px] -mr-48 -mt-48 animate-pulse"></div>
                <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-indigo-100/30 rounded-full blur-[120px] -ml-40 -mb-40"></div>
            </div>

            <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
                <div class="max-w-4xl mx-auto space-y-10">
                    <div class="inline-flex items-center gap-3 px-5 py-2.5 bg-white text-deisa-blue rounded-2xl shadow-xl shadow-blue-500/10 border border-blue-50 animate-fade-in-up">
                        <span class="w-2 h-2 bg-rose-500 rounded-full animate-ping"></span>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em]">Next-Gen Health System v3.0</span>
                    </div>
                    
                    <h1 class="text-5xl md:text-6xl font-black text-slate-900 leading-[1.05] tracking-tighter animate-fade-in-up delay-100">
                        Modernize <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-deisa-blue via-indigo-600 to-blue-700">Student Wellness.</span>
                    </h1>
                    
                    <p class="text-lg md:text-xl text-slate-500 font-medium max-w-2xl mx-auto leading-relaxed animate-fade-in-up delay-200">
                        DEISA menghadirkan ekosistem kesehatan digital berbasis data untuk pesantren, memberikan efisiensi total bagi petugas medis dan keamanan bagi santri.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-6 animate-fade-in-up delay-300">
                        <button @click="$dispatch('open-focus-mode')" class="w-full sm:w-auto px-10 py-5 bg-slate-900 text-white rounded-3xl font-black text-xl shadow-2xl shadow-slate-900/30 hover:bg-slate-800 transition-all flex items-center justify-center gap-4 group">
                            <svg class="w-7 h-7 text-blue-400 group-hover:scale-125 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Demo Focus Mode
                        </button>
                        <div class="text-slate-400 font-bold flex items-center gap-4">
                            <div class="flex -space-x-3">
                                <img src="https://i.pravatar.cc/100?u=1" class="w-10 h-10 rounded-full border-2 border-white">
                                <img src="https://i.pravatar.cc/100?u=2" class="w-10 h-10 rounded-full border-2 border-white">
                                <img src="https://i.pravatar.cc/100?u=3" class="w-10 h-10 rounded-full border-2 border-white">
                            </div>
                            <span>Used by Admin & Petugas</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Problem Section (The Narrative) -->
        <section class="py-32 bg-slate-900 rounded-[4rem] mx-6 shadow-2xl overflow-hidden relative">
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(#3B82F6_2px,transparent_1px)] [background-size:40px_40px]"></div>
            </div>

            <div class="max-w-7xl mx-auto px-10 relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div class="space-y-8 animate-fade-in-up">
                    <h2 class="text-sm font-black text-blue-400 uppercase tracking-[0.4em]">Why DEISA?</h2>
                    <h3 class="text-4xl md:text-5xl font-black text-white leading-tight">Meninggalkan Era <br> Pencatatan Manual.</h3>
                    <p class="text-slate-300 text-lg md:text-xl font-medium leading-relaxed">
                        Data santri yang terfragmentasi, stok obat yang luput dari pantauan, dan diagnosa yang tidak konsisten adalah masalah kritis. DEISA hadir untuk menyelesaikan semua itu dalam satu dashboard.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-4 text-white font-bold italic">
                            <span class="w-6 h-6 bg-red-500/20 text-red-500 rounded-full flex items-center justify-center text-xs">✕</span>
                            Pencatatan kertas yang mudah hilang.
                        </li>
                        <li class="flex items-center gap-4 text-white font-bold italic">
                            <span class="w-6 h-6 bg-red-500/20 text-red-500 rounded-full flex items-center justify-center text-xs">✕</span>
                            Kesulitan melacak riwayat kesehatan jangka panjang.
                        </li>
                        <li class="flex items-center gap-4 text-white font-bold italic">
                            <span class="w-6 h-6 bg-red-500/20 text-red-500 rounded-full flex items-center justify-center text-xs">✕</span>
                            Resiko kesalahan pemberian stok obat kritis.
                        </li>
                    </ul>
                </div>
                <div class="grid grid-cols-2 gap-6 animate-scale-up-entrance delay-500">
                    <div class="space-y-6 mt-12">
                        <div class="bg-white/5 backdrop-blur-3xl p-8 rounded-[3rem] border border-white/10 text-center">
                            <div class="text-3xl font-black text-white mb-2 tracking-tighter">100%</div>
                            <div class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-tight">Digital Precision</div>
                        </div>
                        <div class="bg-blue-600 p-8 rounded-[3rem] shadow-2xl shadow-blue-600/20 text-center">
                            <div class="text-3xl font-black text-white mb-2 tracking-tighter">0%</div>
                            <div class="text-[10px] font-black text-blue-100 uppercase tracking-widest leading-tight">Missing Records</div>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="bg-indigo-600 p-8 rounded-[3rem] shadow-2xl shadow-indigo-600/20 text-center">
                            <div class="text-3xl font-black text-white mb-2 tracking-tighter">Real</div>
                            <div class="text-[10px] font-black text-indigo-100 uppercase tracking-widest leading-tight">Time Monitoring</div>
                        </div>
                        <div class="bg-white/5 backdrop-blur-3xl p-8 rounded-[3rem] border border-white/10 text-center">
                            <div class="text-3xl font-black text-white mb-2 tracking-tighter">Easy</div>
                            <div class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-tight">For Everyone</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- The Killer Feature: Summary Focus Mode -->
        <section class="py-32 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col lg:flex-row items-center gap-20">
                    <div class="flex-1 order-2 lg:order-1 relative">
                        <div class="absolute inset-0 bg-blue-500/5 rounded-full blur-[100px] -z-10 animate-pulse"></div>
                        <div class="bg-slate-950 rounded-[3rem] p-4 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] border border-white/10 overflow-hidden border-[12px] border-slate-900 group">
                            <div class="relative overflow-hidden aspect-video bg-slate-900 rounded-2xl flex items-center justify-center">
                                <div class="text-center group-hover:scale-110 transition-all duration-700">
                                    <div class="text-[11px] font-black text-rose-500 bg-rose-500/10 px-4 py-1.5 rounded-full border border-rose-500/20 mb-4 inline-block uppercase tracking-widest">Live Focus Visualization</div>
                                    <h4 class="text-3xl font-black text-white leading-none">Immersive View.</h4>
                                </div>
                                <div class="absolute bottom-6 right-6 flex gap-2">
                                    <div class="w-10 h-3 bg-blue-500 rounded-full animate-pulse"></div>
                                    <div class="w-4 h-3 bg-white/10 rounded-full"></div>
                                    <div class="w-4 h-3 bg-white/10 rounded-full"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Floating Insight -->
                        <div class="absolute -top-10 -right-6 bg-white p-6 rounded-3xl shadow-2xl border border-slate-50 animate-bounce transition-all">
                            <div class="flex items-center gap-3">
                                <div class="bg-emerald-50 text-emerald-500 p-2 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                </div>
                                <div class="text-xs font-black text-slate-900">95% Faster Review</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 order-1 lg:order-2 space-y-8">
                        <h2 class="text-sm font-black text-deisa-blue uppercase tracking-[0.4em]">Featured Innovation</h2>
                        <h3 class="text-5xl md:text-6xl font-black text-slate-900 leading-tight tracking-tighter">Feature Spotlight: <br> <span class="text-deisa-blue">Ringkasan Harian.</span></h3>
                        <p class="text-slate-500 text-lg md:text-xl font-medium leading-relaxed italic">
                            "Inovasi paling berharga bagi petugas medis di lapangan."
                        </p>
                        <p class="text-slate-500 text-lg leading-relaxed">
                            Mode operasional imersif yang memandu Anda melalui setiap kasus kritis hari ini. Tanpa kebisingan navigasi, tanpa distraction layar dashboard. Cukup fokus pada santri yang butuh pertolongan.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-10">
                            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 group hover:bg-white hover:shadow-xl transition-all">
                                <div class="text-blue-500 font-black text-2xl mb-2">01.</div>
                                <div class="text-sm font-black text-slate-900 mb-1">Immersive Interface</div>
                                <div class="text-xs text-slate-500 font-medium">Layar hitam premium yang memusatkan perhatian pada data utama.</div>
                            </div>
                            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 group hover:bg-white hover:shadow-xl transition-all">
                                <div class="text-indigo-500 font-black text-2xl mb-2">02.</div>
                                <div class="text-sm font-black text-slate-900 mb-1">Action Oriented</div>
                                <div class="text-xs text-slate-500 font-medium">Tandai sembuh, tambah stok, atau buat pengingat dalam 1 klik.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Global Ecosystem Glimpse (UI Preview) -->
        <section class="py-24 bg-white relative overflow-hidden">
             <div class="max-w-7xl mx-auto px-6">
                 <div class="flex flex-col lg:flex-row items-end justify-between mb-16 gap-8">
                     <div class="space-y-4 max-w-xl">
                         <h2 class="text-sm font-black text-blue-500 uppercase tracking-[0.4em]">Integrated Dashboard</h2>
                         <h3 class="text-4xl font-black text-slate-900 leading-tight">Pantau Seluruh Ekosistem <br> Dalam Satu Genggaman.</h3>
                         <p class="text-slate-500 font-medium">Dashboard DEISA dirancang untuk memberikan insight instan tanpa membuat Anda bingung. Data yang akurat menghasilkan keputusan yang tepat.</p>
                     </div>
                     <div class="hidden lg:block">
                         <a href="{{ route('landing.features') }}" class="flex items-center gap-3 text-slate-900 font-black group">
                             Lihat Detail Teknis <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                         </a>
                     </div>
                 </div>

                 <!-- Mockup Grid -->
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                     <div class="bg-slate-50 rounded-[2.5rem] border border-slate-100 p-8 space-y-6 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 transform hover:-translate-y-2">
                         <div class="flex justify-between items-center">
                             <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Health Index</div>
                             <div class="w-8 h-8 bg-blue-500 rounded-lg"></div>
                         </div>
                         <div class="text-4xl font-black text-slate-900">88.5%</div>
                         <div class="pt-4 border-t border-slate-200/60 flex items-center gap-2">
                             <span class="text-emerald-500 text-xs font-bold font-black">↑ 4.2%</span>
                             <span class="text-[10px] text-slate-400 font-bold uppercase">Average Recovery speed</span>
                         </div>
                     </div>
                     <div class="bg-slate-950 rounded-[2.5rem] p-8 space-y-6 shadow-2xl shadow-slate-900/40 transform hover:-translate-y-2 transition-all duration-500">
                         <div class="flex justify-between items-center">
                             <div class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Active Patients</div>
                             <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center"><svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg></div>
                         </div>
                         <div class="text-4xl font-black text-white">24 <span class="text-lg font-medium text-slate-400">Cases</span></div>
                         <div class="pt-4 border-t border-white/10 flex flex-wrap gap-2">
                             <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-full text-[9px] font-bold text-white uppercase tracking-widest">8 Flu</span>
                             <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-full text-[9px] font-bold text-white uppercase tracking-widest">2 Typhoid</span>
                         </div>
                     </div>
                     <div class="bg-slate-50 rounded-[2.5rem] border border-slate-100 p-8 space-y-6 transform hover:-translate-y-2 transition-all duration-500">
                         <div class="flex justify-between items-center">
                             <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pharmacy Stat</div>
                             <div class="w-8 h-8 bg-emerald-500 rounded-lg"></div>
                         </div>
                         <div class="text-4xl font-black text-slate-900">1.2K</div>
                         <div class="pt-4 border-t border-slate-200/60 flex items-center gap-2">
                             <span class="text-rose-500 text-xs font-bold font-black">! 2</span>
                             <span class="text-[10px] text-slate-400 font-bold uppercase">Critical stock alerts</span>
                         </div>
                     </div>
                 </div>
             </div>
        </section>

        <!-- Mobile-Web Sync Ecosystem -->
        <section class="py-24 bg-slate-50 border-y border-slate-100 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div class="space-y-6 animate-fade-in-up">
                    <h2 class="text-[10px] font-black text-rose-500 uppercase tracking-[0.4em]">Ecosystem</h2>
                    <h3 class="text-4xl font-black text-slate-900 tracking-tight">Sync Anywhere, <br> Anytime.</h3>
                    <p class="text-slate-500 font-medium leading-relaxed">
                        Data yang Anda masukkan di web akan langsung tersinkronisasi ke aplikasi mobile petugas. Memungkinkan mobilitas tinggi bagi tim kesehatan di lingkungan pesantren.
                    </p>
                    <div class="flex gap-4">
                        <div class="px-4 py-2 bg-white rounded-xl border border-slate-200 text-[10px] font-bold text-slate-600 shadow-sm flex items-center gap-2">
                             <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17 1H7c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-2-2-2zm0 18H7V5h10v14z"/></svg> Mobile Ready
                        </div>
                        <div class="px-4 py-2 bg-white rounded-xl border border-slate-200 text-[10px] font-bold text-slate-600 shadow-sm flex items-center gap-2">
                             <svg class="w-4 h-4 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><path d="M20 18c1.1 0 1.99-.9 1.99-2L22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z"/></svg> Desktop Optimized
                        </div>
                    </div>
                </div>
                <div class="relative animate-scale-up-entrance delay-300">
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-12 rounded-[3.5rem] shadow-2xl relative overflow-hidden group">
                        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                        <div class="relative z-10 flex justify-center">
                             <!-- Simple CSS Mobile Mockup -->
                             <div class="w-40 h-80 bg-slate-900 rounded-[2.5rem] border-[6px] border-slate-800 shadow-2xl relative overflow-hidden transform -rotate-6 group-hover:rotate-0 transition-transform duration-700">
                                 <div class="w-12 h-1 bg-slate-800 absolute top-4 left-1/2 -translate-x-1/2 rounded-full"></div>
                                 <div class="p-4 space-y-4 pt-10">
                                     <div class="w-full h-8 bg-white/10 rounded-lg"></div>
                                     <div class="w-3/4 h-4 bg-white/5 rounded-lg"></div>
                                     <div class="grid grid-cols-2 gap-2">
                                         <div class="h-12 bg-blue-500/20 rounded-xl"></div>
                                         <div class="h-12 bg-white/10 rounded-xl"></div>
                                     </div>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- System Interface Preview (UI Showcase) -->
        <section class="py-32 bg-white relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-24 space-y-6">
                    <h2 class="text-sm font-black text-deisa-blue uppercase tracking-[0.4em]">Crafted with Precision</h2>
                    <h3 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">The Ultimate Dashboard Experience.</h3>
                    <p class="text-slate-500 font-medium text-lg">Visualisasi data kompleks menjadi informasi sederhana yang siap diproses oleh petugas medis di setiap detik yang berharga.</p>
                </div>

                <div class="space-y-12">
                    <!-- Preview Row 1 -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div class="p-4 bg-slate-100 rounded-[3rem] border border-slate-200/60 shadow-inner group overflow-hidden">
                             <div class="bg-white rounded-[2rem] shadow-2xl p-6 space-y-6 transform group-hover:scale-105 transition-transform duration-1000">
                                 <div class="flex justify-between items-center border-b border-slate-50 pb-4">
                                     <div class="flex items-center gap-3">
                                         <div class="w-8 h-8 bg-blue-500 rounded-lg"></div>
                                         <span class="font-black text-slate-900 text-sm">Dashboard Overview</span>
                                     </div>
                                     <div class="flex gap-2">
                                         <div class="w-3 h-3 bg-slate-200 rounded-full"></div>
                                         <div class="w-3 h-3 bg-slate-200 rounded-full"></div>
                                     </div>
                                 </div>
                                 <div class="grid grid-cols-3 gap-4">
                                     <div class="h-20 bg-slate-50 rounded-2xl p-4 flex flex-col justify-between">
                                         <div class="text-[8px] font-black text-slate-400 uppercase">Active</div>
                                         <div class="text-xl font-black text-slate-900">12</div>
                                     </div>
                                      <div class="h-20 bg-slate-50 rounded-2xl p-4 flex flex-col justify-between">
                                         <div class="text-[8px] font-black text-slate-400 uppercase">Critical</div>
                                         <div class="text-xl font-black text-rose-500">2</div>
                                     </div>
                                      <div class="h-20 bg-slate-950 rounded-2xl p-4 flex flex-col justify-between">
                                         <div class="text-[8px] font-black text-slate-500 uppercase">Stock</div>
                                         <div class="text-xl font-black text-white">88%</div>
                                     </div>
                                 </div>
                                 <div class="h-32 bg-slate-50 rounded-[1.5rem] border border-slate-100 border-dashed flex items-center justify-center">
                                      <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Growth Analytics Chart Block</span>
                                 </div>
                             </div>
                        </div>
                        <div class="space-y-6">
                            <h4 class="text-3xl font-black text-slate-900 tracking-tight">Intelligence at a glance.</h4>
                            <p class="text-slate-500 leading-relaxed font-medium">Bukan sekadar tabel, tapi pusat komando yang memberi tahu Anda apa yang harus dilakukan sekarang melalui sistem prioritas cerdas.</p>
                            <a href="{{ route('landing.features') }}" class="inline-flex items-center gap-2 text-deisa-blue font-black text-sm uppercase tracking-widest group">
                                Learn More About Tech <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

                <div class="grid grid-cols-1 md:grid-cols-12 md:grid-rows-2 gap-6">
                    <!-- Feature 1: Health Monitoring -->
                    <div class="md:col-span-8 md:row-span-1 group p-10 bg-white rounded-[3.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 flex flex-col justify-between hover:shadow-2xl transition-all duration-500 overflow-hidden relative">
                        <div class="relative z-10">
                            <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mb-10 group-hover:rotate-12 transition-transform">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <h4 class="text-3xl font-black text-slate-900 mb-3 tracking-tighter">Advanced Medical Records.</h4>
                            <p class="text-slate-500 font-medium max-w-sm">Pantau diagnosa, riwayat medis santri, dan tren kesembuhan dengan data yang konsisten dan tersinkron ke semua perangkat.</p>
                        </div>
                        <div class="absolute right-0 bottom-0 opacity-10 group-hover:opacity-20 transition-all">
                             <img src="https://images.unsplash.com/photo-1576091160550-2173599211d0?auto=format&fit=crop&q=80&w=600" class="w-80 h-80 object-cover rounded-tl-[4rem]">
                        </div>
                    </div>

                    <!-- Feature 2: Smart Inventory -->
                    <div class="md:col-span-4 md:row-span-2 group p-10 bg-emerald-600 rounded-[3.5rem] shadow-xl shadow-emerald-600/20 text-white flex flex-col justify-between hover:scale-[1.02] transition-all duration-500">
                        <div>
                            <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mb-10">
                                <svg class="w-7 h-7 text-emerald-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                            </div>
                            <h4 class="text-3xl font-black mb-6 leading-tight">Smart Stock <br> Inventory.</h4>
                            <ul class="space-y-4 text-emerald-100 font-bold italic text-sm">
                                <li>• Minimal stock alerts</li>
                                <li>• Expiry date safeguard</li>
                                <li>• Auto-usage tracking</li>
                                <li>• Quick restock requests</li>
                            </ul>
                        </div>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-50">Operational Excellence</p>
                    </div>

                    <!-- Feature 3: Academic Sync -->
                    <div class="md:col-span-4 md:row-span-1 group p-10 bg-slate-900 rounded-[3.5rem] shadow-2xl text-white hover:bg-slate-800 transition-all duration-500">
                        <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-8">
                             <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.246.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <h4 class="text-2xl font-black mb-4 tracking-tighter">Academic Integration.</h4>
                        <p class="text-slate-400 text-sm font-medium leading-relaxed">Kenaikan kelas otomatis dan manajemen data akademik yang selaras dengan riwayat kesehatan.</p>
                    </div>

                    <!-- Feature 4: UX & Profile -->
                    <div class="md:col-span-4 md:row-span-1 group p-10 bg-white rounded-[3.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 hover:shadow-2xl transition-all duration-500 overflow-hidden">
                        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-8">
                             <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /></svg>
                        </div>
                        <h4 class="text-2xl font-black text-slate-900 mb-4 tracking-tighter">Personalized Experience.</h4>
                        <p class="text-slate-500 text-sm font-medium leading-relaxed">Tema custom, avatar personal, dan enkripsi profil tingkat tinggi untuk kenyamanan setiap user.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- The Tech Stack (For Presentation Credibility) -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6 flex flex-col items-center">
                <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.5em] mb-12">Powered by High-End Technology</h2>
                <div class="flex flex-wrap justify-center gap-12 grayscale opacity-40 hover:grayscale-0 hover:opacity-100 transition-all duration-1000">
                    <div class="text-2xl font-black text-slate-800">Laravel 12.x</div>
                    <div class="text-2xl font-black text-slate-800">Tailwind CSS</div>
                    <div class="text-2xl font-black text-slate-800">Alpine.js</div>
                    <div class="text-2xl font-black text-slate-800">MySQL</div>
                    <div class="text-2xl font-black text-slate-800">Vite Core</div>
                </div>
            </div>
        </section>

        <!-- Final CTA: The Closing Pitch -->
        <section class="py-32 bg-slate-900 relative">
            <div class="absolute inset-0 z-0">
                <div class="absolute bottom-0 right-0 w-[800px] h-[800px] bg-blue-600/10 rounded-full blur-[160px] pointer-events-none"></div>
            </div>

            <div class="max-w-5xl mx-auto px-6 text-center space-y-12 relative z-10 animate-fade-in-up">
                <div class="inline-block px-10 py-1 bg-white/5 border border-white/10 rounded-full text-blue-400 text-xs font-black uppercase tracking-widest">Aplication v3.0 Is Ready</div>
                <h2 class="text-3xl md:text-5xl font-black text-white leading-tight tracking-tight">Wujudkan Pesantren <br> Digital & Sehat Hari Ini.</h2>
                <p class="text-slate-400 text-base md:text-lg font-medium max-w-2xl mx-auto leading-relaxed">
                    DEISA bukan hanya sekadar software, tapi rekan terpercaya untuk menjamin masa depan santri yang lebih sehat.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-6 pt-10">
                    <a href="{{ route('register') }}" class="px-12 py-6 bg-deisa-blue hover:bg-blue-600 text-white rounded-3xl font-black text-2xl transition-all shadow-2xl shadow-blue-500/20 active:scale-95">Mulai Sekarang</a>
                    <a href="{{ route('login') }}" class="px-12 py-6 bg-white/10 hover:bg-white/20 text-white border border-white/10 rounded-3xl font-black text-2xl transition-all active:scale-95">Dashboard Entry</a>
                </div>
                <div class="pt-20 text-slate-600 text-[10px] font-bold uppercase tracking-widest">
                    &copy; {{ date('Y') }} Dar El-Ilmi Health Digital Ecosystem. Project Akhir Final.
                </div>
            </div>
        </section>
    </div>
@endsection