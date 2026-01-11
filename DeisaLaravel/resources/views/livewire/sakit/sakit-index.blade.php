<div class="space-y-10 animate-fade-in">
    <!-- Action Bar (Bento Style with Glow) -->
    <div class="glass-premium rounded-[2.5rem] p-6 border border-white/40 shadow-2xl shadow-slate-200/20 flex flex-col md:flex-row items-center justify-between gap-6 animate-border-glow">
        <div class="flex-1 w-full max-w-xl relative group">
            <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400 group-focus-within:text-rose-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search medical events database..." 
                class="w-full pl-16 pr-6 py-5 rounded-3xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-rose-100 focus:border-rose-400 transition-all outline-none font-bold text-sm text-slate-700 shadow-inner">
        </div>
        
        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="relative flex-1 md:flex-none">
                <select wire:model.live="status" class="w-full appearance-none pl-6 pr-12 py-5 rounded-3xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-rose-100 transition-all outline-none font-black text-[10px] uppercase tracking-widest text-slate-500 cursor-pointer shadow-inner">
                    <option value="">Status Filter</option>
                    <option value="Sakit">🔴 Active Cases</option>
                    <option value="Sembuh">🟢 Recovered</option>
                    <option value="Pulang">🏠 At Home</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            <a href="{{ route('web.sakit.create') }}" class="flex-1 md:flex-none inline-flex items-center justify-center px-10 py-5 rounded-3xl font-black text-[10px] uppercase tracking-[0.2em] text-white bg-slate-900 shadow-2xl shadow-slate-200 hover:bg-rose-600 hover:shadow-rose-200 transition-all duration-500 transform hover:-translate-y-1 active:scale-95">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                Record Event
            </a>
        </div>
    </div>

    <!-- Medical Intelligence Table -->
    <div class="glass-premium rounded-[3rem] border border-white/40 shadow-2xl shadow-slate-200/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100/50">
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Patient Profile</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Clinical Evaluation</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Temporal Data</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Ops</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($sakits as $sakit)
                        <tr class="hover:bg-rose-50/20 transition-all duration-300 group">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="relative">
                                        <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 font-black text-lg shadow-inner group-hover:scale-110 transition-transform duration-500">
                                            {{ substr($sakit->santri->nama_lengkap ?? '?', 0, 1) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-base font-black text-slate-900 tracking-tight mb-0.5">{{ $sakit->santri->nama_lengkap ?? 'Unknown' }}</h4>
                                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 px-2 py-0.5 rounded-md">{{ $sakit->santri->nis ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="max-w-xs">
                                    <p class="text-sm font-bold text-slate-800 tracking-tight leading-snug line-clamp-1">{{ $sakit->diagnosis ?? 'Pending diagnosis...' }}</p>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Symptom: {{ $sakit->keluhan ?? '-' }}</p>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                        <span class="text-[10px] font-black text-slate-500 tracking-widest">{{ $sakit->tgl_masuk->format('d M Y') }}</span>
                                    </div>
                                    @if($sakit->tgl_sembuh)
                                        <div class="flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                            <span class="text-[10px] font-black text-emerald-600 tracking-widest">{{ $sakit->tgl_sembuh->format('d M Y') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                @if($sakit->status === 'Sakit')
                                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-xl bg-orange-50 text-orange-600 border border-orange-100 shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                        <span class="text-[9px] font-black uppercase tracking-widest">In care</span>
                                    </div>
                                @elseif($sakit->status === 'Sembuh')
                                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        <span class="text-[9px] font-black uppercase tracking-widest">Healthy</span>
                                    </div>
                                @else
                                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-xl bg-slate-50 text-slate-600 border border-slate-100">
                                        <span class="text-[9px] font-black uppercase tracking-widest">Home</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-x-4 group-hover:translate-x-0">
                                    @if($sakit->status === 'Sakit')
                                        <button wire:click="markSembuh({{ $sakit->id }})" class="p-3 rounded-xl bg-emerald-500 text-white shadow-lg shadow-emerald-200 hover:bg-emerald-600 transition-all transform hover:scale-110 active:scale-95" title="Mark as Healthy">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    @endif
                                    <button class="p-3 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-slate-900 transition-all transform hover:scale-110 shadow-sm" title="View Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-32 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-24 h-24 rounded-[2rem] bg-slate-50 flex items-center justify-center mx-auto mb-8 border border-slate-100 shadow-inner">
                                        <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <h3 class="text-2xl font-black text-slate-900 tracking-tighter">Healthy Environment</h3>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em] mt-2">No active clinic records found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($sakits->hasPages())
        <div class="glass-premium rounded-[3rem] p-8 border border-white/40 shadow-xl shadow-slate-200/20">
            {{ $sakits->links() }}
        </div>
    @endif
</div>
