<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'Deisa - Dashboard')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec80",
                        "background-light": "#f6f8f7",
                        "background-dark": "#102219",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1a3326",
                        "text-main": "#0d1b14",
                        "text-muted": "#4c9a73",
                    },
                    fontFamily: {
                        "display": ["Manrope", "Noto Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;family=Noto+Sans:wght@300..800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <style>
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .chart-bar {
            transition: height 0.5s ease-out;
        }
    </style>
    @stack('styles')
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-text-main dark:text-gray-100 antialiased selection:bg-primary selection:text-text-main overflow-hidden">
    <div class="flex h-screen flex-col">
        @include('components.header')
        <div class="flex flex-1 overflow-hidden">
            @include('components.sidebar')
            <main class="flex-1 overflow-y-auto bg-background-light dark:bg-background-dark p-6 lg:p-10">
                @yield('content')
                @include('components.footer')
            </main>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/deisa-ui.js') }}"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        @endif
    </script>
    @stack('scripts')
</body>

</html>
