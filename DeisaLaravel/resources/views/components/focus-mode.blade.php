<div x-data="focusMode()" x-show="open" x-cloak @open-focus-mode.window="start()"
    class="fixed inset-0 z-[9999] bg-white flex flex-col items-center justify-center p-6 sm:p-12 overflow-hidden">

    <!-- Background Glows -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-100 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-rose-100 rounded-full blur-[120px]"></div>
    </div>

    <!-- Header / Progress -->
    <div class="relative z-10 w-full max-w-4xl flex justify-between items-center mb-12">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-deisa-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-slate-900 text-xl font-black uppercase tracking-widest">Daily Health Summary</h2>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-tighter">Reviewing <span
                        x-text="items.length"></span> actionable items</p>
            </div>
        </div>
        <button @click="close()" class="text-slate-500 hover:text-white transition-colors">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Main Content Area (Immersive Cards) -->
    <div class="relative z-10 w-full max-w-2xl flex-1 flex flex-col justify-center">
        <template x-if="loading">
            <div class="text-center">
                <div
                    class="inline-block animate-spin w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full mb-4">
                </div>
                <p class="text-slate-400 font-bold uppercase tracking-widest animate-pulse">Gathering Reports...</p>
            </div>
        </template>

        <template x-if="!loading && items.length === 0">
            <div class="text-center space-y-6">
                <div
                    class="w-32 h-32 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/10">
                    <span class="text-6xl">✨</span>
                </div>
                <h3 class="text-3xl font-black text-white">All Clear!</h3>
                <p class="text-slate-400 text-lg">No critical alerts or pending actions for today.</p>
                <button @click="close()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-xl shadow-blue-600/20">Great,
                    Back to Dashboard</button>
            </div>
        </template>

        <template x-if="!loading && items.length > 0 && currentIndex < items.length">
            <div class="space-y-8">

                <!-- Card -->
                <div
                    class="bg-white border border-slate-100 rounded-[3rem] p-10 md:p-16 shadow-2xl relative overflow-hidden group animate-scale-up-entrance">
                    <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="text-slate-200 font-black text-9xl italic select-none"
                            x-text="currentIndex + 1"></span>
                    </div>

                    <!-- Card Header -->
                    <div class="relative z-10 mb-10 animate-fade-in-up delay-100">
                        <template x-if="currentItem().type === 'sick'">
                            <span
                                class="bg-rose-500/20 text-rose-500 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest border border-rose-500/30">Sick
                                Student Monitoring</span>
                        </template>
                        <template x-if="currentItem().type === 'stock'">
                            <span
                                class="bg-amber-500/20 text-amber-500 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest border border-amber-500/30">Low
                                Stock Alert</span>
                        </template>
                        <template x-if="currentItem().type === 'expiry'">
                            <span
                                class="bg-purple-500/20 text-purple-500 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest border border-purple-500/30">Expiry
                                Warning</span>
                        </template>
                    </div>

                    <!-- Card Body -->
                    <div class="relative z-10 space-y-6">
                        <h3 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight animate-fade-in-up delay-200"
                            x-text="currentItem().name"></h3>

                        <template x-if="currentItem().type === 'sick'">
                            <div class="space-y-4 animate-fade-in-up delay-300">
                                <p class="text-slate-500 text-xl leading-relaxed">Santri dari kelas <span
                                        class="text-slate-900 font-bold" x-text="currentItem().kelas"></span> sedang
                                    sakit <span class="text-slate-900 font-bold"
                                        x-text="currentItem().diagnosis"></span> selama <span
                                        class="text-slate-900 font-bold" x-text="currentItem().days"></span> hari.</p>
                                <p class="text-slate-400 font-medium italic">Bagaimana kondisi santri saat ini?</p>
                            </div>
                        </template>

                        <template x-if="currentItem().type === 'stock'">
                            <div class="space-y-4 animate-fade-in-up delay-300">
                                <p class="text-slate-500 text-xl leading-relaxed">Stok tersisa hanya <span
                                        class="text-amber-600 font-bold" x-text="currentItem().stok"></span>. Kurang
                                    dari
                                    batas minimum (<span x-text="currentItem().min"></span>).</p>
                                <p class="text-slate-400 font-medium italic">Segera lakukan pengadaan ulang untuk stok
                                    ini.</p>
                            </div>
                        </template>

                        <template x-if="currentItem().type === 'expiry'">
                            <div class="space-y-4 animate-fade-in-up delay-300">
                                <p class="text-slate-500 text-xl leading-relaxed">Obat ini akan kadaluarsa pada <span
                                        class="text-rose-600 font-bold" x-text="currentItem().expiry_date"></span>.</p>
                                <p class="text-slate-400 font-medium italic"
                                    x-text="currentItem().is_expired ? 'Obat SUDAH kadaluarsa dan tidak boleh digunakan.' : 'Segera habiskan atau buang stok yang mendekati kadaluarsa.'">
                                </p>
                            </div>
                        </template>
                    </div>

                    <!-- Actions -->
                    <div class="relative z-10 flex flex-wrap gap-4 mt-12 animate-fade-in-up delay-500">
                        <template x-if="currentItem().type === 'sick'">
                            <div class="flex gap-4 w-full">
                                <button @click="markSembuh(currentItem().id)"
                                    class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-black py-5 rounded-[1.8rem] shadow-2xl shadow-emerald-600/30 transition-all flex items-center justify-center gap-3">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Sudah Sembuh
                                </button>
                                <button @click="next()"
                                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-10 rounded-[1.8rem] transition-all border border-slate-200">Masih
                                    Sakit</button>
                            </div>
                        </template>

                        <template x-if="currentItem().type === 'stock' || currentItem().type === 'expiry'">
                            <div class="flex gap-4 w-full">
                                <button @click="addReminder(currentItem().name, currentItem().type)"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-[1.8rem] shadow-2xl shadow-blue-600/30 transition-all flex items-center justify-center gap-3">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    Ingatkan Saya
                                </button>
                                <button @click="next()"
                                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-10 rounded-[1.8rem] transition-all border border-slate-200">Lewati</button>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Footer / Nav -->
                <div class="flex justify-between items-center px-4 animate-fade-in-up delay-500">
                    <button @click="prev()" :disabled="currentIndex === 0"
                        class="text-slate-500 hover:text-white disabled:opacity-0 transition-opacity flex items-center gap-2 font-bold">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Previous
                    </button>
                    <div class="flex gap-2">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="w-2 h-2 rounded-full transition-all duration-300"
                                :class="index === currentIndex ? 'bg-blue-500 w-6' : 'bg-white/20'"></div>
                        </template>
                    </div>
                    <button @click="next()" x-show="currentIndex < items.length - 1"
                        class="text-white hover:text-blue-400 transition-colors flex items-center gap-2 font-bold focus:outline-none">
                        Next
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <button @click="close()" x-show="currentIndex === items.length - 1"
                        class="text-emerald-400 hover:text-emerald-300 transition-colors flex items-center gap-2 font-bold focus:outline-none">
                        Finish Report
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </template>
    </div>

    <!-- Script Focus Mode -->
    <script>
        function focusMode() {
            return {
                open: false,
                loading: false,
                items: [],
                currentIndex: 0,

                async start() {
                    this.open = true;
                    this.loading = true;
                    this.currentIndex = 0;

                    try {
                        const res = await fetch('{{ route('api.summary') }}');
                        const json = await res.json();
                        if (json.success) {
                            // Merge all data types into a single sequential list
                            this.items = [
                                ...json.data.sick_students,
                                ...json.data.low_stock,
                                ...json.data.expiry
                            ];
                        }
                    } catch (e) {
                        alert('Gagal mengambil data ringkasan.');
                    } finally {
                        this.loading = false;
                    }
                },

                currentItem() {
                    return this.items[this.currentIndex] || {};
                },

                next() {
                    if (this.currentIndex < this.items.length - 1) {
                        this.currentIndex++;
                    } else {
                        this.close();
                    }
                },

                prev() {
                    if (this.currentIndex > 0) {
                        this.currentIndex--;
                    }
                },

                close() {
                    this.open = false;
                    // Trigger refresh to update dashboard if changes were made
                    window.location.reload();
                },

                async markSembuh(id) {
                    try {
                        const url = '{{ route('admin.sakit.setStatus', ['id' => ':id', 'status' => 'Sembuh']) }}'.replace(':id', id);
                        const res = await fetch(url);
                        if (res.ok) {
                            this.next();
                        }
                    } catch (e) {
                        console.error(e);
                    }
                },

                async addReminder(name, type) {
                    try {
                        let title = '';
                        if (type === 'stock') title = 'Restock ' + name;
                        if (type === 'expiry') title = 'Cek Kadaluarsa ' + name;

                        const res = await fetch('{{ route('api.reminders.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                title: title,
                                message: 'Perlu tindakan untuk ' + name,
                                type: type,
                                priority: 'normal'
                            })
                        });
                        if (res.ok) {
                            window.dispatchEvent(new CustomEvent('refresh-reminders'));
                            this.next();
                        }
                    } catch (e) {
                        console.error(e);
                    }
                }
            }
        }
    </script>
</div>