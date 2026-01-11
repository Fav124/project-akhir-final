<div class="space-y-6">
    <!-- Header/Actions -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex-1 max-w-md relative">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama atau email user..." 
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none text-sm bg-white shadow-sm">
            <div class="absolute left-3 top-3 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Alert -->
    @if (session()->has('success'))
        <div class="animate-slide-in-down mb-4">
            <x-alert type="success" title="Berhasil!" :message="session('success')" />
        </div>
    @endif
    @if (session()->has('error'))
        <div class="animate-slide-in-down mb-4">
            <x-alert type="error" title="Gagal!" :message="session('error')" />
        </div>
    @endif

    <!-- Table -->
    <x-card variant="default" class="overflow-hidden border-none shadow-xl ring-1 ring-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">User Petugas</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Role & Status</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Terdaftar</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-indigo-50/30 transition-all duration-200 group animate-fade-in">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center text-indigo-600 font-black shadow-inner">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-black text-gray-800 tracking-tight">{{ $user->name }}</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $user->role }}
                                    </span>
                                    <span class="w-1.5 h-1.5 rounded-full {{ $user->status === 'active' ? 'bg-emerald-500 shadow-sm shadow-emerald-200' : 'bg-gray-300' }}"></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 font-bold uppercase tracking-widest">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($user->id !== auth()->id())
                                    <button wire:click="deleteUser({{ $user->id }})" wire:confirm="Hapus user ini?" class="p-2 bg-red-50 text-red-500 rounded-xl hover:bg-red-100 transition-colors scale-90 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                @else
                                    <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest italic">Anda</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-400 italic">
                                Tidak ada data user ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-6 py-4 bg-gray-50/30 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        @endif
    </x-card>
</div>
