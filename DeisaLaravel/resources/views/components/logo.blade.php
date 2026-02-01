@props(['size' => 'md', 'variant' => 'default'])

@php
    // Define size classes
    if ($size === 'xs') {
        $sizeClass = 'w-6 h-6 text-xs';
    } elseif ($size === 'sm') {
        $sizeClass = 'w-8 h-8 text-sm';
    } elseif ($size === 'lg') {
        $sizeClass = 'w-14 h-14 text-2xl';
    } elseif ($size === 'xl') {
        $sizeClass = 'w-20 h-20 text-4xl';
    } else {
        $sizeClass = 'w-10 h-10 text-base';
    }

    // Define variant classes
    if ($variant === 'light') {
        $variantClass = 'bg-white text-deisa-blue shadow-sm ring-1 ring-slate-100';
    } elseif ($variant === 'outline') {
        $variantClass = 'bg-white border-2 border-slate-100 text-deisa-blue';
    } elseif ($variant === 'dark') {
        $variantClass = 'bg-slate-900 border border-slate-800';
    } else {
        $variantClass = 'bg-white text-white shadow-md shadow-blue-500/5 border border-slate-100';
    }

    $classes = $sizeClass . ' ' . $variantClass;
@endphp

<div
    class="{{ $classes }} rounded-2xl flex items-center justify-center font-bold transition-all duration-300 overflow-hidden">
    <img src="{{ asset('images/logo.png') }}" alt="Deisa Health" class="w-full h-full object-cover p-1">
</div>