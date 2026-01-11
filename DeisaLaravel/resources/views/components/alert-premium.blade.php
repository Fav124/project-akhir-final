@props(['type' => 'success', 'message'])

@php
    $styles = [
        'success' => [
            'bg' => 'bg-emerald-50',
            'border' => 'border-emerald-200',
            'icon' => 'text-emerald-600',
            'text' => 'text-emerald-800',
            'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
        ],
        'error' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-200',
            'icon' => 'text-red-600',
            'text' => 'text-red-800',
            'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />'
        ]
    ][$type];
@endphp

<div class="mb-4">
    <div class="{{ $styles['bg'] }} {{ $styles['border'] }} border rounded-lg p-4 flex items-start gap-3">
        <svg class="w-5 h-5 {{ $styles['icon'] }} mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            {!! $styles['svg'] !!}
        </svg>
        <div class="flex-1">
            <p class="text-sm {{ $styles['text'] }}">{{ $message }}</p>
        </div>
        <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>
