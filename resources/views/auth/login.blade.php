<x-guest-layout>
    <!-- Logo BDSI Header -->
    <div class="mb-6 flex flex-col items-center justify-center">
        <div class="relative group">
            <!-- Glow background effect -->
            <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-indigo-600 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
            
            <img src="{{ asset('images/logo-bdsi.png') }}" 
                 alt="Logo BDSI" 
                 class="relative h-20 w-auto object-contain drop-shadow-[0_0_15px_rgba(6,182,212,0.4)] transition-transform duration-300 hover:scale-105" />
        </div>

        <span class="mt-3 px-3 py-1 bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 font-mono text-[10px] font-bold tracking-widest rounded-full uppercase">
            • IT SUPPORT HELPDESK SYSTEM •
        </span>
    </div>

    <!-- Header Card -->
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-slate-100 tracking-tight font-mono">Selamat Datang Kembali</h2>
        <p class="text-xs text-slate-400 mt-1 font-mono">Masuk ke akun IT Ticketing System Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4 font-mono">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-300 mb-1 uppercase tracking-wider">Alamat Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-slate-100 placeholder-slate-500 text-sm focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition duration-200 outline-none" 
                placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-300 mb-1 uppercase tracking-wider">Password</label>
            <input id="password" type="password" name="password" required 
                class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-slate-100 placeholder-slate-500 text-sm focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition duration-200 outline-none" 
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="rounded bg-slate-900 border-slate-700 text-cyan-500 shadow-sm focus:ring-cyan-500 focus:ring-offset-slate-950 w-4 h-4">
                <span class="ms-2 text-xs text-slate-400 font-medium">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs font-semibold text-cyan-400 hover:text-cyan-300 transition" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="pt-2 space-y-3">
            <button type="submit" class="w-full py-2.5 px-4 bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold rounded-xl shadow-lg shadow-cyan-500/20 hover:shadow-cyan-400/40 transition duration-200 uppercase text-xs tracking-wider active:scale-95">
                Log In
            </button>

            @if (Route::has('register'))
                <div class="text-center pt-2">
                    <span class="text-xs text-slate-500">Belum punya akun?</span>
                    <a href="{{ route('register') }}" class="text-xs font-bold text-cyan-400 hover:text-cyan-300 hover:underline ms-1">
                        Daftar Akun Baru
                    </a>
                </div>
            @endif
        </div>
    </form>
</x-guest-layout>