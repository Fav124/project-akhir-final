<div class="space-y-6">
    <!-- Header/Actions -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex-1 max-w-md relative">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama kelas..." 
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none text-sm bg-white shadow-sm">
            <div class="absolute left-3 top-3 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <select wire:model.live="jurusanFilter" class="px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 transition-all outline-none text-sm bg-white shadow-sm">
                <option value="">Semua Jurusan</option>
                @foreach($jurusans as $j)
                    <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                @endforeach
            </select>

            <a href="{{ route('web.kelas.create') }}" class="inline-flex items-center px-5 py-2.5 rounded-xl font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kelas
            </a>
        </div>
    </div>

    <!-- Alert -->
    @if (session()->has('success'))
        <div class="animate-slide-in-down mb-4">
            <x-alert type="success" title="Berhasil!" :message="session('success')" />
        </div>
    @endif

    <!-- Table -->
    <x-card variant="default" class="overflow-hidden border-none shadow-xl ring-1 ring-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Nama Kelas</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Jurusan</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Tahun Ajaran</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($kelas as $k)
                        <tr class="hover:bg-blue-50/30 transition-all duration-200 group animate-fade-in">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-gray-800">{{ $k->nama_kelas }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-black text-blue-600 bg-blue-50 px-2 py-1 rounded-lg uppercase">{{ $k->jurusan->kode_jurusan ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-gray-500 font-bold uppercase tracking-widest">{{ $k->tahun_ajaran }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2 scale-90 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <a href="{{ route('web.kelas.edit', $k) }}" class="p-2 rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <button wire:click="deleteKelas({{ $k->id }})" wire:confirm="Hapus kelas ini?" class="p-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition-colors shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-400 italic">
                                Tidak ada data kelas ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kelas->hasPages())
            <div class="px-6 py-4 bg-gray-50/30 border-t border-gray-100">
                {{ $kelas->links() }}
            </div>
        @endif
    </x-card>
</div>
