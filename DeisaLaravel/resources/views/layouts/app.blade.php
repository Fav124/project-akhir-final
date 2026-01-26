<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Deisa Health')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            @php
                $themeColor = '#0B63D6';
                if(auth()->check() && auth()->user()->profile && isset(auth()->user()->profile->settings['theme_color'])) {
                    $pref = auth()->user()->profile->settings['theme_color'];
                    $map = [
                        'deisa-blue' => '#0B63D6',
                        'indigo-600' => '#4f46e5',
                        'emerald-600' => '#059669',
                        'rose-600' => '#e11d48',
                        'slate-800' => '#1e293b',
                    ];
                    $themeColor = $map[$pref] ?? $pref;
                }
            @endphp
            --color-deisa-blue: {{ $themeColor }};
        }

        body {
            font-family: 'Outfit', sans-serif;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-50 text-slate-800 antialiased h-full">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
        <!-- Global Alerts -->
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    if(typeof showAlert === 'function') showAlert('success', "{{ session('success') }}");
                });
            </script>
        @endif

        @if(session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    if(typeof showAlert === 'function') showAlert('error', "{{ session('error') }}");
                });
            </script>
        @endif

        @yield('content')

        @include('components.focus-mode')
    </div>

    @stack('scripts')
    <script>
        // Placeholder for showAlert if app.js hasn't loaded it yet
        window.showAlert = window.showAlert || function(type, message) {
            alert(type.toUpperCase() + ": " + message);
        }
    </script>
</body>

</html>