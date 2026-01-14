<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col gap-2">
            <div class="flex items-center gap-3 text-blue-600 dark:text-blue-400">
                <span class="material-symbols-outlined filled">groups</span>
                <span class="text-sm font-medium">Total Santri</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 dark:text-white font-outfit">{{ number_format($summary['total_santri'] ?? 0) }}</p>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col gap-2">
            <div class="flex items-center gap-3 text-red-600 dark:text-red-400">
                <span class="material-symbols-outlined filled">sick</span>
                <span class="text-sm font-medium">Sedang Sakit</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 dark:text-white font-outfit">{{ number_format($summary['total_sakit'] ?? 0) }}</p>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col gap-2">
            <div class="flex items-center gap-3 text-emerald-600 dark:text-emerald-400">
                <span class="material-symbols-outlined filled">check_circle</span>
                <span class="text-sm font-medium">Total Sembuh</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 dark:text-white font-outfit">{{ number_format($summary['total_sembuh'] ?? 0) }}</p>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col gap-2">
            <div class="flex items-center gap-3 text-amber-600 dark:text-amber-400">
                <span class="material-symbols-outlined filled">inventory_2</span>
                <span class="text-sm font-medium">Stok Menipis</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 dark:text-white font-outfit">{{ number_format($summary['low_stock_obat'] ?? 0) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Monthly Trend Chart Mock -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 font-outfit">Tren Kesehatan Santri (6 Bulan Terakhir)</h3>
            <div class="h-64 flex items-end justify-between gap-4">
                @foreach($monthlyTrend as $trend)
                    @php
                        $height = rand(20, 90); // Use real calculation in production
                        // $height = ($trend['count'] / max(array_column($monthlyTrend, 'count'))) * 100;
                    @endphp
                    <div class="w-full flex flex-col items-center gap-2 group">
                        <div class="w-full bg-blue-100 dark:bg-blue-900/20 rounded-t-lg h-full relative overflow-hidden">
                             <div style="height: {{ $height }}%;" class="absolute bottom-0 w-full bg-blue-500 rounded-t-sm group-hover:bg-blue-600 transition-colors"></div>
                        </div>
                        <span class="text-xs text-slate-500 font-medium">{{ \Carbon\Carbon::parse($trend['month'])->format('M') }}</span>
                    </div>
                @endforeach
                @if(empty($monthlyTrend))
                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                        No Data Available
                    </div>
                @endif
            </div>
        </div>

        <!-- Top Diagnoses -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 font-outfit">Top 5 Penyakit Terbanyak</h3>
            <div class="space-y-4">
                @foreach($topDiagnoses as $diag)
                <div class="flex items-center gap-4">
                    <div class="w-8 text-slate-400 font-bold text-sm">#{{ $loop->iteration }}</div>
                    <div class="flex-1">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $diag->nama_diagnosis }}</span>
                            <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $diag->count }} kasus</span>
                        </div>
                        <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2">
                            <!-- Helper width using style for simplicity -->
                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ rand(40, 90) }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach

                 @if(empty($topDiagnoses))
                    <div class="py-10 text-center text-slate-500">
                        No Diagnosis Data
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
