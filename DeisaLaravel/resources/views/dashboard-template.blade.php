@extends('layouts.admin-template')

@section('title', 'Dashboard Overview')

@section('content')
<div class="max-w-7xl mx-auto flex flex-col gap-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Stat Card 1 -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-xl border border-border-light dark:border-border-dark shadow-soft flex flex-col gap-4">
            <div class="flex justify-between items-start">
                <div class="p-3 bg-primary/10 rounded-lg text-primary">
                    <span class="material-symbols-outlined filled">groups</span>
                </div>
                <span class="flex items-center gap-1 text-xs font-medium text-success bg-success/10 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    +2%
                </span>
            </div>
            <div>
                <h3 class="text-text-muted text-sm font-medium">Total Santri</h3>
                <p class="text-2xl font-bold text-text-main dark:text-white mt-1">{{ number_format($total_santri ?? 0) }}</p>
            </div>
        </div>
        <!-- Stat Card 2 (Alert) -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-xl border-l-4 border-l-danger border-y border-r border-gray-100 dark:border-gray-800 shadow-soft flex flex-col gap-4">
            <div class="flex justify-between items-start">
                <div class="p-3 bg-danger/10 rounded-lg text-danger">
                    <span class="material-symbols-outlined filled">sick</span>
                </div>
                <span class="flex items-center gap-1 text-xs font-medium text-danger bg-danger/10 px-2 py-1 rounded-full">
                    High
                </span>
            </div>
            <div>
                <h3 class="text-text-muted text-sm font-medium">Santri Sakit (Current)</h3>
                <p class="text-2xl font-bold text-danger mt-1">{{ number_format($santri_sakit ?? 0) }}</p>
            </div>
        </div>
        <!-- Stat Card 3 (Warning) -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-xl border-l-4 border-l-warning border-y border-r border-gray-100 dark:border-gray-800 shadow-soft flex flex-col gap-4">
            <div class="flex justify-between items-start">
                <div class="p-3 bg-warning/10 rounded-lg text-warning">
                    <span class="material-symbols-outlined filled">inventory_2</span>
                </div>
                <span class="flex items-center gap-1 text-xs font-medium text-warning bg-warning/10 px-2 py-1 rounded-full">
                    Action Needed
                </span>
            </div>
            <div>
                <h3 class="text-text-muted text-sm font-medium">Low Stock Medicines</h3>
                <p class="text-2xl font-bold text-text-main dark:text-white mt-1">{{ $low_stock ?? 0 }} <span class="text-base font-normal text-text-muted">Items</span></p>
            </div>
        </div>
        <!-- Stat Card 4 -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-xl border border-border-light dark:border-border-dark shadow-soft flex flex-col gap-4">
            <div class="flex justify-between items-start">
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-blue-600 dark:text-blue-400">
                    <span class="material-symbols-outlined filled">medication</span>
                </div>
                <span class="flex items-center gap-1 text-xs font-medium text-text-muted bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-full">
                    Active
                </span>
            </div>
            <div>
                <h3 class="text-text-muted text-sm font-medium">Total Obat</h3>
                <p class="text-2xl font-bold text-text-main dark:text-white mt-1">{{ number_format($total_obat ?? 0) }}</p>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Line Chart -->
        <div class="lg:col-span-2 bg-white dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-card p-6 flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white">Health Trends</h3>
                    <p class="text-sm text-text-muted">Sick cases over the last 30 days</p>
                </div>
                <!-- Dropdown replaced with static button for now -->
                <button class="text-sm font-medium text-primary hover:text-primary-dark border border-border-light dark:border-border-dark rounded-lg px-3 py-1.5 flex items-center gap-2">
                    Last 30 Days <span class="material-symbols-outlined text-[16px]">expand_more</span>
                </button>
            </div>
            <!-- Custom Chart Visualization -->
            <div class="flex-1 min-h-[250px] w-full relative group">
                <!-- Grid Lines -->
                <div class="absolute inset-0 flex flex-col justify-between text-xs text-text-muted opacity-30 pointer-events-none">
                    <div class="border-b border-dashed border-gray-300 w-full h-0"></div>
                    <div class="border-b border-dashed border-gray-300 w-full h-0"></div>
                    <div class="border-b border-dashed border-gray-300 w-full h-0"></div>
                    <div class="border-b border-dashed border-gray-300 w-full h-0"></div>
                    <div class="border-b border-gray-300 w-full h-0"></div>
                </div>
                <!-- Chart Area -->
                <svg class="w-full h-full drop-shadow-lg" preserveaspectratio="none" viewbox="0 0 100 40">
                    <defs>
                        <lineargradient id="chartGradient" x1="0" x2="0" y1="0" y2="1">
                            <stop offset="0%" stop-color="#5b8ad7" stop-opacity="0.2"></stop>
                            <stop offset="100%" stop-color="#5b8ad7" stop-opacity="0"></stop>
                        </lineargradient>
                    </defs>
                    <path d="M0,35 Q10,32 20,25 T40,20 T60,28 T80,15 T100,22 V40 H0 Z" fill="url(#chartGradient)"></path>
                    <path d="M0,35 Q10,32 20,25 T40,20 T60,28 T80,15 T100,22" fill="none" stroke="#5b8ad7" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"></path>
                    <!-- Tooltip Dot simulation -->
                    <circle class="group-hover:r-2 transition-all" cx="80" cy="15" fill="#fff" r="1.5" stroke="#5b8ad7" stroke-width="0.8"></circle>
                </svg>
            </div>
            <!-- X Axis Labels -->
            <div class="flex justify-between text-xs text-text-muted mt-2 px-2">
                <span>1 Nov</span>
                <span>5 Nov</span>
                <span>10 Nov</span>
                <span>15 Nov</span>
                <span>20 Nov</span>
                <span>25 Nov</span>
                <span>30 Nov</span>
            </div>
        </div>
        <!-- Pie Chart -->
        <div class="lg:col-span-1 bg-white dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-card p-6 flex flex-col">
            <h3 class="text-lg font-bold text-text-main dark:text-white mb-1">Santri Health Status</h3>
            <p class="text-sm text-text-muted mb-6">Current distribution</p>
            <div class="flex-1 flex flex-col items-center justify-center gap-6">
                <!-- CSS Pie Chart -->
                <div class="relative size-48 rounded-full shadow-inner" style="background: conic-gradient(var(--color-success) 0deg 270deg, var(--color-danger) 270deg 310deg, var(--color-warning) 310deg 340deg, #60a5fa 340deg 360deg);">
                    <!-- Donut Hole -->
                    <div class="absolute inset-0 m-auto size-32 bg-white dark:bg-surface-dark rounded-full flex flex-col items-center justify-center">
                        <span class="text-3xl font-bold text-text-main dark:text-white">{{ number_format($total_santri ?? 0) }}</span>
                        <span class="text-xs text-text-muted font-medium uppercase tracking-wide">Total Santri</span>
                    </div>
                </div>
                <!-- Legend -->
                <div class="grid grid-cols-2 gap-x-6 gap-y-3 w-full px-2">
                    <div class="flex items-center gap-2">
                        <span class="size-3 rounded-full bg-success"></span>
                        <span class="text-sm text-text-muted">Healthy (75%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="size-3 rounded-full bg-danger"></span>
                        <span class="text-sm text-text-muted">Sick (11%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="size-3 rounded-full bg-warning"></span>
                        <span class="text-sm text-text-muted">Inpatient (9%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="size-3 rounded-full bg-blue-400"></span>
                        <span class="text-sm text-text-muted">Referral (5%)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Recent Sick Records Table -->
        <div class="lg:col-span-2 bg-white dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-card flex flex-col overflow-hidden">
            <div class="p-6 border-b border-border-light dark:border-border-dark flex justify-between items-center bg-white dark:bg-surface-dark">
                <h3 class="text-lg font-bold text-text-main dark:text-white">Recent Sick Records</h3>
                <a class="text-sm font-semibold text-primary hover:text-primary-dark" href="{{ route('web.sakit.index') }}">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-text-main dark:text-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-800 text-text-muted uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-4">Student Name</th>
                            <th class="px-6 py-4">Class</th>
                            <th class="px-6 py-4">Diagnosis</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-light dark:divide-border-dark">
                        <!-- Example Data (Replace with real data loop later) -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4 font-medium flex items-center gap-3">
                                <div class="size-8 rounded-full bg-gray-200 bg-cover bg-center" style="background-image: url('https://ui-avatars.com/api/?name=Ahmad+Fulan');"></div>
                                Ahmad Fulan
                            </td>
                            <td class="px-6 py-4 text-text-muted">XB - IPA</td>
                            <td class="px-6 py-4">Influenza</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger/10 text-danger">Sick</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4 font-medium flex items-center gap-3">
                                <div class="size-8 rounded-full bg-gray-200 bg-cover bg-center" style="background-image: url('https://ui-avatars.com/api/?name=Siti+Aminah');"></div>
                                Siti Aminah
                            </td>
                            <td class="px-6 py-4 text-text-muted">XIA - IPS</td>
                            <td class="px-6 py-4">Gastritis</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning/10 text-warning">Resting</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Critical Medicine Alerts -->
        <div class="lg:col-span-1 bg-white dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-card flex flex-col">
            <div class="p-6 border-b border-border-light dark:border-border-dark bg-white dark:bg-surface-dark rounded-t-xl">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-warning">warning</span>
                    <h3 class="text-lg font-bold text-text-main dark:text-white">Critical Inventory</h3>
                </div>
            </div>
            <div class="p-6 flex flex-col gap-4">
                <!-- Alert Item 1 -->
                <div class="flex items-center justify-between p-3 rounded-lg border border-red-100 bg-red-50 dark:bg-red-900/10 dark:border-red-900/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white dark:bg-surface-dark rounded-md shadow-sm text-danger">
                            <span class="material-symbols-outlined text-[20px]">pill</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-text-main dark:text-white">Paracetamol</p>
                            <p class="text-xs text-text-muted">Generic</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-danger">2 Strips</p>
                        <p class="text-[10px] text-danger font-medium uppercase">Critical</p>
                    </div>
                </div>
                <!-- Alert Item 2 -->
                <div class="flex items-center justify-between p-3 rounded-lg border border-orange-100 bg-orange-50 dark:bg-orange-900/10 dark:border-orange-900/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white dark:bg-surface-dark rounded-md shadow-sm text-warning">
                            <span class="material-symbols-outlined text-[20px]">sanitizer</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-text-main dark:text-white">Betadine</p>
                            <p class="text-xs text-text-muted">Antiseptic</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-warning">1 Bottle</p>
                        <p class="text-[10px] text-warning font-medium uppercase">Low Stock</p>
                    </div>
                </div>
                
                <button class="w-full mt-2 py-2.5 rounded-lg border border-border-light dark:border-border-dark text-sm font-semibold text-text-muted hover:text-text-main hover:bg-gray-50 dark:hover:bg-gray-800 transition-all flex items-center justify-center gap-2">
                    Resupply Now
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
