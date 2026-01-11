<div class="space-y-10 animate-fade-in">
    <!-- Action Bar (Bento Style with Glow) -->
    <div class="glass-premium rounded-[2.5rem] p-6 border border-white/40 shadow-2xl shadow-slate-200/20 flex flex-col md:flex-row items-center justify-between gap-6 animate-border-glow">
        <div class="flex-1 w-full max-w-xl relative group">
            <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search pharmaceutical database..." 
                class="w-full pl-16 pr-6 py-5 rounded-3xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition-all outline-none font-bold text-sm text-slate-700 shadow-inner">
        </div>
        
        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="relative flex-1 md:flex-none">
                <select wire:model.live="stockFilter" class="w-full appearance-none pl-6 pr-12 py-5 rounded-3xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-emerald-100 transition-all outline-none font-black text-[10px] uppercase tracking-widest text-slate-500 cursor-pointer shadow-inner">
                    <option value="">Inventory Scope</option>
                    <option value="low">🔴 Depleted/Low</option>
                    <option value="normal">🟢 Operational</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            <a href="{{ route('web.obat.create') }}" class="flex-1 md:flex-none inline-flex items-center justify-center px-10 py-5 rounded-3xl font-black text-[10px] uppercase tracking-[0.2em] text-white bg-slate-900 shadow-2xl shadow-slate-200 hover:bg-emerald-600 transition-all duration-500 transform hover:-translate-y-1 active:scale-95">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                New Asset
            </a>
        </div>
    </div>

    <!-- Inventory Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($obats as $obat)
            @php 
                $isLowStock = $obat->stok <= $obat->stok_minimum;
                $glowClass = $isLowStock ? 'animate-border-glow ring-2 ring-rose-500/10 border-rose-200 shadow-rose-100/30' : '';
            @endphp
            <div class="glass-premium rounded-[2.5rem] p-8 border {{ $isLowStock ? 'border-rose-200' : 'border-white/40' }} shadow-xl shadow-slate-200/20 group hover:-translate-y-2 transition-all duration-500 relative flex flex-col h-full overflow-hidden {{ $glowClass }}">
                <!-- Status Glow -->
                <div class="absolute top-0 right-0 w-32 h-32 {{ $isLowStock ? 'bg-rose-500/10' : 'bg-emerald-500/5' }} rounded-full blur-3xl -mt-10 -mr-10 transition-colors"></div>
                
                <!-- Card Header -->
                <div class="flex items-start justify-between mb-8 relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-slate-900 group-hover:text-white transition-all duration-500 shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86 .517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 01-.586 1.414l-2.828 2.828a2 2 0 01-1.414.586H8.586a2 2 0 01-1.414-.586L4.344 11.586A2 2 0 013.758 10.172V5L2 4h16" />
                        </svg>
                    </div>

                    <div class="flex flex-col items-end gap-2">
                        @if($isLowStock)
                            <span class="inline-flex items-center px-3 py-1 rounded-lg bg-rose-50 text-rose-600 text-[9px] font-black uppercase tracking-widest border border-rose-100">Depleted</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-widest border border-emerald-100">Ready</span>
                        @endif
                    </div>
                </div>

                <!-- Content -->
                <div class="flex-1 relative z-10">
                    <h3 class="text-xl font-black text-slate-900 tracking-tight leading-tight capitalize mb-1 group-hover:text-emerald-500 transition-colors">{{ $obat->nama_obat }}</h3>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $obat->satuan ?? 'UNIT' }} SYSTEM</p>
                    
                    <div class="mt-8 flex items-end justify-between">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Active Stock</p>
                            <h4 class="text-4xl font-black {{ $isLowStock ? 'text-rose-600' : 'text-slate-900' }} tracking-tighter">{{ $obat->stok }}</h4>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1">Critical Pt</p>
                            <p class="text-xs font-bold text-slate-400">{{ $obat->stok_minimum }}</p>
                        </div>
                    </div>

                    <!-- Progress Indicator -->
                    <div class="mt-6 w-full h-2 bg-slate-50 rounded-full overflow-hidden border border-slate-100 shadow-inner relative">
                        @php 
                            $maxCapacity = max($obat->stok_minimum * 3, $obat->stok, 1);
                            $percentage = ($obat->stok / $maxCapacity) * 100;
                        @endphp
                        <div class="h-full rounded-full transition-all duration-1000 ease-out {{ $isLowStock ? 'bg-gradient-to-r from-rose-500 to-rose-400' : 'bg-gradient-to-r from-emerald-500 to-teal-400' }}" style="width: {{ min(100, $percentage) }}%"></div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="mt-10 pt-8 border-t border-slate-50 flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-4 group-hover:translate-y-0 relative z-10">
                    <a href="{{ route('web.obat.edit', $obat) }}" class="p-3 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-emerald-500 hover:border-emerald-100 shadow-sm transition-all transform hover:scale-110">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </a>
                    <button wire:click="deleteObat({{ $obat->id }})" wire:confirm="Permanently delete this intelligence asset?" class="p-3 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-rose-500 hover:border-rose-100 shadow-sm transition-all transform hover:scale-110">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-32 text-center glass-premium rounded-[3rem] border border-white/40">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-24 h-24 rounded-[2rem] bg-slate-50 flex items-center justify-center text-slate-200 mb-8 border border-slate-100 shadow-inner">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86 .517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 01-.586 1.414l-2.828 2.828a2 2 0 01-1.414.586H8.586a2 2 0 01-1.414-.586L4.344 11.586A2 2 0 013.758 10.172V5L2 4h16"></path></svg>
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">Inventory Status: NULL</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($obats->hasPages())
        <div class="glass-premium rounded-[3rem] p-8 border border-white/40 shadow-xl shadow-slate-200/20">
            {{ $obats->links() }}
        </div>
    @endif
</div>
