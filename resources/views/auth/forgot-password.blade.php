<x-guest-layout>
    <!-- Logo BDSI Header -->
    <div class="mb-6 flex flex-col items-center justify-center">
        <div class="relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-indigo-600 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
            
            <img src="{{ asset('images/logo-bdsi.png') }}" 
                 alt="Logo BDSI" 
                 class="relative h-20 w-auto object-contain drop-shadow-[0_0_15px_rgba(6,182,212,0.4)] transition-transform duration-300 hover:scale-105" />
        </div>

        <span class="mt-3 px-3 py-1 bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 font-mono text-[10px] font-bold tracking-widest rounded-full uppercase">
            • IT SUPPORT HELPDESK SYSTEM •
        </span>
    </div>

    <!-- Informasi Deskripsi -->
    <div class="mb-6 text-slate-300 text-xs font-mono leading-relaxed text-center">
        Lupa kata sandi Anda? Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi baru.
    </div>

    <!-- Session Status (Notifikasi Sukses Kirim Email) -->
    @if (session('status'))
        <div class="mb-4 px-4 py-3 bg-emerald-500/10 border border-emerald-500/30 rounded-xl text-xs font-mono text-emerald-400 text-center">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4 font-mono">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-300 mb-1 uppercase tracking-wider">Alamat Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-slate-100 placeholder-slate-500 text-sm focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition duration-200 outline-none" 
                placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Tombol Aksi -->
        <div class="pt-2 space-y-3">
            <button type="submit" class="w-full py-2.5 px-4 bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold rounded-xl shadow-lg shadow-cyan-500/20 hover:shadow-cyan-400/40 transition duration-200 uppercase text-xs tracking-wider active:scale-95">
                Kirim Link Reset Password
            </button>

            <div class="text-center pt-2">
                <a href="{{ route('login') }}" class="text-xs font-bold text-slate-400 hover:text-cyan-400 transition">
                    ← Kembali ke Halaman Login
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>