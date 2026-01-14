@extends('layouts.app-tailwind')

@section('title', 'Dashboard Overview')
@section('subtitle', 'Welcome back, here is what is happening today.')

@section('content')
<div class="flex flex-col gap-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Stat Card 1 -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col gap-4 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined text-6xl text-blue-600">groups</span>
            </div>
            <div class="flex justify-between items-start z-10">
                <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl text-blue-600 dark:text-blue-400">
                    <span class="material-symbols-outlined filled">groups</span>
                </div>
                <!-- <span class="flex items-center gap-1 text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full border border-emerald-100">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    +2%
                </span> -->
            </div>
            <div class="z-10">
                <h3 class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Santri</h3>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-1 font-outfit">{{ number_format($total_santri ?? 0) }}</p>
            </div>
        </div>

        <!-- Stat Card 2 (Alert) -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-l-4 border-slate-200 border-l-red-500 dark:border-slate-700 flex flex-col gap-4 relative overflow-hidden group">
             <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined text-6xl text-red-600">sick</span>
            </div>
            <div class="flex justify-between items-start z-10">
                <div class="p-3 bg-red-50 dark:bg-red-900/30 rounded-xl text-red-600 dark:text-red-400">
                    <span class="material-symbols-outlined filled">sick</span>
                </div>
                @if(($santri_sakit ?? 0) > 0)
                <span class="flex items-center gap-1 text-xs font-medium text-red-600 bg-red-50 px-2 py-1 rounded-full border border-red-100">
                    Action Needed
                </span>
                @endif
            </div>
            <div class="z-10">
                <h3 class="text-slate-500 dark:text-slate-400 text-sm font-medium">Santri Sakit (Current)</h3>
                <p class="text-3xl font-bold text-red-600 mt-1 font-outfit">{{ number_format($santri_sakit ?? 0) }}</p>
            </div>
        </div>

        <!-- Stat Card 3 (Warning) -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-l-4 border-slate-200 border-l-amber-500 dark:border-slate-700 flex flex-col gap-4 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined text-6xl text-amber-500">inventory_2</span>
            </div>
            <div class="flex justify-between items-start z-10">
                <div class="p-3 bg-amber-50 dark:bg-amber-900/30 rounded-xl text-amber-600 dark:text-amber-400">
                    <span class="material-symbols-outlined filled">inventory_2</span>
                </div>
                @if(($low_stock ?? 0) > 0)
                 <span class="flex items-center gap-1 text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded-full border border-amber-100">
                    Resock Needed
                </span>
                @endif
            </div>
            <div class="z-10">
                <h3 class="text-slate-500 dark:text-slate-400 text-sm font-medium">Low Stock Medicines</h3>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-1 font-outfit">{{ $low_stock ?? 0 }} <span class="text-lg font-medium text-slate-400">Items</span></p>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col gap-4 relative overflow-hidden group">
             <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined text-6xl text-blue-500">medication</span>
            </div>
            <div class="flex justify-between items-start z-10">
                <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl text-blue-600 dark:text-blue-400">
                    <span class="material-symbols-outlined filled">medication</span>
                </div>
                <span class="flex items-center gap-1 text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded-full border border-blue-100">
                    Active
                </span>
            </div>
            <div class="z-10">
                <h3 class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Jenis Obat</h3>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-1 font-outfit">{{ number_format($total_obat ?? 0) }}</p>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
     <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Line Chart Placeholder (Using CSS for simple viz) -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white font-outfit">Health Trend</h3>
                    <p class="text-sm text-slate-500">Sick cases overview</p>
                </div>
                <button class="text-sm font-medium text-blue-600 hover:text-blue-700 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-1.5 flex items-center gap-2 hover:bg-slate-50 transition-colors">
                    Last 30 Days
                </button>
            </div>
            
            <!-- Simple Mock Chart using HTML/CSS -->
             <div class="flex-1 flex items-end justify-between gap-2 h-64 w-full pt-4 pb-2">
                 @foreach(range(1, 12) as $i)
                    @php $h = rand(10, 80); @endphp
                    <div class="w-full bg-blue-50 dark:bg-blue-900/10 rounded-t-lg relative group h-full flex flex-col justify-end">
                        <div style="height: {{ $h }}%;" class="w-full bg-blue-500/80 hover:bg-blue-500 transition-all rounded-t-sm relative">
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                {{ $h }} cases
                            </div>
                        </div>
                    </div>
                 @endforeach
             </div>
             <div class="flex justify-between mt-2 px-2 text-xs text-slate-400">
                 <span>Week 1</span>
                 <span>Week 2</span>
                 <span>Week 3</span>
                 <span>Week 4</span>
             </div>
        </div>

         <!-- Pie Chart Placeholder -->
        <div class="lg:col-span-1 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 flex flex-col">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-1 font-outfit">Status Distribution</h3>
            <p class="text-sm text-slate-500 mb-8">Current Santri Condition</p>
            
            <div class="flex-1 flex flex-col items-center justify-center gap-8">
                 <div class="relative size-56 rounded-full shadow-inner bg-slate-50" style="background: conic-gradient(#10b981 0deg 270deg, #ef4444 270deg 310deg, #f59e0b 310deg 360deg);">
                    <div class="absolute inset-0 m-auto size-40 bg-white dark:bg-slate-800 rounded-full flex flex-col items-center justify-center z-10 shadow-sm">
                        <span class="text-4xl font-bold text-slate-800 dark:text-white font-outfit">{{ number_format($total_santri ?? 0) }}</span>
                        <span class="text-xs text-slate-500 font-medium uppercase tracking-wide">Total</span>
                    </div>
                </div>

                <div class="w-full space-y-3">
                     <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="size-3 rounded-full bg-emerald-500"></span>
                            <span class="text-sm text-slate-600 dark:text-slate-400">Sehat</span>
                        </div>
                        <span class="text-sm font-semibold text-slate-800 dark:text-white">75%</span>
                    </div>
                     <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="size-3 rounded-full bg-red-500"></span>
                            <span class="text-sm text-slate-600 dark:text-slate-400">Sakit</span>
                        </div>
                        <span class="text-sm font-semibold text-slate-800 dark:text-white">11%</span>
                    </div>
                     <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="size-3 rounded-full bg-amber-500"></span>
                            <span class="text-sm text-slate-600 dark:text-slate-400">Izin / Lainnya</span>
                        </div>
                        <span class="text-sm font-semibold text-slate-800 dark:text-white">14%</span>
                    </div>
                </div>
            </div>
        </div>
     </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Sick Records Table -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-white dark:bg-slate-800">
                <div>
                     <h3 class="text-lg font-bold text-slate-800 dark:text-white font-outfit">Recent Sick Records</h3>
                     <p class="text-sm text-slate-500">Latest updates from clinic</p>
                </div>
                <a href="{{ route('web.sakit.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition-colors">See All</a>
            </div>
            
             <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-400">
                    <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 uppercase text-xs font-semibold tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Student</th>
                            <th class="px-6 py-4">Diagnosis</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @if(isset($santri_sakit) && $santri_sakit > 0)
                            <!-- Need real data here, using placeholders for layout -->
                             <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="size-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                                            AF
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-900 dark:text-white">Ahmad Fulan</p>
                                            <p class="text-xs text-slate-500">Class XB</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">Demam Tinggi</td>
                                <td class="px-6 py-4 text-slate-500">{{ now()->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        Sakit
                                    </span>
                                </td>
                            </tr>
                             <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="size-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-xs">
                                            ZA
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-900 dark:text-white">Zaid Abdullah</p>
                                            <p class="text-xs text-slate-500">Class XIA</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">Batuk Pilek</td>
                                <td class="px-6 py-4 text-slate-500">{{ now()->subDay()->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        Sakit
                                    </span>
                                </td>
                            </tr>
                        @else
                             <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                    <div class="flex flex-col items-center gap-2">
                                        <span class="material-symbols-outlined text-4xl text-slate-300">check_circle</span>
                                        <p>No currently sick students</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Critical Alerts / Quick Actions -->
        <div class="lg:col-span-1 flex flex-col gap-6">
             <div class="bg-gradient-to-br from-blue-600 to-slate-700 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                     <span class="material-symbols-outlined text-8xl">medical_services</span>
                </div>
                <h3 class="text-lg font-bold font-outfit relative z-10">Quick Actions</h3>
                <div class="flex flex-col gap-3 mt-4 relative z-10">
                    <a href="{{ route('web.sakit.create') }}" class="w-full bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 text-white rounded-xl px-4 py-3 flex items-center transition-all">
                        <span class="material-symbols-outlined mr-3">add_circle</span>
                         <span class="font-medium text-sm">Input Santri Sakit</span>
                    </a>
                    <a href="{{ route('web.obat.index') }}" class="w-full bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 text-white rounded-xl px-4 py-3 flex items-center transition-all">
                        <span class="material-symbols-outlined mr-3">inventory</span>
                         <span class="font-medium text-sm">Manage Stock</span>
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6">
                <div class="flex items-center gap-2 mb-4">
                     <span class="material-symbols-outlined text-amber-500 filled">warning</span>
                     <h3 class="text-lg font-bold text-slate-800 dark:text-white font-outfit">Stock Alerts</h3>
                </div>
                
                 @if(isset($low_stock) && $low_stock > 0)
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 bg-red-50 dark:bg-red-900/10 rounded-xl border border-red-100 dark:border-red-900/30">
                            <div class="bg-white dark:bg-slate-800 p-2 rounded-lg text-red-500 shadow-sm">
                                <span class="material-symbols-outlined">pill</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800 dark:text-white">Critical Low Stock</p>
                                <p class="text-xs text-red-600">{{ $low_stock }} items below limit</p>
                            </div>
                        </div>
                    </div>
                     <a href="{{ route('web.obat.index') }}" class="mt-4 w-full block text-center py-2 text-sm font-medium text-slate-600 hover:text-blue-600 border border-slate-200 rounded-lg hover:bg-slate-50 transition-all">
                        Resolve Issues
                    </a>
                @else
                    <div class="text-center py-6">
                         <div class="size-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3">
                             <span class="material-symbols-outlined">check</span>
                         </div>
                        <p class="text-sm font-medium text-slate-800">All Stock Healthy</p>
                        <p class="text-xs text-slate-500 mt-1">No items are below minimum limit</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
