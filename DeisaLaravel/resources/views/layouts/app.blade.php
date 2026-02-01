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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            @php
                $themeColor = '#0B63D6';
                if(auth()->check() && auth()->user()->profile && isset(auth()->user()->profile->settings['theme_color'])) {
                    $settings = auth()->user()->profile->settings;
                    if (is_string($settings)) {
                        $settings = json_decode($settings, true);
                    }
                    $pref = $settings['theme_color'] ?? 'deisa-blue';
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
            background-color: #ffffff;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        [x-cloak] { display: none !important; }

        /* SweetAlert Custom Styling */
        .swal2-popup {
            border-radius: 20px !important;
            padding: 2rem !important;
            font-family: 'Outfit', sans-serif !important;
        }
        .swal2-title {
            font-weight: 700 !important;
            color: #0f172a !important;
        }
    </style>
    <script>
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    </script>
</head>

<body class="bg-white text-slate-900 antialiased h-full ">
    <div class="min-h-screen bg-white">
        <!-- Global Alerts -->
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    showAlert('success', "{{ session('success') }}");
                });
            </script>
        @endif

        @if(session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    showAlert('error', "{{ session('error') }}");
                });
            </script>
        @endif
        
        @if(session('warning'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    showAlert('warning', "{{ session('warning') }}");
                });
            </script>
        @endif

        @yield('content')

        @include('components.focus-mode')
    </div>

    @stack('scripts')
    <script>
        window.showAlert = function(type, message) {
            const config = {
                icon: type,
                title: type.charAt(0).toUpperCase() + type.slice(1),
                text: message,
                showConfirmButton: (type === 'error' || type === 'warning'),
                timer: (type === 'success' || type === 'info') ? 3000 : null,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-2xl shadow-xl border-0',
                    confirmButton: 'bg-deisa-blue hover:bg-blue-700 px-6 py-2 rounded-xl text-white font-bold transition-all outline-none border-0'
                }
            };

            if (type === 'success') config.iconColor = '#10b981';
            else if (type === 'error') config.iconColor = '#ef4444';
            else if (type === 'warning') config.iconColor = '#f59e0b';

            Swal.fire(config);
        }

        window.showConfirm = function(title, text, onConfirm) {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0B63D6',
                cancelButtonColor: '#f8fafc',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl font-bold px-6',
                    cancelButton: 'rounded-xl font-bold px-6 text-slate-600 border border-slate-200'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed && typeof onConfirm === 'function') {
                    onConfirm();
                }
            });
        }
    </script>
</body>

</html>