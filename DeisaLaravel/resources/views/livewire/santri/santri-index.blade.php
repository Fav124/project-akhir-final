<div class="space-y-10 animate-fade-in">
    <!-- Action Bar (Bento Style with Glow) -->
    <div class="glass-premium rounded-[2.5rem] p-6 border border-white/40 shadow-2xl shadow-slate-200/20 flex flex-col md:flex-row items-center justify-between gap-6 animate-border-glow">
        <div class="flex-1 w-full max-w-xl relative group">
            <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search parameters across intelligence database..." 
                class="w-full pl-16 pr-6 py-5 rounded-3xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition-all outline-none font-bold text-sm text-slate-700 shadow-inner">
        </div>
        
        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="relative flex-1 md:flex-none">
                <select wire:model.live="status" class="w-full appearance-none pl-6 pr-12 py-5 rounded-3xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-emerald-100 transition-all outline-none font-black text-[10px] uppercase tracking-widest text-slate-500 cursor-pointer shadow-inner">
                    <option value="">Status Filter</option>
                    <option value="Sehat">🟢 Optimized</option>
                    <option value="Sakit">🔴 At Risk</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            <a href="{{ route('web.santri.create') }}" class="flex-1 md:flex-none inline-flex items-center justify-center px-10 py-5 rounded-3xl font-black text-[10px] uppercase tracking-[0.2em] text-white bg-slate-900 shadow-2xl shadow-slate-200 hover:bg-emerald-600 transition-all duration-500 transform hover:-translate-y-1 active:scale-95">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                New Entry
            </a>
        </div>
    </div>

    <!-- Data Table (High Contrast) -->
    <div class="glass-premium rounded-[3rem] border border-white/40 shadow-2xl shadow-slate-200/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100/50">
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Santri Intelligence</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Contextual Data</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Vital Status</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($santris as $santri)
                        <tr class="hover:bg-emerald-50/20 transition-all duration-300 group">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="relative">
                                        <div class="w-16 h-16 rounded-[1.5rem] bg-white border border-slate-100 flex items-center justify-center text-slate-400 font-black text-xl shadow-inner group-hover:scale-110 transition-transform duration-500">
                                            {{ substr($santri->nama_lengkap, 0, 1) }}
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-lg bg-white shadow-lg flex items-center justify-center border border-slate-100">
                                            <div class="w-2.5 h-2.5 rounded-full {{ $santri->status_kesehatan === 'Sehat' ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-base font-black text-slate-900 tracking-tight mb-1">{{ $santri->nama_lengkap }}</h4>
                                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 px-2 py-0.5 rounded-md">{{ $santri->nis }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="space-y-1">
                                    <div class="text-sm font-bold text-slate-700 tracking-tight">{{ $santri->kelas->nama_kelas ?? 'N/A' }}</div>
                                    <div class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.1em]">{{ $santri->jurusan->nama_jurusan ?? 'GENERAL' }}</div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                @if($santri->status_kesehatan === 'Sehat')
                                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-900">Health Optimized</span>
                                    </div>
                                @else
                                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-xl bg-rose-50 text-rose-600 border border-rose-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-900">Critical Case</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-x-4 group-hover:translate-x-0">
                                    <a href="{{ route('web.santri.edit', $santri) }}" class="p-3 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-emerald-500 hover:border-emerald-100 shadow-sm transition-all transform hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <button wire:click="deleteSantri({{ $santri->id }})" wire:confirm="Confirm permanent data removal from intelligence server?" class="p-3 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-rose-500 hover:border-rose-100 shadow-sm transition-all transform hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-32 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-24 h-24 rounded-[2rem] bg-slate-50 flex items-center justify-center mx-auto mb-8 border border-slate-100 shadow-inner">
                                        <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <h3 class="text-2xl font-black text-slate-900 tracking-tighter">Zero Records Detected</h3>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em] mt-2">Initialize core dataset to begin</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($santris->hasPages())
            <div class="px-10 py-10 bg-slate-50/30 border-t border-slate-100/50">
                {{ $santris->links() }}
            </div>
        @endif
    </div>
</div>
