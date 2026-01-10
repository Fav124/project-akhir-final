@extends('layouts.master')

@section('content')
    <div class="space-y-6">
        <!-- PAGE HEADER -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-text-main dark:text-white">Data Kelas</h1>
                <p class="text-text-muted dark:text-gray-400 mt-1">Kelola data kelas dengan baik</p>
            </div>
            <a href="{{ route('kelas.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-green-600 text-text-main font-medium rounded-lg transition-colors w-fit">
                <span class="material-symbols-outlined text-xl">add_circle</span>
                <span>Tambah Kelas</span>
            </a>
        </div>

        @if ($message = Session::get('success'))
            <div
                class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg flex items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span>{{ $message }}</span>
                </div>
                <button onclick="this.parentElement.style.display='none'"
                    class="text-green-700 dark:text-green-300 hover:text-green-900 dark:hover:text-green-100">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
        @endif

        <!-- DATA TABLE -->
        @if ($kelas->count() > 0)
            <div
                class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-text-main dark:text-gray-300">No
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-text-main dark:text-gray-300">Nama
                                    Kelas</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-text-main dark:text-gray-300">Jurusan</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-text-main dark:text-gray-300">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                            @foreach ($kelas as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-semibold text-text-main dark:text-gray-300">
                                        {{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm text-text-main dark:text-gray-300 font-medium">
                                        {{ $item->nama_kelas }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1.5">
                                            @forelse($item->jurusans as $j)
                                                <span class="px-2.5 py-1 text-xs font-bold bg-primary/10 text-primary border border-primary/20 rounded-full">
                                                    {{ $j->nama }}
                                                </span>
                                            @empty
                                                <span class="text-xs text-text-muted italic">Tidak ada jurusan</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('kelas.edit', $item->id) }}"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-100 dark:hover:bg-yellow-900/40 transition-colors">
                                                <span class="material-symbols-outlined text-lg">edit</span>
                                            </a>
                                            <form action="{{ route('kelas.destroy', $item->id) }}" method="POST"
                                                class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">
                                                    <span class="material-symbols-outlined text-lg">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <x-empty-state title="Belum ada data kelas"
                message="Mulai dengan menambahkan kelas baru untuk mengorganisir santri Anda." action="Tambah Kelas Pertama"
                actionRoute="kelas.create" />
        @endif
    </div>
@endsection
