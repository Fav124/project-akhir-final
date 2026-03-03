@extends('layouts.landing')

@section('content')
    <!-- Features Header -->
    <section class="pt-48 pb-24 bg-slate-900 text-white overflow-hidden relative">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-blue-600/20 via-slate-900 to-slate-900"></div>
            <div class="absolute -top-40 -right-40 w-[40rem] h-[40rem] bg-deisa-blue/20 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-0 left-0 w-full h-px bg-slate-800"></div>
        </div>

        <div class="container mx-auto px-4 md:px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 backdrop-blur-sm text-blue-300 text-[10px] font-bold uppercase tracking-[0.2em] mb-8 reveal reveal-up">
                Technology for Humanity
            </div>
            <h1 class="text-5xl md:text-7xl font-display font-black mb-8 leading-tight reveal reveal-up">Fitur Canggih DEISA</h1>
            <p class="text-xl text-slate-400 max-w-2xl mx-auto leading-relaxed reveal reveal-up" style="transition-delay: 150ms">
                Eksplorasi bagaimana DEISA memberdayakan pesantren dengan pengelolaan kesehatan berbasis data yang akurat dan terpercaya.
            </p>
        </div>
    </section>

    <!-- Detailed Features -->
    <section class="py-32 bg-white relative">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-24 items-center mb-32">
                <div class="reveal reveal-right">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-deisa-blue mb-8">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h2 class="text-4xl font-display font-bold text-slate-900 mb-6">Analitik Kesehatan Terpusat</h2>
                    <p class="text-slate-600 text-lg mb-8 leading-relaxed">Pantau kesehatan pesantren Anda secara real-time melalui dashboard intuitif. Dapatkan wawasan mendalam mengenai tren penyakit, penggunaan obat, dan efektivitas tim medis.</p>
                    
                    <ul class="space-y-5">
                        <li class="flex items-start gap-4">
                            <div class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-slate-900">Visualisasi Tren Mingguan</h5>
                                <p class="text-sm text-slate-500">Deteksi dini persebaran penyakit dengan grafik yang mudah dipahami.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-slate-900">Notifikasi Stok Menipis</h5>
                                <p class="text-sm text-slate-500">Peringatan otomatis saat persediaan obat krusial mencapai batas minimum.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="relative reveal reveal-left">
                    <div class="absolute -inset-10 bg-blue-50/50 blur-3xl rounded-full"></div>
                    <div class="bg-slate-50 rounded-[3rem] aspect-square flex items-center justify-center border border-slate-200 shadow-2xl relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-600/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <span class="text-slate-300 font-display font-black text-8xl rotate-12 opacity-20 select-none">STATS</span>
                        <div class="absolute inset-x-0 bottom-0 p-10 bg-gradient-to-t from-white to-transparent pt-20">
                            <div class="h-2 w-32 bg-slate-200 rounded-full mb-3"></div>
                            <div class="h-2 w-48 bg-slate-100 rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-24 items-center">
                <div class="order-2 md:order-1 relative reveal reveal-right">
                    <div class="absolute -inset-10 bg-emerald-50/50 blur-3xl rounded-full"></div>
                    <div class="bg-slate-50 rounded-[3rem] aspect-square flex items-center justify-center border border-slate-200 shadow-2xl relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-tr from-emerald-600/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <span class="text-slate-300 font-display font-black text-8xl -rotate-12 opacity-20 select-none">SAFE</span>
                        <div class="absolute inset-x-0 bottom-0 p-10 bg-gradient-to-t from-white to-transparent pt-20 text-right flex flex-col items-end">
                            <div class="h-2 w-48 bg-slate-200 rounded-full mb-3"></div>
                            <div class="h-2 w-32 bg-slate-100 rounded-full"></div>
                        </div>
                    </div>
                </div>
                <div class="order-1 md:order-2 reveal reveal-left">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-8">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h2 class="text-4xl font-display font-bold text-slate-900 mb-6">Keamanan Tingkat Lanjut</h2>
                    <p class="text-slate-600 text-lg mb-8 leading-relaxed">Kami menjaga kerahasiaan data medis santri dengan standar tinggi. Menggunakan manajemen akses yang ketat agar informasi hanya sampai kepada pihak berwenang.</p>
                    
                    <div class="space-y-6">
                        <article class="p-6 bg-slate-50 rounded-2xl border border-slate-100 transition-colors hover:border-emerald-200">
                            <h6 class="font-bold text-slate-900 mb-1">Role-Based Access Control</h6>
                            <p class="text-sm text-slate-500 leading-relaxed">Batasan akses yang jelas antara admin pusat, petugas unit kesehatan, dan pengurus asrama.</p>
                        </article>
                        <article class="p-6 bg-slate-50 rounded-2xl border border-slate-100 transition-colors hover:border-emerald-200">
                            <h6 class="font-bold text-slate-900 mb-1">Enkripsi Data Sensitif</h6>
                            <p class="text-sm text-slate-500 leading-relaxed">Seluruh data personal dan riwayat medis dienkripsi dengan standar industri terbaru.</p>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final Call to Action -->
    <section class="py-32 bg-slate-50 relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 relative z-10 text-center">
            <h2 class="text-4xl md:text-6xl font-display font-black text-slate-900 mb-8 leading-tight">Siap mendigitalisasi<br>kesehatan pesantren?</h2>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="{{ route('register') }}"
                    class="w-full sm:w-auto px-12 py-5 bg-slate-900 text-white rounded-full font-bold shadow-2xl hover:-translate-y-1 transition-all">Daftar Sekarang</a>
                <a href="{{ route('login') }}"
                    class="w-full sm:w-auto px-12 py-5 bg-white border border-slate-200 text-slate-700 rounded-full font-bold hover:bg-slate-50 transition-all">Hubungi Tim Kami</a>
            </div>
        </div>
    </section>
@endsection