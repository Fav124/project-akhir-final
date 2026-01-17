@props(['stok', 'min'])

@php
    $status = 'Aman';
    $class = 'bg-emerald-100 text-emerald-800 border border-emerald-200'; // Healthy green default

    if ($stok <= 0) {
        $status = 'Habis';
        $class = 'bg-red-100 text-red-800 border border-red-200';
    } elseif ($stok <= $min) {
        $status = 'Menipis';
        $class = 'bg-amber-100 text-amber-800 border border-amber-200';
    }
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $class]) }}>
    {{ $status }} ({{ $stok }})
</span>