@extends('layouts.app-tailwind')

@section('title', 'Data Jurusan')
@section('subtitle', 'Manage academic majors')

@section('content')
<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="relative w-full sm:w-64">
             <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <span class="material-symbols-outlined text-[20px]">search</span>
            </span>
            <input type="text" placeholder="Search jurusan..." class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
        </div>
        
        <a href="{{ route('web.jurusan.create') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors shadow-lg shadow-blue-500/20">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Add New Jurusan
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600 dark:text-slate-400">
            <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 uppercase text-xs font-semibold tracking-wider">
                <tr>
                    <th class="px-6 py-4">#</th>
                    <th class="px-6 py-4">Kode Jurusan</th>
                    <th class="px-6 py-4">Nama Jurusan</th>
                    <th class="px-6 py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                 @forelse($jurusans as $item)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap font-mono text-xs font-medium text-blue-600 bg-blue-50 dark:bg-blue-900/10 rounded-lg inline-block my-2 mx-6 text-center w-16">{{ $item->kode_jurusan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800 dark:text-white">{{ $item->nama_jurusan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('web.jurusan.edit', $item->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors tooltip" title="Edit">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('web.jurusan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors tooltip" title="Delete">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center gap-2">
                                <span class="material-symbols-outlined text-4xl text-slate-300">folder_off</span>
                                <p>No data available yet</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($jurusans->hasPages())
        <div class="p-4 border-t border-slate-100 dark:border-slate-700">
            {{ $jurusans->links() }}
        </div>
    @endif
</div>
@endsection
