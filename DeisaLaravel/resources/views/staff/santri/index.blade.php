@extends('layouts.app')

@section('title', 'Data Santri')

@section('content')
    <div class="min-h-screen bg-white py-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-8">
                <h1 class="text-2xl font-black text-slate-800 ">Data Santri</h1>
                <p class="text-sm text-slate-500 ">Daftar seluruh santri</p>
            </div>

            <!-- Search -->
            <div
                class="bg-white  rounded-2xl border border-slate-100  p-6 mb-6 ">
                <form method="GET" action="{{ route('staff.santri.index') }}" class="flex gap-4">
                    <input type="text" name="search" placeholder="Cari nama atau NIS..." value="{{ request('search') }}"
                        class="flex-1 px-4 py-3 rounded-xl border border-slate-200  bg-white  text-slate-800  focus:ring-2 focus:ring-deisa-blue focus:border-transparent transition-colors">
                    <button type="submit"
                        class="px-6 py-3 bg-deisa-blue hover:bg-blue-700 text-white rounded-xl font-bold transition-colors">
                        Cari
                    </button>
                </form>
            </div>

            <div
                class="bg-white  rounded-2xl border border-slate-100  overflow-hidden ">
                <table class="w-full">
                    <thead class="bg-slate-50 ">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500  uppercase">
                                NIS</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500  uppercase">
                                Nama Lengkap</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500  uppercase">
                                Kelas</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500  uppercase">
                                Jenis Kelamin</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500  uppercase">
                                Alamat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($santri as $item)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-bold text-slate-800 ">{{ $item->nis }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-slate-800 ">
                                    {{ $item->nama_lengkap }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 ">
                                    {{ $item->kelas->nama_kelas ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 ">{{ $item->jenis_kelamin }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 ">
                                    {{ Str::limit($item->alamat, 50) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400 ">
                                    Tidak ada data santri
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $santri->links() }}
            </div>
        </div>
    </div>
@endsection