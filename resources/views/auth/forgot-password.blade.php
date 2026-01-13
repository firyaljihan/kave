<x-guest-layout>
    {{-- Langsung mulai dengan Card, tanpa wrapper min-h-screen tambahan --}}
    <div
        class="w-full max-w-md bg-white dark:bg-slate-900/50 rounded-[2.5rem] p-10
               shadow-2xl shadow-indigo-500/10 border border-slate-100 dark:border-white/5
               backdrop-blur-xl"
    >
        {{-- Header --}}
        <div class="text-center mb-10">
            <div
                class="inline-flex w-12 h-12 bg-[#6366f1] rounded-2xl
                       items-center justify-center shadow-lg shadow-indigo-500/20 mb-6"
            >
                <span class="text-white font-black italic text-2xl uppercase">K</span>
            </div>

            <h2
                class="text-3xl font-extrabold text-slate-900 dark:text-white
                       tracking-tight mb-2 uppercase"
            >
                Reset Password.
            </h2>

            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium italic">
                Masukkan email dan password baru Anda.
            </p>
        </div>

        {{-- Session Status --}}
        <x-auth-session-status class="mb-4" :status="session('status')" />

        {{-- Form --}}
        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            {{-- Email --}}
            <div>
                <label
                    for="email"
                    class="block text-[10px] font-black text-slate-400 uppercase
                           tracking-[0.2em] mb-2 ml-1"
                >
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="Masukkan E-mail"
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5
                           border border-slate-200 dark:border-white/10
                           rounded-2xl text-slate-900 dark:text-white
                           outline-none focus:ring-2 focus:ring-[#6366f1]/20
                           focus:border-[#6366f1] transition-all duration-300
                           placeholder:text-slate-400"
                >

                <x-input-error :messages="$errors->get('email')" class="mt-2 ml-1" />
            </div>

            {{-- Password Baru --}}
            <div>
                <label
                    for="password"
                    class="block text-[10px] font-black text-slate-400 uppercase
                           tracking-[0.2em] mb-2 ml-1"
                >
                    Password Baru
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    placeholder="Password Baru"
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5
                           border border-slate-200 dark:border-white/10
                           rounded-2xl text-slate-900 dark:text-white
                           outline-none focus:ring-2 focus:ring-[#6366f1]/20
                           focus:border-[#6366f1] transition-all duration-300
                           placeholder:text-slate-400"
                >

                <x-input-error :messages="$errors->get('password')" class="mt-2 ml-1" />
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label
                    for="password_confirmation"
                    class="block text-[10px] font-black text-slate-400 uppercase
                           tracking-[0.2em] mb-2 ml-1"
                >
                    Konfirmasi Password
                </label>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    placeholder="Ulangi Password Baru"
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5
                           border border-slate-200 dark:border-white/10
                           rounded-2xl text-slate-900 dark:text-white
                           outline-none focus:ring-2 focus:ring-[#6366f1]/20
                           focus:border-[#6366f1] transition-all duration-300
                           placeholder:text-slate-400"
                >

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 ml-1" />
            </div>

            {{-- Tombol Submit --}}
            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full py-4 bg-slate-900 dark:bg-white
                           text-white dark:text-black font-black rounded-2xl
                           hover:bg-[#6366f1] dark:hover:bg-indigo-500
                           hover:text-white transition-all duration-300
                           shadow-xl shadow-indigo-500/10
                           uppercase tracking-widest text-xs"
                >
                    Reset Password
                </button>
            </div>
        </form>

        {{-- Footer Link --}}
        <p class="text-center text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em] pt-6">
            <a href="{{ route('login') }}" class="text-[#6366f1] hover:underline flex items-center justify-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Login
            </a>
        </p>
    </div>
</x-guest-layout>
