<div class="space-y-10 animate-fade-in">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach([
            ['label' => 'Santri Database', 'value' => $summary['total_santri'], 'icon' => 'santri', 'color' => 'blue'],
            ['label' => 'Active Medical Cases', 'value' => $summary['total_sakit'], 'icon' => 'sakit', 'color' => 'rose'],
            ['label' => 'Recovery Protocol', 'value' => $summary['total_sembuh'], 'icon' => 'check', 'color' => 'emerald'],
            ['label' => 'Asset Optimization', 'value' => $summary['low_stock_obat'], 'icon' => 'obat', 'color' => 'amber'],
        ] as $stat)
            <div class="glass-premium rounded-[2.5rem] p-8 border border-white/40 shadow-xl shadow-slate-200/20 group hover:-translate-y-2 transition-all duration-500">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-{{ $stat['color'] }}-50 flex items-center justify-center text-{{ $stat['color'] }}-500 transition-transform group-hover:scale-110 group-hover:rotate-6">
                        @if($stat['icon'] == 'santri')
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        @elseif($stat['icon'] == 'sakit')
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                        @elseif($stat['icon'] == 'check')
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        @else
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86 .517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 01-.586 1.414l-2.828 2.828a2 2 0 01-1.414.586H8.586a2 2 0 01-1.414-.586L4.344 11.586A2 2 0 013.758 10.172V5L2 4h16" /></svg>
                        @endif
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-1">{{ $stat['label'] }}</p>
                <h3 class="text-3xl font-black text-slate-900 tracking-tighter">{{ number_format($stat['value']) }}</h3>
            </div>
        @endforeach
    </div>

    <!-- Charts Section (Bento Grid) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Monthly Trend -->
        <div class="lg:col-span-2 glass-premium rounded-[3rem] p-10 border border-white/40 shadow-2xl shadow-slate-200/20 animate-border-glow">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Health Intelligence Trend</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">6-Month Temporal Data</p>
                </div>
                <div class="px-4 py-2 rounded-xl bg-emerald-50 text-emerald-600 font-black text-[10px] uppercase tracking-widest border border-emerald-100">Live Analytics</div>
            </div>
            <div class="h-80 w-full" id="monthlyTrendChartContainer">
                <canvas id="monthlyTrendChart"></canvas>
            </div>
        </div>

        <!-- Top Diagnoses -->
        <div class="glass-premium bg-slate-900 rounded-[3rem] p-10 shadow-2xl shadow-slate-900/40 relative overflow-hidden group border border-slate-800">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-emerald-500/20 rounded-full blur-3xl group-hover:bg-emerald-500/30 transition-all duration-700"></div>
            
            <h3 class="text-2xl font-black text-white tracking-tight relative z-10">Pathology Radar</h3>
            <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mt-1 relative z-10 mb-10">High Frequency Diagnostics</p>
            
            <div class="space-y-8 relative z-10">
                @foreach($topDiagnoses as $diagnosis)
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-400 uppercase tracking-widest">{{ $diagnosis->nama_diagnosis }}</span>
                            <span class="font-black text-white bg-white/5 px-2 py-1 rounded-md">{{ $diagnosis->count }} Cases</span>
                        </div>
                        <div class="h-2 w-full bg-white/10 rounded-full overflow-hidden border border-white/5">
                            @php 
                                $maxCount = collect($topDiagnoses)->max('count') ?: 1;
                                $percentage = ($diagnosis->count / $maxCount) * 100;
                            @endphp
                            <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full transition-all duration-1000 ease-out" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 pt-10 border-t border-white/5 relative z-10">
                <button class="w-full py-5 rounded-2xl bg-white/5 text-[10px] font-black uppercase tracking-widest text-white hover:bg-white/10 transition-all border border-white/5">Export Intelligence Report</button>
            </div>
        </div>
    </div>

    <!-- Chart Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const ctx = document.getElementById('monthlyTrendChart').getContext('2d');
            
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(16, 185, 129, 0.15)');
            gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @js(collect($monthlyTrend)->pluck('month')),
                    datasets: [{
                        label: 'Incidents Captured',
                        data: @js(collect($monthlyTrend)->pluck('count')),
                        borderColor: '#10b981',
                        borderWidth: 5,
                        tension: 0.45,
                        fill: true,
                        backgroundColor: gradient,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 4,
                        pointRadius: 0,
                        pointHoverRadius: 10,
                        pointHoverBackgroundColor: '#10b981',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { size: 10, weight: '900', family: 'Outfit' },
                            bodyFont: { size: 14, weight: '900', family: 'Outfit' },
                            padding: 20,
                            borderRadius: 16,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(226, 232, 240, 0.4)', drawBorder: false },
                            ticks: { font: { weight: 'bold', family: 'Inter', size: 11 }, color: '#94a3b8', padding: 10 }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { weight: 'bold', family: 'Inter', size: 11 }, color: '#94a3b8', padding: 10 }
                        }
                    }
                }
            });
        });
    </script>
</div>
