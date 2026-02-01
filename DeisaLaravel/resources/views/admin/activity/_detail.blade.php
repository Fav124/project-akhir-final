<div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
    <h3 class="font-bold text-slate-900">Activity Detail</h3>
    <button data-modal-close class="text-slate-400 hover:text-slate-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>
<div class="p-6 space-y-4">
    <div class="flex items-center gap-4">
        <div
            class="w-14 h-14 rounded-2xl bg-blue-50 text-deisa-blue flex items-center justify-center text-2xl shadow-sm border border-blue-100">
            @php
                $icons = ['create' => '📝', 'update' => '🔄', 'delete' => '🗑️', 'login' => '🔑', 'restock' => '📦', 'use' => '💊'];
                echo $icons[strtolower($log->action)] ?? '📍';
            @endphp
        </div>
        <div>
            <div class="font-black text-slate-900 text-lg tracking-tight">{{ ucfirst($log->action) }} in
                {{ ucfirst($log->module) }}</div>
            <div class="text-xs font-medium text-slate-400">{{ $log->created_at->format('d M Y, H:i:s') }}</div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 text-sm mt-4">
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">User
                Pelaksana</label>
            <div class="font-bold text-slate-800">{{ $log->user->name ?? 'System' }}</div>
            <div class="text-[10px] text-slate-500 uppercase font-bold">{{ $log->user->role ?? '-' }}</div>
        </div>
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">IP Address</label>
            <div class="font-mono font-bold text-slate-800">{{ $log->ip_address }}</div>
            <div class="text-[10px] text-slate-500 uppercase font-bold">Remote Host</div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-3">Payload / Detail
            Data</label>
        <pre
            class="text-xs text-emerald-400 overflow-x-auto whitespace-pre-wrap leading-relaxed font-mono">{{ $log->detail }}</pre>
    </div>
</div>
<div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
    <x-button data-modal-close variant="outline">Tutup</x-button>
</div>