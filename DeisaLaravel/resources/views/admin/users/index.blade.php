@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('header')
    <h2 class="text-xl font-bold text-slate-900">Manajemen User</h2>
    <p class="text-sm text-slate-500">Kelola akses petugas dan administrator</p>
@endsection

@section('admin-content')
    <div class="space-y-6">
        <x-card>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-800">Daftar Pengguna</h3>
                <x-button onclick="document.getElementById('modal-add-user').classList.remove('hidden')">
                    + Tambah User Baru
                </x-button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-900 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Nama</th>
                            <th class="px-4 py-3 font-semibold">Email</th>
                            <th class="px-4 py-3 font-semibold">Role</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-deisa-blue font-bold">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <span class="font-medium text-slate-900">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-slate-500">{{ $user->email }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status == 'active' ? 'bg-emerald-100 text-emerald-800' : ($user->status == 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                                        {{ ucfirst($user->status ?: 'pending') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end gap-2">
                                        @if($user->status === 'pending')
                                            <form action="{{ route('admin.users.approve', $user->id) }}" method="POST"
                                                data-ajax="true" data-reload="true">
                                                @csrf
                                                <x-button variant="success" class="px-2 py-1 text-xs"
                                                    type="submit">Setujui</x-button>
                                            </form>
                                        @endif
                                        <x-button variant="outline" class="px-2 py-1 text-xs"
                                            onclick="openEditModal({{ json_encode($user) }})">Edit</x-button>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            data-ajax="true" data-reload="true">
                                            @csrf
                                            @method('DELETE')
                                            <x-button variant="danger" class="px-2 py-1 text-xs" type="submit"
                                                onclick="return confirm('Hapus user ini?')">Hapus</x-button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-slate-400 italic">Belum ada data user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </x-card>
    </div>

    <!-- Add Modal -->
    <div id="modal-add-user"
        class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-900">Tambah User Baru</h3>
                <button onclick="document.getElementById('modal-add-user').classList.add('hidden')"
                    class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-4" data-ajax="true"
                data-reload="true">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Role</label>
                    <select name="role" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                        <option value="user">User/Petugas</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                        placeholder="Minimal 8 karakter">
                </div>
                <div class="pt-4">
                    <x-button type="submit" class="w-full py-2.5">Simpan User</x-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal (Simplified) -->
    <div id="modal-edit-user"
        class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-900">Edit User</h3>
                <button onclick="document.getElementById('modal-edit-user').classList.add('hidden')"
                    class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form id="form-edit-user" method="POST" class="p-6 space-y-4" data-ajax="true" data-reload="true">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="edit-name" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" id="edit-email" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Role</label>
                    <select name="role" id="edit-role" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                        <option value="user">User/Petugas</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password Baru (Kosongkan jika tidak
                        diubah)</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                        placeholder="Minimal 8 karakter">
                </div>
                <div class="pt-4">
                    <x-button type="submit" class="w-full py-2.5">Simpan Perubahan</x-button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openEditModal(user) {
            document.getElementById('edit-name').value = user.name;
            document.getElementById('edit-email').value = user.email;
            document.getElementById('edit-role').value = user.role;
            document.getElementById('form-edit-user').action = `/admin/users/${user.id}`;
            document.getElementById('modal-edit-user').classList.remove('hidden');
        }
    </script>
@endpush