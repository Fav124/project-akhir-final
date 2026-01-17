@props(['variant' => 'primary', 'href' => null])

@php
    $baseClass = 'inline-flex items-center justify-center px-4 py-2 rounded-lg font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $variants = [
        'primary' => 'bg-deisa-blue text-white hover:bg-blue-700 focus:ring-blue-500',
        'accent' => 'bg-deisa-green text-white hover:bg-emerald-600 focus:ring-emerald-500',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
        'warning' => 'bg-amber-500 text-white hover:bg-amber-600 focus:ring-amber-500',
        'outline' => 'bg-white text-slate-700 border border-slate-300 hover:bg-slate-50 focus:ring-slate-300',
        'ghost' => 'bg-transparent text-slate-600 hover:bg-slate-100',
    ];

    $class = $baseClass . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </button>
@endif