<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-300">
            <tr>
                <th class="px-6 py-4 font-bold rounded-tl-xl" scope="col">No</th>
                <th class="px-6 py-4 font-bold" scope="col">User</th>
                <th class="px-6 py-4 font-bold" scope="col">Role</th>
                <th class="px-6 py-4 font-bold" scope="col">Email</th>
                <th class="px-6 py-4 font-bold" scope="col">Status</th>
                <th class="px-6 py-4 font-bold rounded-tr-xl text-center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($users as $index => $user)
            <tr class="bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    {{ $users->firstItem() + $index }}
                </td>
                <td class="px-6 py-4 font-medium text-text-main dark:text-white flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-bold overflow-hidden">
                        @if($user->foto)
                            <img src="{{ Storage::url($user->foto) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            {{ substr($user->name, 0, 1) }}
                        @endif
                    </div>
                    {{ $user->name }}
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2 py-1 rounded {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="px-6 py-4">{{ $user->email }}</td>
                <td class="px-6 py-4">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer toggle-active" data-id="{{ $user->id }}" {{ $user->active ? 'checked' : '' }} {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('users.edit', $user->id) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg dark:text-amber-400 dark:hover:bg-amber-900/20 transition-colors" title="Edit">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </a>
                        
                        @if($user->id !== auth()->id())
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg dark:text-red-400 dark:hover:bg-red-900/20 transition-colors" title="Delete">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    Tidak ada data user ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="p-4 border-t border-gray-200 dark:border-gray-800">
    {{ $users->links('pagination::tailwind') }}
</div>
