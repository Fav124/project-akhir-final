<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Santri -->
        <x-card variant="gradient">
            <x-slot name="icon">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 11a6 6 0 11-12 0 6 6 0 0112 0zM13 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM20 21a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </x-slot>
            
            <div class="text-center">
                <p class="text-4xl font-bold text-emerald-600 mb-2">{{ $stats['total_santri'] }}</p>
                <p class="text-gray-600 text-sm font-medium">Total Santri Terdaftar</p>
            </div>
        </x-card>

        <!-- Santri Sakit -->
        <x-card variant="danger">
            <x-slot name="icon">
                <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" fill-rule="evenodd" />
                </svg>
            </x-slot>
            
            <div class="text-center">
                <p class="text-4xl font-bold text-red-600 mb-2">{{ $stats['santri_sakit'] }}</p>
                <p class="text-gray-600 text-sm font-medium">Dalam Perawatan</p>
            </div>
        </x-card>

        <!-- Total Obat -->
        <x-card variant="warning">
            <x-slot name="icon">
                <svg class="w-8 h-8 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2A4 4 0 000 5v10a4 4 0 004 4h12a4 4 0 004-4V5a1 1 0 100 2 2 2 0 012 2z"></path>
                </svg>
            </x-slot>
            
            <div class="text-center">
                <p class="text-4xl font-bold text-amber-600 mb-2">{{ $stats['total_obat'] }}</p>
                <p class="text-gray-600 text-sm font-medium">Jenis Obat Tersedia</p>
            </div>
        </x-card>

        <!-- Recovery Rate -->
        <x-card variant="success">
            <x-slot name="icon">
                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V9.414l-4.293 4.293a1 1 0 01-1.414-1.414L13.586 8H12z" fill-rule="evenodd" />
                </svg>
            </x-slot>
            
            <div class="text-center">
                <p class="text-4xl font-bold text-green-600 mb-2">{{ $stats['recovery_rate'] }}%</p>
                <p class="text-gray-600 text-sm font-medium">Tingkat Pemulihan</p>
            </div>
        </x-card>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Patients List -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-800">Catatan Sakit Terbaru</h3>
                <div class="flex items-center space-x-2">
                    <input wire:model.live.debounce.300ms="searchSantri" type="text" placeholder="Cari santri..." class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-smooth text-sm outline-none">
                    <select wire:model.live="filterStatus" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-smooth text-sm outline-none">
                        <option value="Sakit">Sakit</option>
                        <option value="Sembuh">Sembuh</option>
                        <option value="Pulang">Pulang</option>
                        <option value="">Semua</option>
                    </select>
                </div>
            </div>

            <x-card variant="primary">
                <div class="space-y-4">
                    @forelse($recentSakit as $sakit)
                        <div class="flex items-center p-4 bg-white rounded-xl border border-gray-100 hover:border-emerald-200 hover:shadow-lg transition-all duration-300 animate-fade-in">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold text-lg shadow-inner">
                                {{ substr($sakit->santri->nama_lengkap ?? '?', 0, 1) }}
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="font-bold text-gray-800 text-lg">{{ $sakit->santri->nama_lengkap }}</h4>
                                <p class="text-sm text-gray-500">Kelas: {{ $sakit->santri->kelas->nama_kelas ?? '-' }} | Diagnosis: {{ $sakit->diagnosis ?? 'Menunggu...' }}</p>
                            </div>
                            <div class="text-right">
                                @php
                                    $statusClasses = [
                                        'Sakit' => 'bg-red-100 text-red-700 border-red-200',
                                        'Sembuh' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'Pulang' => 'bg-blue-100 text-blue-700 border-blue-200'
                                    ];
                                @endphp
                                <span class="px-3 py-1 border rounded-full text-xs font-bold uppercase tracking-wider {{ $statusClasses[$sakit->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                    {{ $sakit->status }}
                                </span>
                                <p class="text-xs text-gray-400 mt-2 font-medium">{{ $sakit->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-500 font-medium">Tidak ada data yang ditemukan.</p>
                        </div>
                    @endforelse
                </div>
            </x-card>
        </div>

        <!-- Sidebar Actions & Critical Inventory -->
        <div class="space-y-8">
            <!-- Quick Actions -->
            <x-card title="Aksi Cepat" variant="success">
                <div class="grid grid-cols-1 gap-3">
                    <button wire:click="toggleModal('add_sakit')" class="flex items-center justify-center space-x-2 w-full py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-all duration-300 font-bold shadow-md hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Catat Sakit Baru</span>
                    </button>
                    
                    <button wire:click="toggleModal('add_obat')" class="flex items-center justify-center space-x-2 w-full py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-xl transition-all duration-300 font-bold shadow-md hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Tambah Stok Obat</span>
                    </button>
                    
                    <a href="{{ route('web.santri.index') }}" class="flex items-center justify-center space-x-2 w-full py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl transition-all duration-300 font-bold shadow-md hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Manajemen Santri</span>
                    </a>
                </div>
            </x-card>

            <!-- Inventory Watch -->
            <x-card title="Stok Obat Kritis" variant="danger">
                <div class="mb-4">
                    <input wire:model.live.debounce.300ms="searchObat" type="text" placeholder="Cari obat..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-smooth text-sm outline-none">
                </div>
                <div class="space-y-3">
                    @forelse($criticalObats as $obat)
                        <div class="p-4 bg-red-50 rounded-xl border border-red-100 group hover:shadow-md transition-all duration-300 animate-slide-in-right">
                            <div class="flex items-center justify-between">
                                <h4 class="font-bold text-gray-800 text-sm group-hover:text-red-600">{{ $obat->nama_obat }}</h4>
                                <span class="px-2 py-0.5 bg-red-200 text-red-700 text-[10px] font-black rounded-lg">KRITIS</span>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <span class="text-2xl font-black text-red-600">{{ $obat->stok }} <span class="text-xs font-normal text-gray-500 uppercase">{{ $obat->satuan ?? 'Pcs' }}</span></span>
                                <div class="w-24 bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-red-500 h-1.5 rounded-full" style="width: {{ min(100, ($obat->stok / ($obat->stok_minimum ?: 10)) * 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-400">
                            <p class="text-xs font-medium italic">Semua stok terpantau aman.</p>
                        </div>
                    @endforelse
                </div>
            </x-card>
        </div>
    </div>

    <!-- Quick Entry Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] flex items-center justify-center p-4 animate-fade-in" wire:click.self="toggleModal">
            <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden animate-scale-in border border-gray-100">
                <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 px-8 py-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-black text-white">
                            {{ $modalType === 'add_sakit' ? 'Catat Santri Sakit' : 'Update Stok Obat' }}
                        </h3>
                        <p class="text-emerald-100 text-sm opacity-90">Lengkapi data untuk sinkronisasi realtime</p>
                    </div>
                    <button wire:click="toggleModal" class="text-white hover:bg-emerald-700 p-2 rounded-2xl transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18" />
                        </svg>
                    </button>
                </div>
                
                <div class="p-8">
                    @if($modalType === 'add_sakit')
                        <div class="space-y-6">
                            <p class="text-gray-600 leading-relaxed italic border-l-4 border-emerald-500 pl-4 bg-emerald-50 py-3 rounded-r-xl">
                                Form ini terhubung langsung dengan sistem dashboard utama dan API Android petugas.
                            </p>
                            <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 flex items-start space-x-3">
                                <svg class="w-6 h-6 text-blue-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <p class="text-sm text-blue-700">Untuk pengelolaan data yang lebih kompleks, gunakan menu <span class="font-bold">Data Sakit</span> yang mencakup pemilihan obat-obatan.</p>
                            </div>
                        </div>
                    @else
                        <div class="space-y-6">
                            <p class="text-gray-600">Pilih obat dan tentukan jumlah penambahan stok.</p>
                        </div>
                    @endif
                </div>
                
                <div class="bg-gray-50 px-8 py-6 flex justify-end space-x-3">
                    <button wire:click="toggleModal" class="px-6 py-3 bg-white text-gray-700 border border-gray-200 rounded-2xl hover:bg-gray-100 transition-all duration-300 font-bold">
                        Batalkan
                    </button>
                    <a href="{{ $modalType === 'add_sakit' ? route('web.sakit.create') : route('web.obat.index') }}" class="px-8 py-3 bg-emerald-500 text-white rounded-2xl hover:bg-emerald-600 transition-all duration-300 font-bold shadow-lg shadow-emerald-200 flex items-center space-x-2">
                        <span>Lanjutkan di Panel</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
