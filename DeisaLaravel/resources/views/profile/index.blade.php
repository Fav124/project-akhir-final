@extends(auth()->user()->role == 'admin' ? 'layouts.admin' : 'layouts.app')

@section('title', 'Profil Saya')

@section('content')
    @if(auth()->user()->role != 'admin')
        <div class="bg-slate-50 min-h-screen pb-24">
            <header class="bg-deisa-blue px-6 pt-8 pb-20 rounded-b-[2.5rem] relative overflow-hidden">
                <h2 class="text-xl font-bold text-white relative z-10">Profil Saya</h2>
            </header>

            <div class="px-6 -mt-12 relative z-10">
                @include('profile.partials.form')
            </div>

            <!-- Bottom Nav -->
            <nav
                class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 pb-safe pt-3 px-6 flex justify-between z-50">
                <a href="{{ route('user.dashboard') }}" class="flex flex-col items-center gap-1 text-slate-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="text-[10px] font-medium">Home</span>
                </a>
                <a href="{{ route('profile.index') }}" class="flex flex-col items-center gap-1 text-deisa-blue">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-[10px] font-medium">Profil</span>
                </a>
            </nav>
        </div>
    @else
        <div class="max-w-4xl mx-auto">
            @include('profile.partials.form')
        </div>
    @endif
@endsection

@if(auth()->user()->role == 'admin')
    @section('admin-content')
        <div class="max-w-4xl">
            @include('profile.partials.form')
        </div>
    @endsection

    @section('header')
        <h2 class="text-xl font-bold text-slate-900">Profil Saya</h2>
        <p class="text-sm text-slate-500">Kelola informasi pribadi dan akun</p>
    @endsection
@endif