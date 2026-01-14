<div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <!-- Tabs Header -->
        <div class="border-b border-slate-100 dark:border-slate-700">
            <div class="flex overflow-x-auto">
                <button wire:click="setTab('kelas')" class="px-6 py-4 text-sm font-medium border-b-2 transition-colors whitespace-nowrap {{ $activeTab === 'kelas' ? 'border-blue-600 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                    Data Kelas
                </button>
                <button wire:click="setTab('jurusan')" class="px-6 py-4 text-sm font-medium border-b-2 transition-colors whitespace-nowrap {{ $activeTab === 'jurusan' ? 'border-blue-600 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                    Data Jurusan
                </button>
                <button wire:click="setTab('diagnosis')" class="px-6 py-4 text-sm font-medium border-b-2 transition-colors whitespace-nowrap {{ $activeTab === 'diagnosis' ? 'border-blue-600 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                    Data Diagnosis
                </button>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div class="relative w-full sm:w-72">
                 <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                </span>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search {{ $activeTab }}..." class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>

            <div>
                @if($activeTab === 'kelas')
                    <a href="{{ route('web.kelas.create') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">add</span> Add Kelas
                    </a>
                @elseif($activeTab === 'jurusan')
                    <a href="{{ route('web.jurusan.create') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">add</span> Add Jurusan
                    </a>
                @elseif($activeTab === 'diagnosis')
                    <a href="{{ route('web.diagnosis.create') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">add</span> Add Diagnosis
                    </a>
                @endif
            </div>
        </div>

        <!-- Content Tables -->
        <div class="overflow-x-auto min-h-[300px]">
            <div wire:loading.flex class="absolute inset-0 bg-white/50 backdrop-blur-sm z-10 flex items-center justify-center">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            </div>

            <table class="w-full text-left text-sm text-slate-600 dark:text-slate-400">
                <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 uppercase text-xs font-semibold tracking-wider">
                    <tr>
                        <th class="px-6 py-4 w-16">#</th>
                        @if($activeTab === 'kelas')
                            <th class="px-6 py-4">Nama Kelas</th>
                        @elseif($activeTab === 'jurusan')
                            <th class="px-6 py-4">Kode</th>
                            <th class="px-6 py-4">Nama Jurusan</th>
                        @elseif($activeTab === 'diagnosis')
                            <th class="px-6 py-4">Nama Diagnosis</th>
                            <th class="px-6 py-4">Kategori</th>
                        @endif
                        <th class="px-6 py-4 text-center w-24">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700 relative">
                    @forelse($items as $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4 text-slate-500">{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                            
                            @if($activeTab === 'kelas')
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $item->nama_kelas }}</td>
                            @elseif($activeTab === 'jurusan')
                                <td class="px-6 py-4 font-mono text-xs font-medium text-blue-600">{{ $item->kode_jurusan }}</td>
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $item->nama_jurusan }}</td>
                            @elseif($activeTab === 'diagnosis')
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $item->nama_diagnosis }}</td>
                                <td class="px-6 py-4">
                                     @if($item->kategori == 'Ringan')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-lg text-xs font-medium">Ringan</span>
                                    @elseif($item->kategori == 'Sedang')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-lg text-xs font-medium">Sedang</span>
                                    @elseif($item->kategori == 'Berat')
                                        <span class="px-2 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-lg text-xs font-medium">Berat</span>
                                    @endif
                                </td>
                            @endif

                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @php
                                        $editRoute = match($activeTab) {
                                            'kelas' => 'web.kelas.edit',
                                            'jurusan' => 'web.jurusan.edit',
                                            'diagnosis' => 'web.diagnosis.edit',
                                        };
                                        $deleteMethod = match($activeTab) {
                                            'kelas' => 'deleteKelas',
                                            'jurusan' => 'deleteJurusan',
                                            'diagnosis' => 'deleteDiagnosis',
                                        };
                                    @endphp
                                    
                                    <a href="{{ route($editRoute, $item->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>
                                    
                                    <button wire:click="{{ $deleteMethod }}({{ $item->id }})" wire:confirm="Are you sure?" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $activeTab === 'jurusan' ? 4 : 3 }}" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="material-symbols-outlined text-4xl text-slate-300">folder_off</span>
                                    <p>No {{ $activeTab }} data found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-100 dark:border-slate-700">
            {{ $items->links() }}
        </div>
    </div>
</div>
