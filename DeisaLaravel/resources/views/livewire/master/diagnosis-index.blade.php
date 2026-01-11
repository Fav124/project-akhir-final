<div class="space-y-6">
    <!-- Header/Actions -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex-1 max-w-md relative">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama diagnosis..." 
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all outline-none text-sm bg-white shadow-sm">
            <div class="absolute left-3 top-3 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <select wire:model.live="category" class="px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-rose-500 transition-all outline-none text-sm bg-white shadow-sm">
                <option value="">Semua Kategori</option>
                <option value="Ringan">Ringan</option>
                <option value="Sedang">Sedang</option>
                <option value="Berat">Berat</option>
            </select>

            <a href="{{ route('web.diagnosis.create') }}" class="inline-flex items-center px-5 py-2.5 rounded-xl font-bold text-white bg-gradient-to-r from-rose-500 to-rose-600 hover:shadow-lg hover:shadow-rose-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Diagnosis
            </a>
        </div>
    </div>

    <!-- Alert -->
    @if (session()->has('success'))
        <div class="animate-slide-in-down mb-4">
            <x-alert type="success" title="Berhasil!" :message="session('success')" />
        </div>
    @endif

    <!-- Lists -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($diagnoses as $d)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-rose-100 transition-all duration-300 group animate-fade-in relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-xl {{ $d->kategori === 'Berat' ? 'bg-red-50 text-red-500' : ($d->kategori === 'Sedang' ? 'bg-amber-50 text-amber-500' : 'bg-emerald-50 text-emerald-500') }} flex items-center justify-center shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-black text-gray-800 leading-tight uppercase tracking-tight">{{ $d->nama_diagnosis }}</h3>
                            <span class="text-[10px] font-black uppercase tracking-widest {{ $d->kategori === 'Berat' ? 'text-red-500' : ($d->kategori === 'Sedang' ? 'text-amber-500' : 'text-emerald-500') }}">
                                {{ $d->kategori }}
                            </span>
                        </div>
                    </div>

                    <div class="flex gap-2 scale-90 opacity-0 group-hover:opacity-100 transition-all duration-300">
                        <a href="{{ route('web.diagnosis.edit', $d) }}" class="p-2 bg-gray-50 text-gray-400 rounded-xl hover:bg-amber-50 hover:text-amber-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <button wire:click="deleteDiagnosis({{ $d->id }})" wire:confirm="Hapus diagnosis ini?" class="p-2 bg-gray-50 text-gray-400 rounded-xl hover:bg-red-50 hover:text-red-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-50">
                    <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed font-medium">"{{ $d->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}"</p>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-gray-100">
                <p class="text-gray-400 italic">Tidak ada referensi diagnosis ditemukan.</p>
            </div>
        @endforelse
    </div>

    @if($diagnoses->hasPages())
        <div class="pt-6">
            {{ $diagnoses->links() }}
        </div>
    @endif
</div>
