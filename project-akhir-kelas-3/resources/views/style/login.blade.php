<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Deisa - Login</title>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Theme Configuration -->
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
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;family=Noto+Sans:wght@300..800&amp;display=swap" rel="stylesheet"/>
<!-- Material Symbols -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<style>
        /* Custom scrollbar for cleaner look if needed */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-text-main dark:text-gray-100 antialiased selection:bg-primary selection:text-text-main">
<div class="flex min-h-screen w-full flex-row overflow-hidden">
<!-- Left Side: Hero/Image Section (Hidden on mobile, visible on lg screens) -->
<div class="hidden lg:flex lg:w-1/2 relative bg-surface-dark items-center justify-center overflow-hidden">
<!-- Background Image -->
<div class="absolute inset-0 z-0">
<div class="w-full h-full bg-cover bg-center opacity-80 mix-blend-overlay" data-alt="Students studying outdoors in a peaceful green campus environment" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAM1InwB68-F8Wj0tIHpv8UtU7PxEfjE6yUQawBU57mleT9e16Y0s52W9UTuNsch3H8X-mRzntrX9W3sSFKKP6F9Ie6epBu4vwLxEI4xfFcHg13uLAQVVYSTA3AcOYbHxMk9t48W_-8Gh1_BoqtMUONp9TNvG4q-U20KlWLabqlOxmRs5e2R72CE4RTQN1NKpzYX6k_pzL5JUXtpakcw-RU1b2WghvUd-HGlfMKo5dK1HPYmohDGWNjECLy8uPnKjAsMEMcAtlAMdWe");'>
</div>
<div class="absolute inset-0 bg-gradient-to-t from-background-dark/90 via-background-dark/40 to-transparent"></div>
</div>
<!-- Content Overlay -->
<div class="relative z-10 flex flex-col items-start justify-end h-full w-full p-16 pb-24">
<div class="mb-8 p-4 rounded-xl bg-primary/20 backdrop-blur-sm border border-primary/10 inline-flex items-center justify-center">
<span class="material-symbols-outlined text-primary text-4xl">spa</span>
</div>
<h1 class="text-white text-5xl font-bold leading-tight tracking-tight max-w-lg mb-6">
                    Welcome Back, Santri!
                </h1>
<p class="text-gray-200 text-lg font-medium leading-relaxed max-w-md">
                    Continue your wellness journey with Deisa. Track your health, access resources, and stay balanced.
                </p>
</div>
</div>
<!-- Right Side: Login Form -->
<div class="flex w-full lg:w-1/2 flex-col justify-center items-center p-6 sm:p-12 lg:p-24 bg-background-light dark:bg-background-dark overflow-y-auto">
<div class="w-full max-w-md flex flex-col gap-8">
<!-- Mobile Header (Logo + Title) -->
<div class="flex flex-col gap-2">
<div class="flex items-center gap-3 text-text-main dark:text-white mb-2">
<div class="size-8 text-primary">
<svg class="w-full h-full" fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path d="M44 4H30.6666V17.3334H17.3334V30.6666H4V44H44V4Z" fill="currentColor"></path>
</svg>
</div>
<h2 class="text-2xl font-bold tracking-tight">Deisa</h2>
</div>
<h1 class="text-3xl font-bold text-text-main dark:text-white tracking-tight">Log in to your account</h1>
<p class="text-text-muted dark:text-gray-400 text-base">Welcome back! Please enter your details.</p>
</div>
<!-- Form -->
<form class="flex flex-col gap-5">
<!-- Email Field -->
<div class="flex flex-col gap-2">
<label class="text-text-main dark:text-gray-200 text-sm font-semibold leading-normal" for="email">Email Address</label>
<input class="form-input flex w-full rounded-lg border border-[#cfe7db] dark:border-gray-700 bg-surface-light dark:bg-surface-dark px-4 py-3 text-base text-text-main dark:text-white placeholder:text-text-muted dark:placeholder:text-gray-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary transition-colors h-12" id="email" name="email" placeholder="student@pesantren.com" type="email"/>
</div>
<!-- Password Field -->
<div class="flex flex-col gap-2">
<label class="text-text-main dark:text-gray-200 text-sm font-semibold leading-normal" for="password">Password</label>
<div class="relative flex items-center">
<input class="form-input flex w-full rounded-lg border border-[#cfe7db] dark:border-gray-700 bg-surface-light dark:bg-surface-dark px-4 py-3 pr-12 text-base text-text-main dark:text-white placeholder:text-text-muted dark:placeholder:text-gray-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary transition-colors h-12" id="password" name="password" placeholder="Enter your password" type="password"/>
<button class="absolute right-4 text-text-muted dark:text-gray-500 hover:text-primary transition-colors flex items-center justify-center" type="button">
<span class="material-symbols-outlined" style="font-size: 20px;">visibility_off</span>
</button>
</div>
</div>
<!-- Meta Links (Forgot Password) -->
<div class="flex justify-end">
<a class="text-primary hover:text-green-600 text-sm font-semibold hover:underline transition-colors" href="#">Forgot Password?</a>
</div>
<!-- Submit Button -->
<button class="flex w-full cursor-pointer items-center justify-center rounded-lg bg-primary hover:bg-green-400 text-[#0d1b14] text-base font-bold h-12 px-6 transition-all active:scale-[0.98]" type="button">
                        Log In
                    </button>
