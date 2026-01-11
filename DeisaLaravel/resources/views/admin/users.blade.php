@extends('layouts.app-tailwind')

@section('page_title', 'Kelola Pengguna')
@section('page_subtitle', 'Daftar Pengguna Terotorisasi')

@section('content')
<div class="space-y-6">
    <!-- Action Bar -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Kontrol Akses</h3>
                <p class="text-sm text-gray-500">Daftar Personil Administratif</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-gray-100 border border-gray-200 rounded-lg text-sm font-medium text-gray-700">
                {{ $users->total() }} Total Pengguna
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-sm font-semibold text-gray-700">Profil Pengguna</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-700">Jabatan</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-700">Tanggal Aktivasi</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-700 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-medium">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900 capitalize">{{ $user->name }}</h4>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium {{ $user->role === 'admin' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $user->role ?? 'Petugas' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $user->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('web.admin.user.destroy', $user->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg border border-red-200 transition-colors" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini secara permanen?')">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="px-3 py-1 text-xs font-medium text-emerald-600 bg-emerald-50 rounded-lg border border-emerald-200">Akun Utama</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
