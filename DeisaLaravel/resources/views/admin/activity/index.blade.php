@extends(auth()->user()->role == 'admin' ? 'layouts.admin' : 'layouts.app')

@section('title', 'Ringkasan Input Data')

@section('header')
    <h2 class="text-xl font-bold text-slate-900">Ringkasan Input</h2>
    <p class="text-sm text-slate-500 hidden sm:block">Lacak aktivitas data yang telah Anda masukkan.</p>
@endsection

@php $mainSection = auth()->user()->role == 'admin' ? 'admin-content' : 'content'; @endphp

@section($mainSection)
    <div class="{{ auth()->user()->role == 'admin' ? '' : 'max-w-7xl mx-auto px-6 pt-10 pb-24' }}">
        @if(auth()->user()->role !== 'admin')
            <div class="mb-8">
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Riwayat Aktivitas</h1>
                <p class="text-slate-500">Ringkasan semua data yang Anda input ke dalam sistem.</p>
            </div>
        @endif

        <!-- Summary Grid (Nice Stats) -->
        <div class="grid grid-cols-2 lg:grid-cols-6 gap-4 mb-8">
            <div class="bg-gradient-to-br from-deisa-blue to-indigo-600 p-4 rounded-3xl text-white shadow-lg shadow-blue-500/20">
                <div class="text-[10px] font-bold uppercase tracking-wider opacity-80 mb-1">Total Input</div>
                <div class="text-2xl font-black">{{ $summary['total'] }}</div>
            </div>
            <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Hari Ini</div>
                <div class="text-2xl font-black text-slate-800">{{ $summary['today'] }}</div>
            </div>
            <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Akademik</div>
                <div class="text-2xl font-black text-purple-600">{{ $summary['akademik'] }}</div>
            </div>
            <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Santri</div>
                <div class="text-2xl font-black text-indigo-500">{{ $summary['santri'] ?? 0 }}</div>
            </div>
            <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Sakit</div>
                <div class="text-2xl font-black text-red-500">{{ $summary['sakit'] }}</div>
            </div>
            <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Obat</div>
                <div class="text-2xl font-black text-emerald-500">{{ $summary['obat'] }}</div>
            </div>
        </div>

        <x-card class="rounded-3xl border-0 shadow-xl shadow-slate-200/50">
            <!-- Toolbar -->
            <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                <form action="{{ request()->url() }}" method="GET" class="flex flex-wrap gap-3 flex-1">
                    <input type="text" name="action" value="{{ request('action') }}" placeholder="Cari aktivitas..."
                        data-realtime-search="true" data-search-target="#table-container"
                        class="px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue bg-white text-sm flex-1 md:flex-none md:w-64">

                    @if(auth()->user()->role == 'admin')
                    <select name="user_id" data-realtime-filter="true" data-search-target="#table-container"
                        class="px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue bg-white text-sm">
                        <option value="">Semua User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @endif
                    
                    <input type="date" name="date" value="{{ request('date') }}" data-realtime-filter="true" data-search-target="#table-container"
                        class="px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue bg-white text-sm">
                    
                    <x-button type="submit" variant="primary" class="rounded-xl">Filter</x-button>
                </form>
            </div>

            <!-- Table Container -->
            <div id="table-container" class="overflow-hidden rounded-2xl border border-slate-100">
                @include('admin.activity._table')
            </div>
        </x-card>
    </div>
@endsection