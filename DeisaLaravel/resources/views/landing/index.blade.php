@extends('layouts.landing')

@section('content')
<section id="home" class="pt-28 pb-20 bg-gradient-to-b from-blue-900 to-blue-800 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -top-20 right-0 w-[28rem] h-[28rem] rounded-full bg-cyan-300 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-[24rem] h-[24rem] rounded-full bg-blue-400 blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 md:px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div class="space-y-6 reveal reveal-up">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/15 border border-white/20 text-xs font-bold uppercase tracking-widest">
                    DEISA HealthOS
                </div>
                <h1 class="text-4xl md:text-6xl font-outfit font-extrabold leading-tight">
                    Sistem Kesehatan Santri yang Terstruktur, Cepat, dan Terpantau.
                </h1>
                <p class="text-blue-100 text-lg max-w-xl">
                    Pantau kasus santri sakit, status pulang-kembali, stok obat, dan laporan kesehatan dari satu dashboard terpadu.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('register') }}" class="px-7 py-3.5 rounded-full bg-white text-blue-800 font-bold text-center hover:bg-blue-50 transition">Mulai Gratis</a>
                    <a href="{{ route('login') }}" class="px-7 py-3.5 rounded-full border border-white/40 font-bold text-center hover:bg-white/10 transition">Masuk Admin</a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4">
                    <div>
                        <div class="text-3xl font-black">{{ $stats['total_santri'] }}</div>
                        <div class="text-xs uppercase tracking-widest text-blue-200">Santri</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black">{{ $stats['active_cases'] }}</div>
                        <div class="text-xs uppercase tracking-widest text-blue-200">Kasus Aktif</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black">{{ $stats['total_checks'] }}</div>
                        <div class="text-xs uppercase tracking-widest text-blue-200">Riwayat</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black">{{ $stats['total_obat'] }}</div>
                        <div class="text-xs uppercase tracking-widest text-blue-200">Stok Obat</div>
                    </div>
                </div>
            </div>
            <div class="reveal reveal-left">
                <img src="{{ asset('images/landing-health-dashboard.svg') }}" alt="Dashboard kesehatan santri DEISA"
                    class="w-full rounded-3xl shadow-2xl border border-white/20">
            </div>
        </div>
    </div>
</section>

<section id="features" class="py-20 bg-white">
    <div class="container mx-auto px-4 md:px-6">
        <div class="max-w-3xl mb-12 reveal reveal-up">
            <h2 class="text-sm font-black uppercase tracking-[0.25em] text-deisa-blue mb-4">Fitur Inti</h2>
            <h3 class="text-3xl md:text-5xl font-outfit font-extrabold text-slate-900">Monitoring kesehatan berbasis alur kerja pesantren</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <article class="rounded-3xl border border-slate-100 p-7 shadow-sm hover:shadow-lg transition reveal reveal-up">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-deisa-blue flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586"/></svg>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-2">Riwayat Sakit Terpadu</h4>
                <p class="text-slate-600 text-sm">Semua keluhan, diagnosis, tindakan, obat, dan status perawatan tersimpan dalam satu timeline.</p>
            </article>

            <article class="rounded-3xl border border-slate-100 p-7 shadow-sm hover:shadow-lg transition reveal reveal-up" style="transition-delay: 120ms">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-2">Pantau Santri Pulang</h4>
                <p class="text-slate-600 text-sm">Lacak kapan santri dipulangkan, kapan kembali ke UKS, berapa lama, dan apa alasan kepulangannya.</p>
            </article>

            <article class="rounded-3xl border border-slate-100 p-7 shadow-sm hover:shadow-lg transition reveal reveal-up" style="transition-delay: 240ms">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2"/></svg>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-2">Kontrol Stok Obat</h4>
                <p class="text-slate-600 text-sm">Stok minimum, riwayat pemakaian, dan log restock otomatis untuk mencegah kekosongan obat.</p>
            </article>
        </div>
    </div>
</section>

<section id="stats" class="py-20 bg-slate-50">
    <div class="container mx-auto px-4 md:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div class="reveal reveal-right">
                <img src="{{ asset('images/landing-health-team.svg') }}" alt="Tim kesehatan pesantren menggunakan DEISA"
                    class="w-full rounded-3xl border border-slate-200 shadow-lg">
            </div>
            <div class="space-y-5 reveal reveal-up">
                <h3 class="text-3xl md:text-4xl font-outfit font-extrabold text-slate-900">Branding Kesehatan Pesantren yang Kuat</h3>
                <p class="text-slate-600">DEISA dirancang untuk identitas lembaga pendidikan Islam modern: profesional, humanis, dan data-driven.</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white rounded-2xl p-4 border border-slate-100">
                        <div class="text-xs uppercase tracking-widest text-slate-400 font-bold">Total Santri</div>
                        <div class="text-3xl font-black text-slate-900">{{ $stats['total_santri'] }}</div>
                    </div>
                    <div class="bg-white rounded-2xl p-4 border border-slate-100">
                        <div class="text-xs uppercase tracking-widest text-slate-400 font-bold">Kasus Aktif</div>
                        <div class="text-3xl font-black text-amber-600">{{ $stats['active_cases'] }}</div>
                    </div>
                    <div class="bg-white rounded-2xl p-4 border border-slate-100">
                        <div class="text-xs uppercase tracking-widest text-slate-400 font-bold">Riwayat Periksa</div>
                        <div class="text-3xl font-black text-blue-700">{{ $stats['total_checks'] }}</div>
                    </div>
                    <div class="bg-white rounded-2xl p-4 border border-slate-100">
                        <div class="text-xs uppercase tracking-widest text-slate-400 font-bold">Jenis Obat</div>
                        <div class="text-3xl font-black text-emerald-600">{{ $stats['total_obat'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-4 md:px-6">
        <div class="rounded-[2rem] bg-slate-900 text-white p-10 md:p-14 text-center reveal reveal-up">
            <h3 class="text-3xl md:text-5xl font-outfit font-extrabold mb-4">Tingkatkan layanan kesehatan santri sekarang</h3>
            <p class="text-slate-300 max-w-2xl mx-auto mb-8">Mulai transformasi dari pencatatan manual ke sistem kesehatan digital yang siap dipakai harian.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-3.5 rounded-full bg-deisa-blue text-white font-bold hover:bg-blue-600 transition">Daftar Akun</a>
                <a href="{{ route('landing.features') }}" class="px-8 py-3.5 rounded-full border border-slate-600 text-slate-200 font-bold hover:bg-slate-800 transition">Lihat Detail Fitur</a>
            </div>
        </div>
    </div>
</section>
@endsection
