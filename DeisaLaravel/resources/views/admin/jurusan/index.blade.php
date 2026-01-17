@extends('layouts.admin')

@section('title', 'Manajemen Jurusan')

@section('header')
    <h2 class="text-xl font-bold text-slate-900">Manajemen Jurusan</h2>
    <p class="text-sm text-slate-500 hidden sm:block">Kelola program keahlian atau jurusan santri.</p>
@endsection

@section('admin-content')
    <x-card>
        <!-- Toolbar -->
        <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
            <form action="{{ route('admin.jurusan.index') }}" method="GET" class="flex gap-3 flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama atau kode jurusan..." data-realtime-search="true"
                    data-search-target="#table-container"
                    class="w-full max-w-xs px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
            </form>
            <div class="flex gap-3">
                <x-button class="whitespace-nowrap" data-form-url="{{ route('admin.jurusan.create') }}">
                    + Tambah Jurusan
                </x-button>
            </div>
        </div>

        <!-- Table Container -->
        <div id="table-container" class="overflow-x-auto">
            @include('admin.jurusan._table')
        </div>
    </x-card>
@endsection