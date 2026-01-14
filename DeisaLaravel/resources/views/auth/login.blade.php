<x-guest-layout>
    <div class="mb-5 text-center">
        <h2 class="text-xl font-bold text-slate-800">Welcome Back</h2>
        <p class="text-slate-500 text-sm">Please sign in to your account</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1">
            <label for="email" class="block text-sm font-medium text-slate-700">Email Address</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <span class="material-symbols-outlined text-[20px]">mail</span>
                </span>
                <input id="email" class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
            </div>
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
            <div class="relative" x-data="{ show: false }">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <span class="material-symbols-outlined text-[20px]">lock</span>
                </span>
                <input id="password" :type="show ? 'text' : 'password'" class="block w-full pl-10 pr-10 py-2.5 border border-slate-300 rounded-xl leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                    <span class="material-symbols-outlined text-[20px]" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                </button>
            </div>
            @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ml-2 text-sm text-slate-600">Remember me</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-500 font-medium" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-500/30 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-slate-800 hover:from-blue-700 hover:to-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5">
            Sign in
        </button>
    </form>
</x-guest-layout>
