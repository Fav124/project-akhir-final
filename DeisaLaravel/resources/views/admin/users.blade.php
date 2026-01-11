@extends('layouts.app-tailwind')

@section('page_title', 'Personnel Management')
@section('page_subtitle', 'Authorized Users')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Action Bar (Bento Style) -->
    <div class="glass-premium rounded-[2.5rem] p-6 border border-white/40 shadow-2xl shadow-slate-200/20 flex flex-col md:flex-row items-center justify-between gap-6 animate-border-glow">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
            <div>
                <h3 class="text-xl font-black text-slate-900 tracking-tight">Access Control</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Administrative Personnel List</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="px-6 py-3 rounded-2xl bg-slate-50 border border-slate-100 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                {{ $users->total() }} Total Entities
            </div>
        </div>
    </div>

    <!-- Data Table (Super-Premium) -->
    <div class="glass-premium rounded-[3rem] border border-white/40 shadow-2xl shadow-slate-200/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100/50">
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Personnel Profile</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Designation</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Activation Date</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-all duration-300 group">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="relative">
                                        <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 font-black text-lg shadow-inner group-hover:bg-slate-900 group-hover:text-white transition-all duration-500">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-lg"></div>
                                    </div>
                                    <div>
                                        <h4 class="text-base font-black text-slate-900 tracking-tight capitalize">{{ $user->name }}</h4>
                                        <p class="text-[10px] font-bold text-slate-400 mt-0.5">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-display">
                                <span class="inline-flex items-center px-4 py-2 rounded-xl {{ $user->role === 'admin' ? 'bg-indigo-50 text-indigo-600 border border-indigo-100' : 'bg-slate-50 text-slate-600 border border-slate-100' }} text-[9px] font-black uppercase tracking-widest">
                                    {{ $user->role ?? 'OFFICER' }}
                                </span>
                            </td>
                            <td class="px-10 py-8">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $user->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-x-4 group-hover:translate-x-0">
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('web.admin.user.destroy', $user->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-3 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-rose-500 hover:border-rose-100 shadow-sm transition-all transform hover:scale-110" onclick="return confirm('Initiate permanent deletion of this intelligence account?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest bg-emerald-50 px-3 py-1.5 rounded-xl border border-emerald-100">Primary Instance</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-10 py-8 bg-slate-50/30 border-t border-slate-100/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
