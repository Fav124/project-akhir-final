<!-- Modal Component -->
@php
    $modalId = $modalId ?? 'modal-' . uniqid();
    $size = $size ?? 'md'; // sm, md, lg, xl
    $sizeClasses = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
    ];
@endphp

<div id="{{ $modalId }}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 animate-fade-in">
    <div class="bg-white rounded-xl shadow-2xl {{ $sizeClasses[$size] ?? $sizeClasses['md'] }} w-full animate-scale-in overflow-hidden">
        <!-- Header -->
        @if(isset($title))
        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-5 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-white">{{ $title }}</h3>
                @if(isset($subtitle))
                <p class="text-sm text-emerald-100 mt-1">{{ $subtitle }}</p>
                @endif
            </div>
            <button onclick="closeModal('{{ $modalId }}')" class="text-white hover:bg-emerald-700 p-2 rounded-lg transition-smooth">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" fill-rule="evenodd" />
                </svg>
            </button>
        </div>
        @endif

        <!-- Body -->
        <div class="p-6">
            {{ $slot }}
        </div>

        <!-- Footer -->
        @if(isset($footer))
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 rounded-b-xl flex justify-end gap-3">
            {{ $footer }}
        </div>
        @else
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 rounded-b-xl flex justify-end gap-3">
            <button onclick="closeModal('{{ $modalId }}')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-smooth font-medium">
                Batal
            </button>
            <button onclick="closeModal('{{ $modalId }}')" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-smooth font-medium">
                Selesai
            </button>
        </div>
        @endif
    </div>
</div>

<script>
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('animate-fade-in');
        }
    }

    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('animate-fade-in');
        }
    }
</script>
