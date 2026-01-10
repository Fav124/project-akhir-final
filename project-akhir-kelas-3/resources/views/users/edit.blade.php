@extends('layouts.master')
@section('content')
<div class="space-y-6">
    <!-- PAGE HEADER -->
    <div>
        <nav class="flex mb-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white">
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-text-muted text-lg mx-1">chevron_right</span>
                        <a href="{{ route('users.index') }}" class="text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white">Data User</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-text-muted text-lg mx-1">chevron_right</span>
                        <span class="text-sm font-medium text-text-main dark:text-gray-200">Edit User</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-3xl font-bold text-text-main dark:text-white">Edit User</h1>
        <p class="text-text-muted dark:text-gray-400 mt-1">Perbarui informasi pengguna.</p>
    </div>

    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-6">
        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('name') border-red-500 @enderror" 
                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('email') border-red-500 @enderror" 
                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Password Baru</label>
                    <input type="password" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('password') border-red-500 @enderror" 
                           id="password" name="password" placeholder="********">
                     <p class="text-xs text-text-muted mt-1">Kosongkan jika tidak ingin mengubah password</p>
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Konfirmasi Password</label>
                    <input type="password" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" 
                           id="password_confirmation" name="password_confirmation" placeholder="********">
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Role <span class="text-red-500">*</span></label>
                    <div class="relative">
                         <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary appearance-none @error('role') border-red-500 @enderror" 
                             id="role" name="role" required>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-text-muted">
                            <span class="material-symbols-outlined text-lg">expand_more</span>
                        </div>
                    </div>
                    @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">No. Telepon</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('phone') border-red-500 @enderror" 
                           id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08123456789">
                    @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Status Akun</label>                    
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="active" value="1" class="sr-only peer" {{ old('active', $user->active) ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/30 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                        <span class="ms-3 text-sm font-medium text-text-main dark:text-gray-300">Aktif</span>
                    </label>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Foto Profil</label>
                    @if($user->foto)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Current foto" class="rounded-lg h-24 w-24 object-cover border border-gray-200">
                    </div>
                    @endif

                    <div class="flex items-center justify-center w-full">
                        <label for="foto" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <span class="material-symbols-outlined text-3xl text-gray-400 mb-2">cloud_upload</span>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">JPG, PNG (MAX. 2MB)</p>
                            </div>
                            <input id="foto" name="foto" type="file" class="hidden" accept="image/*" />
                        </label>
                    </div> 
                    @error('foto')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-text-main dark:text-white font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
