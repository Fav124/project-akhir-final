@props(['type' => 'success', 'message'])

@php
    $styles = [
        'success' => [
            'bg' => 'bg-emerald-50/50',
            'border' => 'border-emerald-100',
            'icon' => 'text-emerald-500',
            'text' => 'text-emerald-900',
            'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
        ],
        'error' => [
            'bg' => 'bg-rose-50/50',
            'border' => 'border-rose-100',
            'icon' => 'text-rose-500',
            'text' => 'text-rose-900',
            'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />'
        ]
    ][$type];
@endphp

<div class="mb-8 animate-slide-in-down">
    <div class="{{ $styles['bg'] }} backdrop-blur-xl {{ $styles['border'] }} border rounded-[2rem] p-6 flex items-center gap-6 shadow-xl shadow-gray-200/20">
        <div class="w-14 h-14 rounded-2xl bg-white shadow-xl flex items-center justify-center {{ $styles['icon'] }}">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $styles['svg'] !!}
            </svg>
        </div>
        <div class="flex-1">
            <h4 class="text-sm font-black uppercase tracking-widest {{ $styles['text'] }} opacity-40 mb-1">{{ $type === 'success' ? 'Operation Success' : 'Attention Required' }}</h4>
            <p class="text-base font-bold {{ $styles['text'] }} tracking-tight leading-tight">{{ $message }}</p>
        </div>
        <button onclick="this.parentElement.parentElement.remove()" class="w-10 h-10 rounded-xl hover:bg-white/50 flex items-center justify-center text-gray-400 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
</div>
