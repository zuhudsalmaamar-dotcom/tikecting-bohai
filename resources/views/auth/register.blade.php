<x-guest-layout>
    <!-- Header Card -->
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Buat Akun Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar untuk mulai melaporkan kendala IT Anda</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus 
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition duration-150 ease-in-out" 
                placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required 
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition duration-150 ease-in-out" 
                placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
            <input id="password" type="password" name="password" required 
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition duration-150 ease-in-out" 
                placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required 
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition duration-150 ease-in-out" 
                placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Action Buttons -->
        <div class="pt-2 space-y-3">
            <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md hover:shadow-indigo-200 transition duration-150 ease-in-out text-sm">
                Daftar Sekarang
            </button>

            <div class="text-center pt-2">
                <span class="text-xs text-gray-500">Sudah memiliki akun?</span>
                <a href="{{ route('login') }}" class="text-xs font-bold text-indigo-600 hover:underline ms-1">
                    Masuk di sini
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>