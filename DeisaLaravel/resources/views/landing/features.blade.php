@extends('layouts.landing')

@section('content')
    <!-- Features Header -->
    <section class="pt-40 pb-20 bg-slate-900 text-white overflow-hidden relative">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-blue-500/10 to-transparent"></div>
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-deisa-blue/20 rounded-full blur-[100px]"></div>
        </div>

        <div class="container mx-auto px-4 md:px-6 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-outfit font-extrabold mb-8 capitalize">Fitur Canggih Deisa Health</h1>
            <p class="text-xl text-slate-400 max-w-2xl mx-auto capitalize">Eksplorasi bagaimana Deisa membantu pesantren
                mengelola kesehatan santri dengan lebih cerdas.</p>
        </div>
    </section>

    <!-- Detailed Features -->
    <section class="py-32 bg-white">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-24 items-center mb-32">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-deisa-blue mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-outfit font-bold text-slate-900 mb-6 capitalize">Analitik Kesehatan Real-time
                    </h2>
                    <p class="text-slate-600 mb-8 leading-relaxed capitalize">Lihat statistik kesehatan pesantren Anda
                        secara langsung melalui dashboard intuitif. Pantau tren penyakit mingguan, penggunaan obat, dan
                        tingkat kesembuhan santri secara instan.</p>
                    <ul class="space-y-4 text-sm text-slate-500 font-medium">
                        <li class="flex items-center space-x-3 capitalize">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Grafik Tren Penyakit</span>
                        </li>
                        <li class="flex items-center space-x-3 capitalize">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Monitoring Stok Obat Otomatis</span>
                        </li>
                        <li class="flex items-center space-x-3 capitalize">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Statistik Performa Kesehatan</span>
                        </li>
                    </ul>
                </div>
                <div class="relative">
                    <div
                        class="bg-slate-100 rounded-3xl aspect-video md:aspect-square flex items-center justify-center text-slate-300 font-black text-6xl rotate-3 shadow-xl border-8 border-white overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-500 to-cyan-500 opacity-20"></div>
                        <span class="select-none font-outfit">STATS</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-24 items-center">
                <div class="order-2 md:order-1 relative">
                    <div
                        class="bg-slate-100 rounded-3xl aspect-video md:aspect-square flex items-center justify-center text-slate-300 font-black text-6xl -rotate-3 shadow-xl border-8 border-white overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-tr from-teal-500 to-emerald-500 opacity-20"></div>
                        <span class="select-none font-outfit">SMART</span>
                    </div>
                </div>
                <div class="order-1 md:order-2">
                    <div class="w-12 h-12 rounded-2xl bg-teal-100 flex items-center justify-center text-teal-600 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-outfit font-bold text-slate-900 mb-6 capitalize">Keamanan Data Terjamin</h2>
                    <p class="text-slate-600 mb-8 leading-relaxed capitalize">Kami memahami pentingnya privasi data santri.
                        Deisa menggunakan enkripsi modern dan sistem manajemen akses tingkat lanjut untuk memastikan hanya
                        pihak berwenang yang dapat mengakses data sensitif.</p>
                    <ul class="space-y-4 text-sm text-slate-500 font-medium">
                        <li class="flex items-center space-x-3 capitalize">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Role-Based Access Control (RBAC)</span>
                        </li>
                        <li class="flex items-center space-x-3 capitalize">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Log Aktivitas Admin & Petugas</span>
                        </li>
                        <li class="flex items-center space-x-3 capitalize">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Enkripsi Data Sensitif</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-24 bg-slate-50">
        <div class="container mx-auto px-4 md:px-6">
            <div class="bg-deisa-blue rounded-[3rem] p-12 text-center text-white relative overflow-hidden shadow-2xl">
                <h2 class="text-3xl md:text-5xl font-outfit font-black mb-8 capitalize">Dapatkan Deisa Health Untuk
                    Pesantren Anda</h2>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                    <a href="{{ route('register') }}"
                        class="w-full sm:w-auto px-10 py-5 bg-white text-deisa-blue rounded-full font-bold shadow-xl hover:scale-105 transition-all">Hubungi
                        Kami</a>
                    <a href="{{ route('login') }}"
                        class="w-full sm:w-auto px-10 py-5 border border-white/30 rounded-full font-bold hover:bg-white/10 transition-all">Demo
                        Aplikasi</a>
                </div>
            </div>
        </div>
    </section>
@endsection