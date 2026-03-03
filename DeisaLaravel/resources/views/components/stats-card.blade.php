@props(['title', 'value', 'icon' => null, 'trend' => null, 'trendType' => 'neutral'])

@php
    $trendColors = [
        'up' => 'text-emerald-600 bg-emerald-100/50 border-emerald-200',
        'down' => 'text-red-600 bg-red-100/50 border-red-200',
        'neutral' => 'text-slate-500 bg-slate-100/50 border-slate-200',
    ];
    $trendIcon = match ($trendType) {
        'up' => '<svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>',
        'down' => '<svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>',
        default => '<span class="w-1.5 h-1.5 rounded-full bg-current"></span>'
    };
    $dataStat = $attributes->get('data-stat');
@endphp

<div {{ $attributes->except('data-stat')->merge(['class' => 'group bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col transition-all hover:shadow-lg hover:shadow-slate-200/50 hover:-translate-y-1']) }}>
    <div class="flex justify-between items-start">
        <div class="flex-1">
            <div class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ $title }}</div>
            <div class="text-3xl font-black text-slate-900 tracking-tight group-hover:text-deisa-blue transition-colors"
                @if($dataStat) data-stat="{{ $dataStat }}" @endif>{{ $value }}</div>
        </div>
        @if($icon)
            <div class="w-12 h-12 flex items-center justify-center bg-slate-50 text-slate-400 rounded-xl group-hover:bg-blue-50 group-hover:text-deisa-blue transition-all border border-slate-100">
                {!! $icon !!}
            </div>
        @endif
    </div>

    @if($trend || $trend === "0%")
        <div class="flex items-center gap-2 mt-5 pt-4 border-t border-slate-50">
            <div class="flex items-center gap-1.5 px-2 py-0.5 rounded-lg border text-[10px] font-black {{ $trendColors[$trendType] ?? $trendColors['neutral'] }}">
                {!! $trendIcon !!}
                {{ $trend }}
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">vs bulan lalu</span>
        </div>
    @elseif($title === "Santri Sakit (Total)")
        <div class="flex items-center gap-2 mt-5 pt-4 border-t border-slate-50">
             <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Data Historis</span>
        </div>
    @endif
</div>
