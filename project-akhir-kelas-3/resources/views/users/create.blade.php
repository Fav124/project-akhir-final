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
                        <span class="text-sm font-medium text-text-main dark:text-gray-200">Tambah User</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-3xl font-bold text-text-main dark:text-white">Tambah User Baru</h1>
        <p class="text-text-muted dark:text-gray-400 mt-1">Tambahkan pengguna aplikasi dengan role yang sesuai.</p>
    </div>

    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-6">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('name') border-red-500 @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required placeholder="Contoh: Admin Utama">
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('email') border-red-500 @enderror" 
                           id="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com">
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Password <span class="text-red-500">*</span></label>
                    <input type="password" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('password') border-red-500 @enderror" 
                           id="password" name="password" required placeholder="********">
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" 
                           id="password_confirmation" name="password_confirmation" required placeholder="********">
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Role <span class="text-red-500">*</span></label>
                    <div class="relative">
                         <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary appearance-none @error('role') border-red-500 @enderror" 
                             id="role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-text-muted">
                            <span class="material-symbols-outlined text-lg">expand_more</span>
                        </div>
                    </div>
                    @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                     <p class="text-xs text-text-muted mt-1">Admin: Full Akses | User: Kelola Santri Sakit & Obat</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">No. Telepon</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('phone') border-red-500 @enderror" 
                           id="phone" name="phone" value="{{ old('phone') }}" placeholder="08123456789">
                    @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Foto Profil</label>
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
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
