<div class="space-y-10 animate-fade-in">
    <!-- Action Bar (Bento Style with Tabs & Glow) -->
    <div class="glass-premium rounded-[2.5rem] p-6 border border-white/40 shadow-2xl shadow-slate-200/20 flex flex-col md:flex-row items-center justify-between gap-6 animate-border-glow">
        <!-- Tabs -->
        <div class="flex items-center p-1.5 rounded-3xl bg-slate-50/50 border border-slate-100 shadow-inner">
            <button wire:click="setTab('kelas')" class="px-8 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 {{ $activeTab === 'kelas' ? 'bg-white text-emerald-500 shadow-xl shadow-emerald-100' : 'text-slate-400 hover:text-slate-600' }}">
                Classes
            </button>
            <button wire:click="setTab('jurusan')" class="px-8 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 {{ $activeTab === 'jurusan' ? 'bg-white text-indigo-500 shadow-xl shadow-indigo-100' : 'text-slate-400 hover:text-slate-600' }}">
                Departments
            </button>
            <button wire:click="setTab('diagnosis')" class="px-8 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 {{ $activeTab === 'diagnosis' ? 'bg-white text-rose-500 shadow-xl shadow-rose-100' : 'text-slate-400 hover:text-slate-600' }}">
                Library
            </button>
        </div>

        <div class="flex-1 w-full max-w-sm relative group">
            <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-slate-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search parameters..." 
                class="w-full pl-14 pr-6 py-4 rounded-2xl border border-slate-100 bg-slate-50/20 focus:bg-white focus:ring-4 focus:ring-emerald-100 transition-all outline-none font-bold text-xs text-slate-700 shadow-inner">
        </div>

        <a href="{{ route('web.'.$activeTab.'.create') }}" class="inline-flex items-center justify-center px-10 py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] text-white bg-slate-900 shadow-2xl shadow-slate-200 hover:bg-emerald-600 transition-all duration-500 transform hover:-translate-y-1 active:scale-95">
            New Entity
        </a>
    </div>

    <!-- Data Table Container (High Contrast) -->
    <div class="glass-premium rounded-[3rem] border border-white/40 shadow-2xl shadow-slate-200/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100/50">
                        @if($activeTab === 'kelas')
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Class Identity</th>
                        @elseif($activeTab === 'jurusan')
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Department Intelligence</th>
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Identifier Code</th>
                        @else
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Clinical Designation</th>
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Categorization</th>
                        @endif
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($items as $item)
                        <tr class="hover:bg-slate-50/50 transition-all duration-300 group">
                            @if($activeTab === 'kelas')
                                <td class="px-10 py-8">
                                    <div class="flex items-center gap-6">
                                        <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 text-slate-400 flex items-center justify-center font-black text-lg shadow-inner group-hover:bg-emerald-500 group-hover:text-white transition-all duration-500">
                                            {{ substr($item->nama_kelas, 0, 1) }}
                                        </div>
                                        <span class="text-base font-black text-slate-900 tracking-tight">{{ $item->nama_kelas }}</span>
                                    </div>
                                </td>
                            @elseif($activeTab === 'jurusan')
                                <td class="px-10 py-8">
                                    <div class="flex items-center gap-6">
                                        <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 text-slate-400 flex items-center justify-center font-black text-lg shadow-inner group-hover:bg-indigo-500 group-hover:text-white transition-all duration-500">
                                            {{ substr($item->nama_jurusan, 0, 1) }}
                                        </div>
                                        <span class="text-base font-black text-slate-900 tracking-tight">{{ $item->nama_jurusan }}</span>
                                    </div>
                                </td>
                                <td class="px-10 py-8">
                                    <span class="text-[10px] font-black text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-xl border border-indigo-100 tracking-widest">{{ $item->kode_jurusan }}</span>
                                </td>
                            @else
                                <td class="px-10 py-8">
                                    <div class="flex items-center gap-6">
                                        <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 text-slate-400 flex items-center justify-center font-black text-lg shadow-inner group-hover:bg-rose-500 group-hover:text-white transition-all duration-500">
                                            {{ substr($item->nama_diagnosis, 0, 1) }}
                                        </div>
                                        <span class="text-base font-black text-slate-900 tracking-tight">{{ $item->nama_diagnosis }}</span>
                                    </div>
                                </td>
                                <td class="px-10 py-8">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-100">{{ $item->kategori ?? 'UNSET' }}</span>
                                </td>
                            @endif

                            <td class="px-10 py-8">
                                <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-x-4 group-hover:translate-x-0">
                                    <a href="{{ route('web.'.$activeTab.'.edit', $item) }}" class="p-3 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-emerald-500 hover:border-emerald-100 shadow-sm transition-all transform hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <button wire:click="delete{{ ucfirst($activeTab) }}({{ $item->id }})" wire:confirm="Permanently delete this master entry?" class="p-3 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-rose-500 hover:border-rose-100 shadow-sm transition-all transform hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-32 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-24 h-24 rounded-[2rem] bg-slate-50 flex items-center justify-center text-slate-200 mb-8 border border-slate-100 shadow-inner">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <h3 class="text-2xl font-black text-slate-900 tracking-tighter">Database Uninitialized</h3>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em] mt-2">Core dataset required for operational status</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($items->hasPages())
            <div class="px-10 py-10 bg-slate-50/30 border-t border-slate-100/50">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</div>
