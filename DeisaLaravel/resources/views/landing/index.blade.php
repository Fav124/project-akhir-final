@extends('layouts.landing')

@section('content')
<section id="home" class="pt-64 md:pt-72 pb-24 bg-white relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 -left-20 w-[40rem] h-[40rem] rounded-full bg-blue-50/50 blur-[120px]"></div>
        <div class="absolute top-1/4 -right-20 w-[30rem] h-[30rem] rounded-full bg-cyan-50/40 blur-[100px]"></div>
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>
    </div>

    <div class="container mx-auto px-4 md:px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            <div class="lg:col-span-7 space-y-8 reveal reveal-up">
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-blue-50/80 border border-blue-100/50 backdrop-blur-sm shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-deisa-blue opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-deisa-blue"></span>
                    </span>
                    <span class="text-deisa-blue text-[11px] font-bold uppercase tracking-[0.2em]">DEISA Health Ecosystem</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-display font-extrabold leading-[1.1] text-slate-900 tracking-tight">
                    Sistem Kesehatan <span class="bg-clip-text text-transparent bg-gradient-to-r from-deisa-blue to-blue-600">Terpadu</span> Untuk Kemajuan Pesantren.
                </h1>
                
                <p class="text-slate-600 text-xl leading-relaxed max-w-2xl font-medium">
                    DEISA merevolusi pengelolaan UKS dengan dashboard digital yang cerdas, pemantauan status santri real-time, dan manajemen obat yang akurat.
                </p>
                
                <div class="flex flex-wrap items-center gap-5 pt-4">
                    <a href="{{ route('register') }}" class="group relative px-8 py-4 bg-slate-900 text-white rounded-full font-bold overflow-hidden transition-all shadow-xl shadow-slate-900/20 hover:-translate-y-1">
                        <span class="relative z-10 flex items-center gap-2">
                            Mulai Sekarang
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </span>
                    </a>
                    <a href="#features" class="px-8 py-4 bg-white text-slate-700 rounded-full font-bold border border-slate-200 hover:bg-slate-50 transition-all">Pelajari Fitur</a>
                </div>

                <div class="flex items-center gap-8 pt-8 border-t border-slate-100">
                    <div>
                        <div class="text-3xl font-display font-black text-slate-900">{{ number_format($stats['total_santri']) }}</div>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Santri Terdata</div>
                    </div>
                    <div class="w-px h-10 bg-slate-100"></div>
                    <div>
                        <div class="text-3xl font-display font-black text-slate-900">{{ number_format($stats['total_checks']) }}</div>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Riwayat</div>
                    </div>
                    <div class="w-px h-10 bg-slate-100"></div>
                    <div>
                        <div class="text-3xl font-display font-black text-slate-900">{{ $stats['active_cases'] }}</div>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Kasus Aktif</div>
                    </div>
                </div>
            </div>
            
            <div class="lg:col-span-5 relative reveal reveal-left">
                <div class="absolute -inset-4 bg-gradient-to-tr from-blue-500/10 to-cyan-500/10 blur-2xl rounded-[3rem]"></div>
                <div class="relative bg-white p-2 rounded-[2.5rem] shadow-2xl border border-slate-100 transform lg:rotate-3 hover:rotate-0 transition-transform duration-700">
                    <img src="{{ asset('images/landing-health-dashboard.svg') }}" alt="Dashboard kesehatan santri DEISA"
                        class="w-full rounded-[2rem] shadow-inner">
                </div>
            </div>
        </div>
    </div>
</section>

<section id="features" class="py-24 bg-white">
    <div class="container mx-auto px-4 md:px-6">
        <div class="max-w-3xl mb-16 reveal reveal-up">
            <h2 class="text-sm font-black uppercase tracking-[0.3em] text-deisa-blue mb-4">Core Capabilities</h2>
            <h3 class="text-4xl md:text-5xl font-display font-bold text-slate-900 leading-tight">Monitoring kesehatan berbasis alur kerja pesantren modern.</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <article class="group rounded-[2rem] border border-slate-100 p-8 shadow-sm hover:shadow-xl hover:border-blue-100 transition-all duration-300 reveal reveal-up">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-deisa-blue flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586"/></svg>
                </div>
                <h4 class="text-2xl font-bold text-slate-900 mb-3">Riwayat Terpadu</h4>
                <p class="text-slate-600 leading-relaxed">Semua keluhan, diagnosis, tindakan, dan obat tersimpan dalam satu timeline yang rapi.</p>
            </article>

            <article class="group rounded-[2rem] border border-slate-100 p-8 shadow-sm hover:shadow-xl hover:border-emerald-100 transition-all duration-300 reveal reveal-up" style="transition-delay: 150ms">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h4 class="text-2xl font-bold text-slate-900 mb-3">Pantau Kepulangan</h4>
                <p class="text-slate-600 leading-relaxed">Lacak kapan santri dipulangkan, alasan, durasi, hingga verifikasi saat santri kembali ke UKS.</p>
            </article>

            <article class="group rounded-[2rem] border border-slate-100 p-8 shadow-sm hover:shadow-xl hover:border-amber-100 transition-all duration-300 reveal reveal-up" style="transition-delay: 300ms">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2"/></svg>
                </div>
                <h4 class="text-2xl font-bold text-slate-900 mb-3">Kontrol Stok Obat</h4>
                <p class="text-slate-600 leading-relaxed">Stok minimum, riwayat pemakaian, dan log restock otomatis untuk kelola ketersediaan obat.</p>
            </article>
        </div>
    </div>
