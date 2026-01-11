@extends('layouts.app-tailwind')

@section('page_title', 'Access Approval')
@section('page_subtitle', 'Registration Requests')

@section('content')
<div class="space-y-10 animate-fade-in">
    @if($requests->isEmpty())
        <div class="glass-premium rounded-[3rem] py-32 border border-white/40 shadow-2xl shadow-slate-200/20 text-center">
            <div class="flex flex-col items-center justify-center">
                <div class="w-24 h-24 rounded-[2rem] bg-slate-50 flex items-center justify-center text-slate-200 mb-8 border border-slate-100 shadow-inner">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-2xl font-black text-slate-900 tracking-tighter">Clearance Queue Empty</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em] mt-2">No pending personnel registration requests detected</p>
            </div>
        </div>
    @else
        <!-- Action Bar (Bento Style) -->
        <div class="glass-premium rounded-[2.5rem] p-6 border border-white/40 shadow-2xl shadow-slate-200/20 flex flex-col md:flex-row items-center justify-between gap-6 animate-border-glow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Pending Clearance</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Authorization Requests Pipeline</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="px-6 py-3 rounded-2xl bg-amber-50 border border-amber-100 text-[10px] font-black text-amber-600 uppercase tracking-widest animate-pulse">
                    Action Required
                </div>
            </div>
        </div>

        <!-- Data Table (Super-Premium) -->
        <div class="glass-premium rounded-[3rem] border border-white/40 shadow-2xl shadow-slate-200/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100/50">
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Applicant Persona</th>
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Submission Date</th>
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Clearance Protocol</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($requests as $reg)
                            <tr class="hover:bg-slate-50/50 transition-all duration-300 group">
                                <td class="px-10 py-8">
                                    <div class="flex items-center gap-6">
                                        <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 font-black text-lg shadow-inner group-hover:bg-slate-900 group-hover:text-white transition-all duration-500">
                                            {{ substr($reg->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="text-base font-black text-slate-900 tracking-tight capitalize">{{ $reg->name }}</h4>
                                            <p class="text-[10px] font-bold text-slate-400 mt-0.5">{{ $reg->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-8">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $reg->created_at->format('M d, Y') }}</span>
                                    <p class="text-[9px] font-bold text-slate-300 mt-1">{{ $reg->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-10 py-8 text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-x-4 group-hover:translate-x-0">
                                        <form action="{{ route('web.admin.approve', $reg->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-500 text-white font-black text-[10px] uppercase tracking-widest shadow-lg shadow-emerald-200 hover:bg-emerald-600 transition-all transform hover:scale-105 active:scale-95">
                                                Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('web.admin.reject', $reg->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="flex items-center gap-2 px-6 py-3 rounded-xl bg-rose-50 text-rose-500 border border-rose-100 font-black text-[10px] uppercase tracking-widest hover:bg-rose-100 transition-all transform hover:scale-105 active:scale-95">
                                                Deny
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($requests->hasPages())
                <div class="px-10 py-8 bg-slate-50/30 border-t border-slate-100/50">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
