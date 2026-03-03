@props(['size' => 'md', 'variant' => 'default'])

@php
    // Define size classes
    if ($size === 'xs') {
        $sizeClass = 'w-6 h-6 text-xs';
    } elseif ($size === 'sm') {
        $sizeClass = 'w-8 h-8 text-sm';
    } elseif ($size === 'lg') {
        $sizeClass = 'w-16 h-16 text-2xl';
    } elseif ($size === 'xl') {
        $sizeClass = 'w-20 h-20 text-4xl';
    } else {
        $sizeClass = 'w-10 h-10 text-base';
    }

    // Define variant classes
    if ($variant === 'plain') {
        $variantClass = 'bg-transparent text-deisa-blue shadow-none ring-0 border-0';
    } elseif ($variant === 'light') {
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
    class="{{ $classes }} {{ $variant !== 'plain' ? 'deisa-brand-mark' : '' }} rounded-2xl flex items-center justify-center font-bold transition-all duration-300 overflow-hidden">
    <img src="{{ asset('images/logo-deisa-removebg-preview.png') }}" alt="DEISA (Dar El-Ilmi Kesehatan)"
        class="w-full h-full object-contain {{ $variant === 'plain' ? 'p-0' : ($size === 'md' ? 'p-1.5' : 'p-1') }}">
</div>
