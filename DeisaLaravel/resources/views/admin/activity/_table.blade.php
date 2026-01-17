<div class="overflow-x-auto">
    <table class="w-full text-left text-sm text-slate-600">
        <thead class="bg-slate-50 text-slate-900 border-b border-slate-200">
            <tr>
                <th class="px-4 py-3 font-semibold">Waktu</th>
                <th class="px-4 py-3 font-semibold">User</th>
                <th class="px-4 py-3 font-semibold">Aktivitas</th>
                <th class="px-4 py-3 font-semibold">Modul</th>
                <th class="px-4 py-3 font-semibold">IP Address</th>
                <th class="px-4 py-3 font-semibold text-right">Detail</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($logs as $log)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-4 py-3 text-slate-500 italic">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    <td class="px-4 py-3">
                        <div class="font-medium text-slate-900">{{ $log->user->name ?? 'System' }}</div>
                        <div class="text-xs text-slate-500">{{ ucfirst($log->user->role ?? 'Guest') }}</div>
                    </td>
                    <td class="px-4 py-3">
                        @php
                            $actionCls = [
                                'create' => 'bg-emerald-100 text-emerald-800',
                                'update' => 'bg-blue-100 text-blue-800',
                                'delete' => 'bg-red-100 text-red-800',
                                'login' => 'bg-purple-100 text-purple-800',
                                'restock' => 'bg-amber-100 text-amber-800'
                            ];
                            $cls = $actionCls[strtolower($log->action)] ?? 'bg-slate-100 text-slate-800';
                        @endphp
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $cls }}">
                            {{ ucfirst($log->action) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ ucfirst($log->module) }}</td>
                    <td class="px-4 py-3 font-mono text-xs">{{ $log->ip_address }}</td>
                    <td class="px-4 py-3 text-right">
                        <x-button variant="outline" class="px-2 py-1 text-xs"
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