<div class="space-y-6">
    <!-- Header/Actions -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex-1 max-w-md relative">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama atau email..." 
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none text-sm bg-white shadow-sm">
            <div class="absolute left-3 top-3 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Alert -->
    @if (session()->has('success'))
        <div class="animate-slide-in-down mb-4">
            <x-alert type="success" title="Berhasil!" :message="session('success')" />
        </div>
    @endif

    <!-- Cards Layout for Mobile/Desktop -->
    <div class="grid grid-cols-1 gap-4">
        @forelse($requests as $reg)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 group animate-fade-in flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-black shadow-inner">
                        {{ substr($reg->name, 0, 1) }}
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-black text-gray-800 tracking-tight">{{ $reg->name }}</h3>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">{{ $reg->email }}</p>
                    </div>
                </div>

                <div class="flex flex-col md:items-end">
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-2">{{ $reg->created_at->diffForHumans() }}</p>
                    <div class="flex gap-2">
                        <button wire:click="approve({{ $reg->id }})" class="px-5 py-2 bg-emerald-500 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-emerald-600 transition-all duration-300 shadow-md hover:shadow-emerald-200">
                            Setujui
                        </button>
                        <button wire:click="reject({{ $reg->id }})" class="px-5 py-2 bg-red-50 text-red-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-red-100 transition-all duration-300">
                            Tolak
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-20 text-center bg-white rounded-3xl border border-gray-100 shadow-sm">
                <p class="text-gray-400 italic">Tidak ada permintaan registrasi pending.</p>
            </div>
        @endforelse
    </div>

    @if($requests->hasPages())
        <div class="pt-6">
            {{ $requests->links() }}
        </div>
    @endif
</div>