<!-- Divider -->
<div class="relative flex py-2 items-center">
<div class="flex-grow border-t border-gray-200 dark:border-gray-700"></div>
<span class="flex-shrink-0 mx-4 text-gray-400 text-sm font-medium">Or log in with</span>
<div class="flex-grow border-t border-gray-200 dark:border-gray-700"></div>
</div>
<!-- Google Button -->
<button class="flex w-full cursor-pointer items-center justify-center gap-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-surface-light dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-gray-800 text-text-main dark:text-white text-sm font-bold h-12 px-6 transition-colors" type="button">
<svg aria-hidden="true" class="h-5 w-5" viewbox="0 0 24 24">
<path d="M12.0003 20.45C16.6493 20.45 20.556 17.292 21.9688 13.125H12.0003V10.275H25.043C25.176 11.006 25.2445 11.761 25.2445 12.525C25.2445 19.839 19.3145 25.77 12.0003 25.77C4.68603 25.77 -1.24365 19.839 -1.24365 12.525C-1.24365 5.21098 4.68603 -0.719025 12.0003 -0.719025C15.2222 -0.719025 18.0498 0.359976 20.2528 2.12298L17.5683 5.48398C16.297 4.54298 14.4093 3.75498 12.0003 3.75498C7.62553 3.75498 3.99128 6.99398 3.99128 11.751C3.99128 16.508 7.62553 19.747 12.0003 19.747V20.45Z" fill="#4285F4" transform="translate(1.24365 0.719025) scale(0.923077)"></path>
<path d="M12.0003 20.4501C8.28178 20.4501 5.01178 18.0641 3.65278 14.8641L0.864258 17.0251C2.79326 21.4641 7.07826 24.6751 12.0003 24.6751C15.3523 24.6751 18.4063 23.6331 20.8003 21.8901L18.3183 19.1671C16.6063 20.1061 14.4443 20.4501 12.0003 20.4501Z" fill="#34A853" transform="translate(1.24365 0.719025) scale(0.923077)"></path>
<path d="M3.65256 14.864C3.26856 13.963 3.05656 12.984 3.05656 11.97C3.05656 10.956 3.26856 9.97701 3.65256 9.07601L0.864039 6.91501C-0.0384614 9.17601 -0.0384614 11.669 0.864039 13.93L3.65256 14.864Z" fill="#FBBC05" transform="translate(1.24365 0.719025) scale(0.923077)"></path>
<path d="M12.0003 3.75498C14.7573 3.75498 17.1473 4.88198 18.8873 6.67198L22.1003 3.44898C19.4673 0.998976 15.9683 -0.719025 12.0003 -0.719025C7.07826 -0.719025 2.79326 2.49198 0.864258 6.93098L3.65278 9.09198C5.01178 5.89198 8.28178 3.75498 12.0003 3.75498Z" fill="#EB4335" transform="translate(1.24365 0.719025) scale(0.923077)"></path>
</svg>
                        Log in with Google
                    </button>
</form>
<!-- Footer -->
<div class="text-center">
<p class="text-text-main dark:text-gray-300 text-sm">
                        Don't have an account? 
                        <a class="font-bold text-primary hover:text-green-400 hover:underline transition-colors" href="#">Sign up</a>
</p>
</div>
</div>
</div>
</div>
</body></html>