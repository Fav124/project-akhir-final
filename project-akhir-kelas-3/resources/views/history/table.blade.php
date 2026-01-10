<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-800">
            <tr>
                <th class="px-6 py-4 text-sm font-bold text-text-main dark:text-gray-300 uppercase tracking-wider">Waktu</th>
                <th class="px-6 py-4 text-sm font-bold text-text-main dark:text-gray-300 uppercase tracking-wider">Admin</th>
                <th class="px-6 py-4 text-sm font-bold text-text-main dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                <th class="px-6 py-4 text-sm font-bold text-text-main dark:text-gray-300 uppercase tracking-wider">Deskripsi</th>
                <th class="px-6 py-4 text-sm font-bold text-text-main dark:text-gray-300 uppercase tracking-wider">Detail</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            @forelse($logs as $log)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40 transition-colors">
                <td class="px-6 py-4">
                    <span class="text-sm font-medium text-text-main dark:text-gray-200 block">
                        {{ $log->created_at->format('d M Y') }}
                    </span>
                    <span class="text-xs text-text-muted dark:text-gray-500">
                        {{ $log->created_at->format('H:i:s') }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                            {{ strtoupper(substr($log->user->name ?? '?', 0, 1)) }}
                        </div>
                        <span class="text-sm font-medium text-text-main dark:text-gray-200">{{ $log->user->name ?? 'System' }}</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    @php
                        $color = [
                            'created' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                            'updated' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                            'deleted' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                        ][$log->action] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase {{ $color }}">
                        {{ $log->action }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-sm text-text-main dark:text-gray-300">{{ $log->description }}</span>
                </td>
                <td class="px-6 py-4">
                    @if($log->details)
                        <div class="text-xs text-text-muted dark:text-gray-500 max-w-xs truncate" title="{{ json_encode($log->details) }}">
                            @foreach($log->details as $key => $value)
                                <div class="truncate">
                                    <span class="font-bold">{{ $key }}:</span> 
                                    <span class="italic text-primary dark:text-primary-dark">
                                        {{ is_array($value) ? json_encode($value) : $value }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <span class="text-xs text-text-muted italic">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-text-muted dark:text-gray-500">
                    <span class="material-symbols-outlined text-4xl block mb-2">history</span>
                    Belum ada riwayat aktivitas.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($logs->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/30">
        {{ $logs->links() }}
    </div>
@endif
