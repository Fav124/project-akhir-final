<div class="overflow-x-auto">
    <table class="w-full text-left text-sm text-slate-600">
        <thead class="bg-slate-50 text-slate-500 text-[10px] font-bold uppercase tracking-wider border-b border-slate-100">
            <tr>
                <th class="px-6 py-4">Waktu</th>
                <th class="px-6 py-4">User</th>
                <th class="px-6 py-4">Aktivitas</th>
                <th class="px-6 py-4">Modul</th>
                <th class="px-6 py-4">IP Address</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($logs as $log)
                <tr class="hover:bg-slate-50 transition-colors group">
                    <td class="px-6 py-4 text-slate-500 italic">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-900">{{ $log->user->name ?? 'System' }}</div>
                        <div class="text-[10px] text-slate-400 uppercase font-black">{{ $log->user->role ?? 'Guest' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $actionCls = [
                                'create' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                'update' => 'bg-blue-50 text-blue-700 border-blue-100',
                                'delete' => 'bg-red-50 text-red-700 border-red-100',
                                'login' => 'bg-purple-50 text-purple-700 border-purple-100',
                                'restock' => 'bg-amber-50 text-amber-700 border-amber-100'
                            ];
                            $cls = $actionCls[strtolower($log->action)] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase border {{ $cls }}">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-medium text-slate-700">{{ ucfirst($log->module) }}</span>
                    </td>
                    <td class="px-6 py-4 font-mono text-xs text-slate-400">{{ $log->ip_address }}</td>
                    <td class="px-6 py-4 text-right">
                        <x-button variant="outline" size="sm" class="rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"
                            data-detail-url="{{ route('admin.activity.show', $log->id) }}">
                            Detail
                        </x-button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-slate-500 italic">Belum ada riwayat aktivitas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $logs->links() }}
</div>