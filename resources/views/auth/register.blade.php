<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-white mb-2">Buat Akun Baru</h2>
        <p class="text-sm text-gray-500">Silakan isi formulir di bawah ini untuk mendaftar.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-400 mb-1.5">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                class="w-full px-4 py-2.5 rounded-lg bg-[#1a1a1a] text-white border border-white/[0.07] focus:ring-1 focus:ring-[#f5c518] focus:border-[#f5c518] focus:outline-none transition-colors" 
                placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-400 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                class="w-full px-4 py-2.5 rounded-lg bg-[#1a1a1a] text-white border border-white/[0.07] focus:ring-1 focus:ring-[#f5c518] focus:border-[#f5c518] focus:outline-none transition-colors" 
                placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-400 mb-1.5">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full px-4 py-2.5 rounded-lg bg-[#1a1a1a] text-white border border-white/[0.07] focus:ring-1 focus:ring-[#f5c518] focus:border-[#f5c518] focus:outline-none transition-colors" 
                placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-400 mb-1.5">Konfirmasi Sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full px-4 py-2.5 rounded-lg bg-[#1a1a1a] text-white border border-white/[0.07] focus:ring-1 focus:ring-[#f5c518] focus:border-[#f5c518] focus:outline-none transition-colors" 
                placeholder="Ulangi kata sandi" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Register Button -->
        <button type="submit" class="w-full bg-[#f5c518] hover:bg-[#c9a014] text-black font-semibold py-2.5 rounded-lg transition duration-200 mt-2">
            Daftar
        </button>
    </form>

    <div class="mt-8 text-center text-sm text-gray-500">
        Sudah punya akun? 
        <a href="{{ route('login') }}" class="text-[#f5c518] hover:text-[#c9a014] font-medium transition-colors">Masuk di sini</a>
    </div>
</x-guest-layout>
