@php
    $variant = $variant ?? 'default';
    $variantClasses = [
        'default' => 'bg-white border-gray-200',
        'primary' => 'bg-white border-blue-200',
        'success' => 'bg-white border-emerald-200',
        'warning' => 'bg-white border-amber-200',
        'danger' => 'bg-white border-red-200',
    ];
    $borderClass = $variantClasses[$variant] ?? $variantClasses['default'];
@endphp

<div class="bg-white border border-gray-200 rounded-lg {{ $borderClass }}">
    @if(isset($title))
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
        @if(isset($subtitle))
        <p class="text-sm text-gray-500 mt-1">{{ $subtitle }}</p>
        @endif
    </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>

    @if(isset($footer))
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        {{ $footer }}
    </div>
    @endif
</div>
