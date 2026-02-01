@extends('layouts.landing')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="relative min-h-[90vh] flex items-center pt-20 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-blue-50/50 to-transparent"></div>
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-deisa-blue/10 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-slate-50 to-transparent"></div>
        </div>

        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="w-full lg:w-1/2 text-center lg:text-left">
                    <div
                        class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-blue-50 text-deisa-blue text-xs font-black uppercase tracking-widest mb-8 animate-bounce">
                        <span class="flex h-2 w-2 rounded-full bg-deisa-blue animate-ping"></span>
                        <span>Versi 2.0 Kini Tersedia</span>
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-outfit font-extrabold text-slate-900 leading-[1.1] mb-6">
                        Masa Depan <span class="text-gradient">Kesehatan</span> Pesantren
                    </h1>
                    <p class="text-lg text-slate-600 mb-10 max-w-xl mx-auto lg:mx-0 leading-relaxed capitalize">
                        Kelola data kesehatan santri, riwayat pemeriksaan, dan stok obat dalam satu platform digital yang
                        modern, aman, dan mudah digunakan.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 reveal reveal-up"
                        style="transition-delay: 400ms">
                        <a href="{{ route('register') }}"
                            class="w-full sm:w-auto px-8 py-4 bg-deisa-blue text-white rounded-full font-bold shadow-xl shadow-blue-500/20 hover:scale-105 transition-all">
                            Daftar Sekarang
                        </a>
                        <a href="#features"
                            class="w-full sm:w-auto px-8 py-4 bg-white text-slate-700 border border-slate-200 rounded-full font-bold hover:bg-slate-50 transition-all flex items-center justify-center space-x-2">
                            <span>Lihat Fitur</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 relative reveal reveal-left">
                    <!-- Abstract Hero Image Placeholder -->
                    <div
                        class="relative w-full aspect-square md:aspect-video lg:aspect-square bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-slate-100 group">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-blue-500 to-teal-400 mix-blend-multiply opacity-5 group-hover:opacity-10 transition-opacity">
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center p-8">
                            <!-- Abstract Design with big 'D' -->
                            <div class="text-[12rem] font-outfit font-black text-slate-200 select-none">D</div>
                            <div class="absolute inset-x-0 bottom-0 p-8">
                                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-white shadow-xl">
                                    <div class="flex items-center space-x-4 mb-4">
                                        <div
                                            class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-xs text-slate-400 font-bold uppercase">Update Terkini</div>
                                            <div class="text-sm font-bold text-slate-800">89% Santri Sehat Hari Ini</div>
                                        </div>
                                    </div>
                                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-green-500 w-[89%]"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Floating Badges -->
                    <div
                        class="absolute -top-6 -left-6 bg-white p-4 rounded-2xl shadow-xl border border-slate-100 animate-pulse hidden md:block">
                        <div class="text-[10px] font-black uppercase text-slate-400 mb-1">Total Santri</div>
                        <div class="text-2xl font-black text-deisa-blue">{{ $stats['total_santri'] }}+</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Steps Section -->
    <section id="steps" class="py-32 bg-white">
        <div class="container mx-auto px-4 md:px-6">
            <div class="text-center max-w-2xl mx-auto mb-20 reveal reveal-up">
                <h2 class="text-sm font-black uppercase tracking-[0.3em] text-deisa-blue mb-4">Cara Kerja</h2>
                <h3 class="text-3xl md:text-5xl font-outfit font-extrabold text-slate-900 mb-6 capitalize">3 Langkah mudah
                    pemantauan kesehatan</h3>
            </div>

            <div class="relative">
                <!-- Connector Line (Desktop) -->
                <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-slate-100 -translate-y-1/2 z-0"></div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative z-10">
                    <!-- Step 1 -->
                    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm reveal reveal-up"
                        style="transition-delay: 100ms">
                        <div
                            class="w-14 h-14 rounded-2xl bg-deisa-blue text-white flex items-center justify-center text-xl font-black mb-6 shadow-lg shadow-blue-500/20">
                            1</div>
                        <h4 class="text-xl font-bold text-slate-900 mb-4 capitalize">Registrasi Santri</h4>
                        <p class="text-slate-500 text-sm leading-relaxed capitalize">Input data dasar santri dan riwayat
                            alergi dalam hitungan menit melalui form multi-step yang intuitif.</p>
                    </div>
                    <!-- Step 2 -->
                    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm reveal reveal-up"
                        style="transition-delay: 300ms">
                        <div
                            class="w-14 h-14 rounded-2xl bg-teal-500 text-white flex items-center justify-center text-xl font-black mb-6 shadow-lg shadow-teal-500/20">
                            2</div>
                        <h4 class="text-xl font-bold text-slate-900 mb-4 capitalize">Pemeriksaan Rutin</h4>
                        <p class="text-slate-500 text-sm leading-relaxed capitalize">Petugas mencatat keluhan kesehatan dan
                            tanda vital santri secara digital saat terjadi gangguan kesehatan.</p>
                    </div>
                    <!-- Step 3 -->
                    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm reveal reveal-up"
                        style="transition-delay: 500ms">
                        <div
                            class="w-14 h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-xl font-black mb-6 shadow-lg shadow-amber-500/20">
                            3</div>
                        <h4 class="text-xl font-bold text-slate-900 mb-4 capitalize">Pantau & Analisa</h4>
                        <p class="text-slate-500 text-sm leading-relaxed capitalize">Admin memantau tren kesehatan seluruh
                            santri melalui dashboard statistik yang informatif dan real-time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-32 bg-slate-50">
        <div class="container mx-auto px-4 md:px-6">
            <div class="text-center max-w-2xl mx-auto mb-20 reveal reveal-up">
                <h2 class="text-sm font-black uppercase tracking-[0.3em] text-deisa-blue mb-4">Fitur Unggulan</h2>
                <h3 class="text-3xl md:text-5xl font-outfit font-extrabold text-slate-900 mb-6 capitalize">Kelola semua
                    dalam satu sentuhan</h3>
                <p class="text-slate-500 leading-relaxed capitalize">Optimalkan pelayanan kesehatan santri dengan fitur
                    digital terlengkap.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 reveal reveal-up"
                    style="transition-delay: 100ms">
                    <div class="w-16 h-16 rounded-3xl bg-blue-50 flex items-center justify-center text-deisa-blue mb-8">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-4 capitalize">Manajemen Santri</h4>
                    <p class="text-slate-500 text-sm leading-relaxed capitalize">Database santri terpusat dengan riwayat
                        kesehatan yang tersimpan permanen dan mudah diakses.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 reveal reveal-up"
                    style="transition-delay: 300ms">
                    <div class="w-16 h-16 rounded-3xl bg-teal-50 flex items-center justify-center text-teal-600 mb-8">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-4 capitalize">Pemeriksaan Digital</h4>
                    <p class="text-slate-500 text-sm leading-relaxed capitalize">Catat setiap keluhan dan pemeriksaan
                        kesehatan secara instan dengan indikator normalitas yang cerdas.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 reveal reveal-up"
                    style="transition-delay: 500ms">
                    <div class="w-16 h-16 rounded-3xl bg-rose-50 flex items-center justify-center text-rose-600 mb-8">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-4 capitalize">Inventaris Obat</h4>
                    <p class="text-slate-500 text-sm leading-relaxed capitalize">Pantau stok obat secara realtime, kelola
                        kategori, dan dapatkan peringatan stok menipis secara otomatis.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Carousel Tips Section -->
    <section class="py-32 bg-white overflow-hidden">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex flex-col lg:flex-row items-center gap-20">
                <div class="w-full lg:w-1/3 reveal reveal-right">
                    <h2 class="text-sm font-black uppercase tracking-[0.3em] text-deisa-blue mb-4">Tips Kesehatan</h2>
                    <h3 class="text-3xl md:text-5xl font-outfit font-extrabold text-slate-900 mb-6 capitalize">Wawasan Untuk
                        Santri Lebih Sehat</h3>
                    <p class="text-slate-500 leading-relaxed mb-10 capitalize">Kumpulan tips kesehatan harian yang dirancang
                        khusus untuk lingkungan pesantren.</p>
                    <div class="flex space-x-4">
                        <button @click="$refs.carousel.scrollBy({left: -400, behavior: 'smooth'})"
                            class="w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center hover:bg-slate-50 transition-colors">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button @click="$refs.carousel.scrollBy({left: 400, behavior: 'smooth'})"
                            class="w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center hover:bg-slate-50 transition-colors">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="w-full lg:w-2/3">
                    <div x-ref="carousel" class="flex space-x-6 overflow-x-auto pb-8 scrollbar-hide snap-x snap-mandatory"
                        style="scrollbar-width: none; -ms-overflow-style: none;">
                        <!-- Tip 1 -->
                        <div class="min-w-[300px] md:min-w-[400px] bg-blue-600 rounded-[2.5rem] p-10 text-white snap-center reveal reveal-left"
                            style="transition-delay: 100ms">
                            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-10">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h4 class="text-2xl font-bold mb-4 capitalize">Pentingnya Hidrasi</h4>
                            <p class="opacity-80 leading-relaxed capitalize">Minum air putih minimal 8 gelas sehari membantu
                                menjaga konsentrasi saat menghafal Al-Qur'an.</p>
                        </div>
                        <!-- Tip 2 -->
                        <div class="min-w-[300px] md:min-w-[400px] bg-teal-500 rounded-[2.5rem] p-10 text-white snap-center reveal reveal-left"
                            style="transition-delay: 300ms">
                            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-10">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </div>
                            <h4 class="text-2xl font-bold mb-4 capitalize">Istirahat Cukup</h4>
                            <p class="opacity-80 leading-relaxed capitalize">Tidur 6-8 jam sangat penting untuk pemulihan
                                fisik dan mental santri setelah kegiatan seharian.</p>
                        </div>
                        <!-- Tip 3 -->
                        <div class="min-w-[300px] md:min-w-[400px] bg-amber-500 rounded-[2.5rem] p-10 text-white snap-center reveal reveal-left"
                            style="transition-delay: 500ms">
                            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-10">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h4 class="text-2xl font-bold mb-4 capitalize">Kebersihan Diri</h4>
                            <p class="opacity-80 leading-relaxed capitalize">Menjaga kebersihan asrama dan diri sendiri
                                adalah bagian dari iman dan kunci kesehatan di pesantren.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="py-32 bg-white relative overflow-hidden">
        <!-- Abstract Design -->
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>

        <div class="container mx-auto px-4 md:px-6">
            <div class="bg-slate-900 rounded-[3rem] p-12 md:p-20 relative overflow-hidden shadow-3xl">
                <!-- Background glow -->
                <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-deisa-blue/20 rounded-full blur-[100px]"></div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-12 text-center">
                    <div>
                        <div class="text-4xl md:text-6xl font-outfit font-black text-white mb-4">
                            {{ $stats['total_santri'] }}</div>
                        <div class="text-xs md:text-sm font-bold uppercase tracking-widest text-slate-400">Total Santri
                        </div>
                    </div>
                    <div>
                        <div class="text-4xl md:text-6xl font-outfit font-black text-white mb-4">{{ $stats['total_obat'] }}
                        </div>
                        <div class="text-xs md:text-sm font-bold uppercase tracking-widest text-slate-400">Jenis Obat</div>
                    </div>
                    <div>
                        <div class="text-4xl md:text-6xl font-outfit font-black text-white mb-4">
                            {{ $stats['total_checks'] }}</div>
                        <div class="text-xs md:text-sm font-bold uppercase tracking-widest text-slate-400">Riwayat Check-up
                        </div>
                    </div>
                    <div>
                        <div class="text-4xl md:text-6xl font-outfit font-black text-white mb-4">
                            {{ $stats['active_cases'] }}</div>
                        <div class="text-xs md:text-sm font-bold uppercase tracking-widest text-slate-400">Kasus Aktif</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-32 bg-white">
        <div class="container mx-auto px-4 md:px-6 text-center">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-4xl md:text-6xl font-outfit font-black text-slate-900 mb-8 capitalize">Siap mendigitalkan
                    kesehatan pesantren anda?</h2>
                <p class="text-xl text-slate-500 mb-12 capitalize">Gabung sekarang dan rasakan kemudahan pengelolaan
                    kesehatan santri.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}"
                        class="w-full sm:w-auto px-10 py-5 bg-deisa-blue text-white rounded-full font-bold shadow-2xl shadow-blue-500/30 hover:scale-105 transition-all">
                        Daftar Akun Gratis
                    </a>
                    <a href="mailto:contact@deisa.id"
                        class="w-full sm:w-auto px-10 py-5 bg-slate-50 text-slate-700 rounded-full font-bold hover:bg-slate-100 transition-all">
                        Hubungi Sales
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection