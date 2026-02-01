@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    <div class="min-h-screen bg-slate-50  py-8 ">
        <div class="max-w-4xl mx-auto px-6">
            <div class="mb-8">
                <h1 class="text-2xl font-black text-slate-800 ">Generate Laporan PDF</h1>
                <p class="text-sm text-slate-500 ">Buat laporan berdasarkan periode dan jenis data</p>
            </div>

            <div
                class="bg-white  rounded-2xl border border-slate-100  p-8 ">
                <form action="{{ route('staff.laporan.generate') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700  mb-2">Jenis
                                Laporan</label>
                            <select name="type" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200  bg-white  text-slate-800  focus:ring-2 focus:ring-deisa-blue focus:border-transparent transition-colors">
                                <option value="summary">Ringkasan</option>
                                <option value="pasien">Data Pasien</option>
                                <option value="obat">Data Obat</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700  mb-2">Tanggal
                                    Mulai</label>
                                <input type="date" name="start_date" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200  bg-white  text-slate-800  focus:ring-2 focus:ring-deisa-blue focus:border-transparent transition-colors"
                                    value="{{ now()->startOfMonth()->format('Y-m-d') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700  mb-2">Tanggal
                                    Akhir</label>
                                <input type="date" name="end_date" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200  bg-white  text-slate-800  focus:ring-2 focus:ring-deisa-blue focus:border-transparent transition-colors"
                                    value="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full mt-8 px-6 py-3 bg-deisa-blue hover:bg-blue-700 text-white rounded-xl font-bold transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Download PDF
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection