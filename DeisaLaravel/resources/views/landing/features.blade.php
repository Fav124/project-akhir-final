@extends('layouts.app')

@section('title', 'Spesifikasi & Fitur Lengkap | DEISA Ecosystem')

@section('content')
    <div class="bg-[#FBFCFF]" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 50)">
        
        <!-- Premium Navigation -->
        <nav :class="scrolled ? 'bg-white/90 backdrop-blur-xl border-b border-slate-100 py-4 shadow-sm' : 'bg-transparent py-8'" 
             class="fixed top-0 left-0 w-full z-[110] transition-all duration-500">
            <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
                <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-deisa-blue rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/40 group-hover:rotate-12 transition-transform duration-500">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-black text-2xl tracking-tighter text-slate-900">DEISA<span class="text-deisa-blue text-sm align-top leading-none ml-0.5">Ecosystem</span></span>
                </a>
                
                <div class="flex items-center gap-6">
                    <a href="{{ route('landing') }}" class="text-sm font-bold text-slate-500 hover:text-deisa-blue transition-colors">Home</a>
                    <a href="{{ route('register') }}" class="bg-deisa-blue hover:bg-blue-700 text-white px-8 py-3 rounded-2xl text-sm font-black shadow-2xl shadow-blue-500/30 transition-all active:scale-95">Mulai Sekarang</a>
                </div>
            </div>
        </nav>

        <!-- Dynamic Page Header -->
        <section class="relative pt-48 pb-32 bg-slate-900 text-white overflow-hidden rounded-b-[4rem]">
            <div class="absolute inset-0 z-0">
                <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-blue-600/10 rounded-full blur-[160px]"></div>
                <div class="absolute bottom-0 left-0 w-full h-full bg-[radial-gradient(#ffffff0a_1px,transparent_1px)] [background-size:40px_40px]"></div>
            </div>

            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="max-w-3xl space-y-6">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 rounded-full text-blue-400 text-[10px] font-black uppercase tracking-widest animate-fade-in-up">Technical Encyclopedia</div>
                    <h1 class="text-5xl md:text-7xl font-black leading-[1.05] tracking-tight animate-fade-in-up delay-100">
                        The Core of <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-300">Digital Care.</span>
                    </h1>
                    <p class="text-slate-200 text-xl font-medium leading-relaxed max-w-2xl animate-fade-in-up delay-200">
                        Eksplorasi mendalam tentang bagaimana teknologi DEISA membantu institusi pendidikan mengotomatisasi pemantauan kesehatan santri secara real-time.
                    </p>
                </div>
            </div>
        </section>

        <!-- Deep Dive Sections Container -->
        <div class="max-w-7xl mx-auto px-6 py-24 space-y-48">
            
            <!-- 1. RINGKASAN HARIAN (FOCUS MODE) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
                <div class="space-y-10 order-2 lg:order-1">
                    <div class="space-y-4">
                        <div class="w-16 h-16 bg-slate-950 text-blue-400 rounded-2xl flex items-center justify-center shadow-2xl border border-white/5">
                            <svg class="w-8 h-8 font-black" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <h2 class="text-5xl font-black text-slate-900 tracking-tight leading-none">Immersive <br> Focus Mode.</h2>
                    </div>
                    
                    <div class="prose prose-slate max-w-none text-slate-400 space-y-6 leading-relaxed">
                        <div class="space-y-2">
                             <h4 class="text-slate-900 font-black uppercase text-[11px] tracking-widest">Apa itu Focus Mode?</h4>
                             <p>Ini adalah inovasi UI/UX yang didesain untuk "Zero Latency Mental Load". Petugas medis seringkali kewalahan dengan dashboard yang terlalu ramai. Focus mode menyederhanakan data menjadi satu entitas per layar.</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100">
                                 <h5 class="text-slate-900 font-bold text-sm mb-2">Technical Insight</h5>
                                 <p class="text-xs text-slate-500">Menggunakan <strong>Alpine.js reactive indexing</strong> untuk mengontrol state "active patient". Seluruh UI di-render di layer teratas (z-index 100+) untuk isolasi total.</p>
                            </div>
                            <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100">
                                 <h5 class="text-slate-900 font-bold text-sm mb-2">Operational Impact</h5>
                                 <p class="text-xs text-slate-500">Meningkatkan akurasi input sebesar 40% dan mempercepat waktu rotasi pasien harian karena interaksi tombol diposisikan pada area jempol.</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-slate-900 font-black text-sm italic">Core Capabilities:</h4>
                        <ul class="grid grid-cols-1 gap-3">
                            <li class="flex items-center gap-3 text-sm font-bold text-slate-700 bg-white p-4 rounded-2xl shadow-sm border border-slate-50"><span class="w-2 h-2 bg-emerald-500 rounded-full"></span> One-Click Recovery Updates</li>
                            <li class="flex items-center gap-3 text-sm font-bold text-slate-700 bg-white p-4 rounded-2xl shadow-sm border border-slate-50"><span class="w-2 h-2 bg-blue-500 rounded-full"></span> Direct Stock Usage Deductions</li>
                            <li class="flex items-center gap-3 text-sm font-bold text-slate-700 bg-white p-4 rounded-2xl shadow-sm border border-slate-50"><span class="w-2 h-2 bg-amber-500 rounded-full"></span> Dynamic Follow-up Reminders</li>
                        </ul>
                    </div>
                </div>
                
                <div class="order-1 lg:order-2 relative animate-scale-up-entrance">
                    <div class="absolute inset-0 bg-blue-600/10 rounded-full blur-[100px] animate-pulse"></div>
                    <!-- Detailed UI Mockup -->
                    <div class="relative bg-slate-950 rounded-[4rem] p-1.5 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] border-[14px] border-slate-900 overflow-hidden transform rotate-2 hover:rotate-0 transition-all duration-1000 group">
                         <div class="bg-slate-900 aspect-[4/5] p-8 flex flex-col justify-between">
                             <div class="flex justify-between items-center">
                                 <div class="w-12 h-12 bg-white/5 rounded-2xl border border-white/10"></div>
                                 <div class="px-4 py-1.5 bg-white/5 border border-white/10 rounded-full text-[9px] font-black text-blue-400 uppercase tracking-widest">Patient 01/24</div>
                             </div>
                             <div class="space-y-4">
                                 <div class="h-2 bg-white/10 rounded-full w-1/3"></div>
                                 <div class="h-10 bg-white rounded-2xl w-full flex items-center px-4 font-black">Santri: Ahmad Fauzi</div>
                                 <div class="h-24 bg-white/5 rounded-3xl border border-white/10 p-6 flex flex-col justify-center gap-4">
                                     <div class="h-2 bg-rose-500/50 rounded-full w-3/4"></div>
                                     <div class="h-2 bg-rose-500/20 rounded-full w-full"></div>
                                 </div>
                             </div>
                             <div class="grid grid-cols-2 gap-4">
                                 <div class="h-16 bg-emerald-500 rounded-[1.5rem] shadow-lg shadow-emerald-500/20 flex items-center justify-center text-white font-black text-xs uppercase tracking-tighter">Sembuh</div>
                                 <div class="h-16 bg-white/10 rounded-[1.5rem] border border-white/10 flex items-center justify-center text-white font-black text-xs uppercase tracking-tighter">Next</div>
                             </div>
                         </div>
                    </div>
                </div>
            </div>

            <!-- 2. SMART INVENTORY & AUDIT TRAIL -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
                <div class="bg-emerald-50 rounded-[4rem] p-12 relative overflow-hidden aspect-square flex items-center justify-center group">
                     <div class="absolute inset-0 bg-gradient-to-tr from-emerald-100/40 via-white/50 to-teal-100/40 group-hover:scale-110 transition-transform duration-1000"></div>
                     <!-- Inventory Logic Visual -->
                     <div class="relative z-10 w-full max-w-md space-y-4">
                         <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl border border-slate-100 space-y-6 transform group-hover:translate-y-[-10px] transition-transform">
                             <div class="flex justify-between items-center">
                                 <h6 class="font-black text-slate-900 text-lg tracking-tight">Paracetamol Tab</h6>
                                 <span class="px-3 py-1 bg-rose-50 text-rose-500 text-[10px] font-black rounded-full border border-rose-100 uppercase tracking-widest">Low Stock</span>
                             </div>
                             <div class="space-y-2">
                                 <div class="flex justify-between text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                     <span>Current Level</span>
                                     <span>12/100</span>
                                 </div>
                                 <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                                     <div class="h-full bg-rose-500 w-[12%] animate-pulse"></div>
                                 </div>
                             </div>
                         </div>
                         <div class="bg-slate-950 p-6 rounded-[2.5rem] shadow-2xl text-white space-y-4 translate-x-12 translate-y-4 group-hover:translate-x-6 group-hover:translate-y-0 transition-transform duration-700">
                             <div class="flex gap-4 items-center">
                                 <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center"><svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                                 <div class="flex-1">
                                     <div class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-0.5">Automated Expiry Verification</div>
                                     <div class="text-xs font-bold">Expires in 14 days</div>
                                 </div>
                             </div>
                         </div>
                     </div>
                </div>
                
                <div class="space-y-10">
                    <div class="space-y-4">
                        <div class="w-16 h-16 bg-emerald-600 text-white rounded-2xl flex items-center justify-center shadow-2xl shadow-emerald-500/20">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <h2 class="text-5xl font-black text-slate-900 tracking-tight leading-none">Smart Pharmacy <br> Multi-Audit.</h2>
                    </div>

                    <div class="prose prose-slate max-w-none text-slate-400 space-y-6 leading-relaxed">
                        <div class="space-y-2">
                             <h4 class="text-slate-900 font-black uppercase text-[11px] tracking-widest">Pengelolaan Inventaris Cerdas</h4>
                             <p>DEISA tidak hanya mencatat jumlah, tetapi mengelola siklus hidup obat. Setiap pemakaian saat santri sakit akan langsung memotong stok di database secara sinkron.</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="border-l-4 border-emerald-500 pl-6 space-y-1">
                                 <h6 class="text-slate-900 font-black text-sm">Real-time Reduction</h6>
                                 <p class="text-xs text-slate-500">Sinkronisasi instan antara modul input sakit dan modul farmasi.</p>
                            </div>
                            <div class="border-l-4 border-amber-500 pl-6 space-y-1">
                                 <h6 class="text-slate-900 font-black text-sm">Global Expiry Alerts</h6>
                                 <p class="text-xs text-slate-500">Audit harian otomatis yang mencari obat yang akan kadaluarsa.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. ACADEMIC SYNC & STUDENT LIFECYCLE -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
                <div class="space-y-10 order-2 lg:order-1">
                    <div class="space-y-4">
                        <div class="w-16 h-16 bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow-2xl shadow-blue-500/20">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.246.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.247 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <h2 class="text-5xl font-black text-slate-900 tracking-tight leading-none">Holistic <br> Student Sync.</h2>
                    </div>

                    <div class="prose prose-slate max-w-none text-slate-400 space-y-6 leading-relaxed">
                        <p>DEISA menyelaraskan data kesehatan dengan progres akademik santri. Ini memungkinkan petugas medis melihat pola sakit santri berdasarkan jenjang kelas dan perkembangan tahunan.</p>
                        <ul class="space-y-6">
                            <li class="flex gap-5">
                                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center shrink-0"><svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg></div>
                                <div>
                                    <h6 class="text-slate-900 font-bold text-base mb-1">Auto Promotion Systems</h6>
                                    <p class="text-sm text-slate-500">Saat tahun ajaran berganti, sistem kenaikan kelas otomatis memastikan riwayat medis lama tersimpan di database sebagai archive yang dapat discan kapan saja.</p>
                                </div>
                            </li>
                            <li class="flex gap-5">
                                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center shrink-0"><svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg></div>
                                <div>
                                    <h6 class="text-slate-900 font-bold text-base mb-1">Guardian Transparency</h6>
                                    <p class="text-sm text-slate-500">Data wali santri terhubung langsung ke profil medis santri, mempermudah koordinasi darurat (Emergency Call) hanya dalam satu klik dari dashboard petugas.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="order-1 lg:order-2 bg-slate-50 border border-slate-100 rounded-[4rem] p-12 relative overflow-hidden min-h-[400px] flex items-center justify-center group">
                    <div class="bg-white rounded-[2.5rem] shadow-2xl p-8 w-full max-w-sm border border-slate-50 space-y-6 transform transition-all duration-700 group-hover:scale-105">
                         <div class="flex items-center gap-5">
                             <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center font-black text-2xl">HA</div>
                             <div class="space-y-1">
                                 <h4 class="text-slate-900 font-black text-lg">Hafizh Arrahman</h4>
                                 <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase rounded-full">Grade 12 - Digital Class</span>
                             </div>
                         </div>
                         <div class="pt-6 border-t border-slate-50 space-y-4 text-xs font-bold text-slate-500">
                             <div class="flex justify-between"><span>Total Illness Cases</span> <span class="text-slate-900">4 Cases</span></div>
                             <div class="flex justify-between"><span>Recovery Rate</span> <span class="text-emerald-500">100%</span></div>
                             <div class="flex justify-between"><span>Guardian Phone</span> <span class="text-blue-500 underline">+62 822 ...</span></div>
                         </div>
                    </div>
                </div>
            </div>

            <!-- 4. UX PERSONALIZATION & THEME ENGINE -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
                 <div class="relative min-h-[400px] flex items-center justify-center group">
                      <!-- Big theme selector mockup -->
                      <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,var(--color-deisa-blue)_0%,transparent_70%)] opacity-5 blur-[80px]"></div>
                      <div class="w-full grid grid-cols-2 gap-6 relative z-10 p-10">
                           <div class="bg-[#0B63D6] aspect-square rounded-[3rem] shadow-2xl border-4 border-white transform -rotate-12 transition-all group-hover:rotate-0 duration-700"></div>
                           <div class="bg-[#4f46e5] aspect-square rounded-[3rem] shadow-2xl border-4 border-white transform rotate-12 mt-12 transition-all group-hover:rotate-0 duration-700"></div>
                           <div class="bg-[#059669] aspect-square rounded-[3rem] shadow-2xl border-4 border-white transform rotate-6 ml-12 transition-all group-hover:rotate-0 duration-700"></div>
                           <div class="bg-[#e11d48] aspect-square rounded-[3rem] shadow-2xl border-4 border-white transform -rotate-6 transition-all group-hover:rotate-0 duration-700"></div>
                      </div>
                 </div>
                 
                 <div class="space-y-10">
                    <div class="space-y-4">
                        <div class="w-16 h-16 bg-purple-600 text-white rounded-2xl flex items-center justify-center shadow-2xl shadow-purple-500/20">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.172-1.172a2 2 0 012.828 0l2.828 2.828a2 2 0 010 2.828l-1.172 1.172m-2.828-2.828l-8.486 8.485" /></svg>
                        </div>
                        <h2 class="text-5xl font-black text-slate-900 tracking-tight leading-none">The Engine of <br> Preference.</h2>
                    </div>

                    <div class="prose prose-slate max-w-none text-slate-500 space-y-6 leading-relaxed">
                        <div class="space-y-2">
                             <h4 class="text-slate-900 font-black uppercase text-[11px] tracking-widest">Detail Teknis Sistem Tema</h4>
                             <p>Bagaimana kami membuat aplikasi Anda unik? DEISA menggunakan sistem <strong>Dynamic Variable Injection</strong>. Pilihan warna Anda disimpan dalam database dan di-inject secara langsung ke dalam head layout setiap kali aplikasi dimuat.</p>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-slate-900 p-6 rounded-[2rem] border border-white/5 font-mono text-[10px] text-blue-400">
                                <span class="text-slate-500">// Theme Controller Logic Excerpt</span><br>
                                :root {<br>
                                &nbsp;&nbsp;--color-deisa-blue: @{{ $user->theme_pref }};<br>
                                }
                            </div>
                            <p class="text-xs font-bold italic">"Kami percaya produktivitas dimulai dari kenyamanan visual. Pilih warna Anda, unggah avatar Anda, dan buat DEISA menjadi rumah kerja Anda sendiri."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tech Stack Badge Section -->
        <section class="py-32 bg-white border-y border-slate-100">
            <div class="max-w-7xl mx-auto px-6 flex flex-col items-center gap-16">
                 <div class="text-center space-y-2">
                     <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.6em]">Enterprise Grade Technology</h3>
                     <p class="text-2xl font-black text-slate-900">Membangun Masa Depan Sehat dengan Stack Modern.</p>
                 </div>
                 <div class="flex flex-wrap justify-center items-center gap-20 grayscale opacity-40 hover:grayscale-0 hover:opacity-100 transition-all duration-1000">
                     <div class="flex flex-col items-center gap-3">
                         <div class="text-3xl font-black text-slate-900">Laravel</div>
                         <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Robust Backend</span>
                     </div>
                     <div class="flex flex-col items-center gap-3">
                         <div class="text-3xl font-black text-slate-900">Alpine.js</div>
                         <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Reactive UI</span>
                     </div>
                     <div class="flex flex-col items-center gap-3">
                         <div class="text-3xl font-black text-slate-900">Tailwind</div>
                         <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Atomized CSS</span>
                     </div>
                     <div class="flex flex-col items-center gap-3">
                         <div class="text-3xl font-black text-slate-900">Vite</div>
                         <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Fast Build</span>
                     </div>
                 </div>
            </div>
        </section>

        <!-- Presentation Pitch Footer -->
        <section class="py-32 bg-slate-950 text-center relative overflow-hidden">
             <div class="absolute inset-0 bg-blue-600/5 blur-[140px] rounded-full translate-y-1/2"></div>
             <div class="max-w-4xl mx-auto px-6 relative z-10 space-y-12">
                 <h2 class="text-5xl font-black text-white leading-tight tracking-tight">Siap Mempresentasikan <br> Solusi Terbaik?</h2>
                 <p class="text-slate-400 text-lg font-medium leading-relaxed">
                     Semua fitur di atas telah siap pakai. Fokus ke depan untuk ekosistem kesehatan pesantren yang lebih baik. Kami menyediakan data akurat, Anda menyediakan kepedulian yang tulus.
                 </p>
                 <div class="flex flex-col sm:flex-row justify-center gap-6">
                    <a href="{{ route('register') }}" class="px-12 py-5 bg-deisa-blue hover:bg-blue-600 text-white rounded-[2rem] font-black text-xl transition-all shadow-2xl shadow-blue-500/20">Daftar Akun Lab</a>
                    <a href="{{ route('landing') }}" class="px-12 py-5 bg-white/5 border border-white/10 hover:bg-white/10 text-white rounded-[2rem] font-black text-xl transition-all">Kembali Selancar</a>
                 </div>
             </div>
        </section>

        <!-- Simplified Footer -->
        <footer class="bg-black py-12 border-t border-white/5">
             <div class="max-w-7xl mx-auto px-6 text-center">
                 <div class="text-slate-600 text-[10px] font-black uppercase tracking-[0.4em]">&copy; {{ date('Y') }} Dar El-Ilmi Health Digital Ecosystem. Presentation Edition.</div>
             </div>
        </footer>
    </div>
@endsection
