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
        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-xl">
            @php
                $icons = ['create' => '📝', 'update' => '🔄', 'delete' => '🗑️', 'login' => '🔑', 'restock' => '📦'];
                echo $icons[strtolower($log->action)] ?? '📍';
            @endphp
        </div>
        <div>
            <div class="font-bold text-slate-900">{{ ucfirst($log->action) }} in {{ ucfirst($log->module) }}</div>
            <div class="text-xs text-slate-500">{{ $log->created_at->format('d M Y, H:i:s') }}</div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 text-sm mt-4">
        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
            <label class="text-[10px] font-bold text-slate-400 uppercase">User</label>
            <div class="font-medium text-slate-800">{{ $log->user->name ?? 'System' }}</div>
            <div class="text-[10px] text-slate-500 uppercase">{{ $log->user->role ?? '-' }}</div>
        </div>
        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
            <label class="text-[10px] font-bold text-slate-400 uppercase">IP Address</label>
            <div class="font-mono text-slate-800">{{ $log->ip_address }}</div>
        </div>
    </div>

    <div class="bg-slate-900 p-4 rounded-xl">
        <label class="text-[10px] font-bold text-slate-500 uppercase">Payload / Detail</label>
        <pre class="text-xs text-emerald-400 mt-2 overflow-x-auto whitespace-pre-wrap">{{ $log->detail }}</pre>
    </div>
</div>
<div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
    <x-button data-modal-close variant="outline">Tutup</x-button>
</div>