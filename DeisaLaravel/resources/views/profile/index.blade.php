@extends('layouts.admin')

@section('title', 'Pengaturan & Personalisasi')

@section('admin-content')
    <div class="max-w-4xl">
        @include('profile.partials.form')
    </div>
@endsection

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.dashboard') }}"
            class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition-all">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-900">Pengaturan & Personalisasi</h2>
            <p class="text-sm text-slate-500">Kelola data user, personalisasi aplikasi, dan pengaturan akun</p>
        </div>
    </div>
@endsection
