<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deisa - Sistem Manajemen Kesehatan Santri</title>
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
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-text-main dark:text-gray-100 antialiased">
    <div class="min-h-screen flex flex-col justify-center items-center px-6">
        <div class="text-center">
            <div class="mb-8 inline-flex items-center justify-center">
                <div class="size-16 text-primary">
                    <svg class="w-full h-full" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path d="M44 4H30.6666V17.3334H17.3334V30.6666H4V44H44V4Z" fill="currentColor"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-5xl font-bold text-text-main dark:text-white mb-4">Deisa</h1>
            <p class="text-xl text-text-muted dark:text-gray-400 mb-8 max-w-md mx-auto">
                Sistem Manajemen Kesehatan Santri yang Modern dan Terpercaya
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="bg-primary hover:bg-green-400 text-text-main font-bold py-3 px-8 rounded-lg transition-all active:scale-95">
                        Kembali ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-primary hover:bg-green-400 text-text-main font-bold py-3 px-8 rounded-lg transition-all active:scale-95">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</body>

</html>
