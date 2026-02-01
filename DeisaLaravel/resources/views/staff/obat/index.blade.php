@extends('layouts.app')

@section('title', 'Kelola Obat')

@section('content')
    <div class="min-h-screen bg-white py-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-black text-slate-800 ">Kelola Obat</h1>
                    <p class="text-sm text-slate-500 ">Manajemen data obat dan stok</p>
                </div>
                <a href="{{ route('staff.obat.create') }}"
                    class="px-4 py-2 bg-deisa-blue hover:bg-blue-700 text-white rounded-xl font-bold transition-colors">
                    + Tambah Obat
                </a>
            </div>

            @if(session('success'))
                <div
                    class="bg-emerald-50  border border-emerald-200  text-emerald-700  px-4 py-3 rounded-xl mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div
                class="bg-white  rounded-2xl border border-slate-100  overflow-hidden ">
                <table class="w-full">
                    <thead class="bg-slate-50 ">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500  uppercase">
                                Nama Obat</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500  uppercase">
                                Jenis</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500  uppercase">
                                Stok</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500  uppercase">
                                Satuan</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500  uppercase">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($obat as $item)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-bold text-slate-800 ">
                                    {{ $item->nama_obat }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 ">{{ $item->jenis }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 rounded-lg text-xs font-bold {{ $item->stok < 10 ? 'bg-rose-100  text-rose-700  : 'bg-emerald-100  text-emerald-700  }}">
                                        {{ $item->stok }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 ">{{ $item->satuan }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('staff.obat.edit', $item->id) }}"
                                            class="px-3 py-1 bg-blue-50  text-deisa-blue  rounded-lg text-xs font-bold hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('staff.obat.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus obat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 bg-rose-50  text-rose-600  rounded-lg text-xs font-bold hover:bg-rose-100 dark:hover:bg-rose-900/50 transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400 ">
                                    Belum ada data obat
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $obat->links() }}
            </div>
        </div>
    </div>
@endsection