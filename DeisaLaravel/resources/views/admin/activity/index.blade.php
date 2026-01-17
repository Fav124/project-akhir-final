@extends('layouts.admin')

@section('title', 'Activity Log')

@section('header')
    <h2 class="text-xl font-bold text-slate-900">Activity Log</h2>
    <p class="text-sm text-slate-500 hidden sm:block">Riwayat aktivitas pengguna sistem</p>
@endsection

@section('admin-content')
    <x-card>
        <!-- Toolbar -->
        <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
            <form action="{{ route('admin.activity.index') }}" method="GET" class="flex flex-wrap gap-3 flex-1">
                <input type="text" name="action" value="{{ request('action') }}" placeholder="Cari aktivitas..."
                    data-realtime-search="true" data-search-target="#table-container"
                    class="px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue bg-white text-sm">

                <select name="user_id" data-realtime-filter="true"
                    class="px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue bg-white">
                    <option value="">Semua User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}
                        </option>
                    @endforeach
                </select>
                <input type="date" name="date" value="{{ request('date') }}" data-realtime-filter="true"
                    class="px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
            </form>
            <div>
                <x-button variant="warning">Purge Logs > 1 Year</x-button>
            </div>
        </div>

        <!-- Table Container -->
        <div id="table-container">
            @include('admin.activity._table')
        </div>
    </x-card>
@endsection