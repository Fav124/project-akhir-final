@extends('layouts.admin')

@section('title', 'Monitoring Santri Pulang')

@section('header')
    <h2 class="text-xl font-bold text-slate-900">Monitoring Santri Pulang</h2>
    <p class="text-sm text-slate-500">Pantau waktu pulang, kembali, dan alasan kepulangan santri.</p>
@endsection

@section('admin-content')
    <div class="space-y-6">
        <x-card>
            <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                <form action="{{ route('admin.sakit.pulang') }}" method="GET" class="flex flex-wrap gap-3 flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIS..."
                        data-realtime-search="true" data-search-target="#table-container"
                        class="px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue bg-white text-sm w-full max-w-xs">

                    <select name="monitor_status" data-realtime-filter="true"
                        class="px-4 py-2 rounded-lg border border-slate-300 bg-white text-sm outline-none">
                        <option value="">Semua Kondisi</option>
                        <option value="pulang" {{ request('monitor_status') == 'pulang' ? 'selected' : '' }}>Masih Pulang
                        </option>
                        <option value="kembali" {{ request('monitor_status') == 'kembali' ? 'selected' : '' }}>Sudah Kembali
                        </option>
                        <option value="sembuh" {{ request('monitor_status') == 'sembuh' ? 'selected' : '' }}>Sudah Sembuh
                        </option>
                    </select>
                </form>

                <div class="flex gap-3">
                    <x-button variant="outline" href="{{ route('admin.sakit.index') }}">
                        Lihat Riwayat Sakit
                    </x-button>
                </div>
            </div>

            <div id="table-container">
                @include('admin.sakit._pulang_table')
            </div>
        </x-card>
    </div>
@endsection