</section>

<section id="stats" class="py-24 bg-slate-50 relative overflow-hidden">
    <!-- Decorative dot pattern -->
    <div class="absolute inset-0 z-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(#0b63d6 1px, transparent 1px); background-size: 24px 24px;"></div>
    
    <div class="container mx-auto px-4 md:px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="order-2 lg:order-1 reveal reveal-right">
                <div class="p-3 bg-white rounded-[2.5rem] shadow-xl border border-slate-200/60 transition-transform hover:-rotate-1 duration-500">
                    <img src="{{ asset('images/landing-health-team.svg') }}" alt="Tim kesehatan pesantren menggunakan DEISA"
                        class="w-full rounded-[2rem]">
                </div>
            </div>
            <div class="order-1 lg:order-2 space-y-8 reveal reveal-up">
                <h3 class="text-4xl md:text-5xl font-display font-bold text-slate-900 leading-tight tracking-tight">Identitas Digital Untuk Kesehatan Boarding School</h3>
                <p class="text-slate-600 text-lg leading-relaxed">DEISA dirancang khusus untuk ekosistem pendidikan Islam modern: menggabungkan nilai humanis dengan akurasi data masa kini demi keselamatan santri.</p>
                
                <div class="grid grid-cols-2 gap-5">
                    <div class="bg-white rounded-[1.5rem] p-6 border border-slate-100 shadow-sm transition-all hover:shadow-md">
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Total Santri</div>
                        <div class="text-4xl font-display font-black text-slate-900">{{ number_format($stats['total_santri']) }}</div>
                    </div>
                    <div class="bg-white rounded-[1.5rem] p-6 border border-slate-100 shadow-sm transition-all hover:shadow-md">
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Kasus Aktif</div>
                        <div class="text-4xl font-display font-black text-amber-600">{{ number_format($stats['active_cases']) }}</div>
                    </div>
                    <div class="bg-white rounded-[1.5rem] p-6 border border-slate-100 shadow-sm transition-all hover:shadow-md">
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Riwayat Periksa</div>
                        <div class="text-4xl font-display font-black text-deisa-blue">{{ number_format($stats['total_checks']) }}</div>
                    </div>
                    <div class="bg-white rounded-[1.5rem] p-6 border border-slate-100 shadow-sm transition-all hover:shadow-md">
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Inventaris Obat</div>
                        <div class="text-4xl font-display font-black text-emerald-600">{{ number_format($stats['total_obat']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-white">
    <div class="container mx-auto px-4 md:px-6">
        <div class="relative rounded-[3rem] bg-slate-900 p-12 md:p-20 text-center overflow-hidden reveal reveal-up">
            <!-- Background glow -->
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-deisa-blue/20 rounded-full blur-[100px]"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-500/10 rounded-full blur-[100px]"></div>
            
            <div class="relative z-10 max-w-3xl mx-auto">
                <h3 class="text-4xl md:text-6xl font-display font-black text-white mb-6 leading-tight">Elevasi standar kesehatan pesantren Anda.</h3>
                <p class="text-slate-300 text-lg mb-10 leading-relaxed font-medium">Beralih dari pencatatan konvensional ke platform digital yang komprehensif. Sederhana bagi petugas, akurat bagi manajemen.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-5">
                    <a href="{{ route('register') }}" class="px-10 py-4 rounded-full bg-white text-slate-900 font-bold hover:scale-105 hover:bg-slate-50 transition-all shadow-xl shadow-white/10">Gabung Sekarang</a>
                    <a href="{{ route('landing.features') }}" class="px-10 py-4 rounded-full border border-slate-700 text-white font-bold hover:bg-slate-800 transition-all">Pelajari Fitur Canggih</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
