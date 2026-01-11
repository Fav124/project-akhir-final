<!-- Button Component -->
@php
    $variant = $variant ?? 'primary'; // primary, secondary, success, danger, warning, info, ghost
    $size = $size ?? 'md'; // xs, sm, md, lg, xl
    $disabled = $disabled ?? false;
    
    $variantClasses = [
        'primary' => 'bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white shadow-md hover:shadow-lg',
        'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-800 shadow hover:shadow-md',
        'success' => 'bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white shadow-md hover:shadow-lg',
        'danger' => 'bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-600 hover:to-rose-600 text-white shadow-md hover:shadow-lg',
        'warning' => 'bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-white shadow-md hover:shadow-lg',
        'info' => 'bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white shadow-md hover:shadow-lg',
        'ghost' => 'bg-transparent hover:bg-gray-100 text-gray-700 border-2 border-gray-300 hover:border-gray-400',
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
    
    $classes = "inline-flex items-center justify-center gap-2 rounded-lg font-medium transition-smooth duration-200 " . $variantClass . " " . $sizeClass;
    
    if ($disabled) {
        $classes .= " opacity-50 cursor-not-allowed";
    }
@endphp

@if($tag ?? false === 'a')
<a href="{{ $href ?? '#' }}" class="{{ $classes }}" {{ $attributes }}>
    {{ $slot }}
</a>
@elseif($tag ?? false === 'button')
<button type="{{ $type ?? 'button' }}" class="{{ $classes }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes }}>
    {{ $slot }}
</button>
@else
<button type="{{ $type ?? 'button' }}" class="{{ $classes }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes }}>
    {{ $slot }}
</button>
@endif
