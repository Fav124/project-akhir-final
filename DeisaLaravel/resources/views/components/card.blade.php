<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden']) }}>
    @if(isset($header))
        <div class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800">
            {{ $header }}
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
            {{ $footer }}
        </div>
    @endif
</div>