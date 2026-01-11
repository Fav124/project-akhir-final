<!-- Card Component -->
@php
    $variant = $variant ?? 'default'; // default, premium, primary, success, warning, danger, gradient
    $glow = $glow ?? false;
    
    $variantStyles = [
        'default' => [
            'bg' => 'bg-white',
            'border' => 'border border-gray-100',
            'shadow' => 'shadow-sm hover:shadow-xl shadow-slate-200/50',
            'header' => 'p-6 bg-slate-50/50 border-b border-gray-100/50'
        ],
        'premium' => [
            'bg' => 'glass-premium',
            'border' => 'border border-white/40',
            'shadow' => 'shadow-2xl shadow-slate-300/20',
            'header' => 'p-8 pb-4'
        ],
        'primary' => [
            'bg' => 'bg-white',
            'border' => 'border border-blue-100',
            'shadow' => 'shadow-lg shadow-blue-500/5',
            'header' => 'p-6 bg-blue-50/30 border-b border-blue-100'
        ],
        'gradient' => [
            'bg' => 'bg-gradient-to-br from-emerald-500 to-teal-600',
            'border' => 'border-none',
            'shadow' => 'shadow-2xl shadow-emerald-200',
            'header' => 'p-6'
        ],
    ];
    
    $style = $variantStyles[$variant] ?? $variantStyles['default'];
    $glowClass = $glow ? 'animate-border-glow ring-2 ring-emerald-500/10' : '';
@endphp

<div class="rounded-[2.5rem] {{ $style['bg'] }} {{ $style['border'] }} {{ $style['shadow'] }} {{ $glowClass }} transition-all duration-500 overflow-hidden animate-slide-in-up">
    @if(isset($title))
    <div class="{{ $style['header'] }}">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-black {{ $variant === 'premium' ? 'text-slate-900 tracking-tight' : ($variant === 'gradient' ? 'text-white' : 'text-slate-800') }} font-display leading-tight">
                    {{ $title }}
                </h3>
                @if(isset($subtitle))
                <p class="text-[10px] font-bold uppercase tracking-widest {{ $variant === 'premium' ? 'text-slate-400 mt-1.5' : ($variant === 'gradient' ? 'text-emerald-100' : 'text-slate-500') }}">
                    {{ $subtitle }}
                </p>
                @endif
            </div>
            @if(isset($icon))
            <div class="{{ $variant === 'premium' ? 'w-12 h-12 rounded-2xl bg-gray-50/50 flex items-center justify-center text-gray-400' : ($variant === 'gradient' ? 'text-white' : 'text-gray-400') }}">
                {!! $icon !!}
            </div>
            @endif
        </div>
    </div>
    @endif

    <div class="p-8 {{ isset($title) && $variant === 'premium' ? 'pt-2' : '' }}">
        {{ $slot }}
    </div>

    @if(isset($footer))
    <div class="bg-gray-50/50 px-8 py-6 border-t border-gray-100/50">
        {{ $footer }}
    </div>
    @endif
</div>
