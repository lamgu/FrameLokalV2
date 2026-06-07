<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-white mb-2">Masuk ke Akun Anda</h2>
        <p class="text-sm text-gray-500">Silakan masukkan detail login Anda di bawah ini.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-400 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                class="w-full px-4 py-2.5 rounded-lg bg-[#1a1a1a] text-white border border-white/[0.07] focus:ring-1 focus:ring-[#f5c518] focus:border-[#f5c518] focus:outline-none transition-colors" 
                placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1.5">
                <label for="password" class="block text-sm font-medium text-gray-400">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-[#f5c518] hover:text-[#c9a014] transition-colors" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full px-4 py-2.5 rounded-lg bg-[#1a1a1a] text-white border border-white/[0.07] focus:ring-1 focus:ring-[#f5c518] focus:border-[#f5c518] focus:outline-none transition-colors" 
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded bg-[#1a1a1a] border-white/[0.07] text-[#f5c518] focus:ring-[#f5c518] focus:ring-offset-0 focus:ring-1 transition-colors" name="remember">
                <span class="ms-2 text-sm text-gray-500 group-hover:text-gray-300 transition-colors">Ingat saya</span>
            </label>
        </div>

        <!-- Login Button -->
        <button type="submit" class="w-full bg-[#f5c518] hover:bg-[#c9a014] text-black font-semibold py-2.5 rounded-lg transition duration-200 mt-2">
            Masuk
        </button>
    </form>

    <div class="mt-8 text-center text-sm text-gray-500">
        Belum punya akun? 
        <a href="{{ route('register') }}" class="text-[#f5c518] hover:text-[#c9a014] font-medium transition-colors">Daftar sekarang</a>
    </div>
</x-guest-layout>
