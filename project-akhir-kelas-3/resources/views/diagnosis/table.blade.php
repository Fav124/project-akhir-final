<div class="overflow-x-auto">
    <table class="w-full text-left">
        <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-800">
            <tr>
                <th class="px-6 py-4 text-sm font-semibold text-text-main dark:text-gray-300">Nama Diagnosis</th>
                <th class="px-6 py-4 text-sm font-semibold text-text-main dark:text-gray-300">Jumlah Kasus</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-text-main dark:text-gray-300">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            @forelse ($diagnoses as $d)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                    <td class="px-6 py-4 text-text-main dark:text-gray-300 font-medium">
                        {{ $d->nama }}
                    </td>
                    <td class="px-6 py-4 text-text-muted dark:text-gray-400">
                        <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded text-xs">
                            {{ $d->sakit_santris_count ?? $d->sakitSantris()->count() }} kasus
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="openModal({{ $d->id }}, '{{ $d->nama }}')" 
                                    class="p-2 text-amber-600 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-900/30 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-lg">edit</span>
                            </button>
                            <button onclick="deleteDiagnosis({{ $d->id }})" 
                                    class="p-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-lg">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-text-muted dark:text-gray-400">
                        <span class="material-symbols-outlined text-4xl block mb-2 text-gray-300 dark:text-gray-600">sentiment_dissatisfied</span>
                        Belum ada data diagnosis.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($diagnoses->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50">
        {{ $diagnoses->links() }}
    </div>
@endif
