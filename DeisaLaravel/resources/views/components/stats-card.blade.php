@props(['title', 'value', 'icon' => null, 'trend' => null, 'trendType' => 'neutral'])

@php
    $trendColors = [
        'up' => 'text-emerald-600 bg-emerald-50',
        'down' => 'text-red-600 bg-red-50',
        'neutral' => 'text-slate-600 bg-slate-50',
    ];
    $trendIcon = match ($trendType) {
        'up' => '↑',
        'down' => '↓',
        default => '•'
    };
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col']) }}>
    <div class="flex justify-between items-start mb-4">
        <div>
            <div class="text-sm font-medium text-slate-500 mb-1">{{ $title }}</div>
            <div class="text-2xl font-bold text-slate-900">{{ $value }}</div>
        </div>
        @if($icon)
            <div class="p-2.5 bg-blue-50 text-deisa-blue rounded-lg">
                {!! $icon !!}
            </div>
        @endif
    </div>

    @if($trend)
        <div class="flex items-center gap-2 mt-auto">
            <span
                class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium {{ $trendColors[$trendType] ?? $trendColors['neutral'] }}">
                {{ $trendIcon }} {{ $trend }}
            </span>
            <span class="text-xs text-slate-400">vs bulan lalu</span>
        </div>
    @endif
</div>