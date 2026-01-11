@php
    $variant = $variant ?? 'primary';
    $size = $size ?? 'md';
    $disabled = $disabled ?? false;
    
    $variantClasses = [
        'primary' => 'bg-emerald-600 hover:bg-emerald-700 text-white',
        'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-900',
        'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white',
        'warning' => 'bg-amber-600 hover:bg-amber-700 text-white',
        'info' => 'bg-blue-600 hover:bg-blue-700 text-white',
        'ghost' => 'bg-transparent hover:bg-gray-100 text-gray-700 border border-gray-300',
    ];
    
    $sizeClasses = [
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-base',
        'xl' => 'px-6 py-3 text-lg',
    ];
    
    $variantClass = $variantClasses[$variant] ?? $variantClasses['primary'];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    
    $classes = "inline-flex items-center justify-center gap-2 rounded-lg font-medium transition-colors " . $variantClass . " " . $sizeClass;
    
    if ($disabled) {
        $classes .= " opacity-50 cursor-not-allowed";
    }
@endphp

@if(($tag ?? false) === 'a')
<a href="{{ $href ?? '#' }}" class="{{ $classes }}" {{ $attributes }}>
    {{ $slot }}
</a>
@else
<button type="{{ $type ?? 'button' }}" class="{{ $classes }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes }}>
    {{ $slot }}
</button>
@endif
