<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-white dark:bg-slate-950 px-6 py-12 transition-colors duration-300">
        <div
            class="w-full max-w-lg bg-white dark:bg-slate-900/50 rounded-[2.5rem] p-10 shadow-2xl shadow-indigo-500/10 border border-slate-100 dark:border-white/5 backdrop-blur-xl"
        >
            {{-- Header --}}
            <div class="text-center mb-10">
                <div
                    class="inline-flex w-12 h-12 bg-[#6366f1] rounded-2xl items-center justify-center shadow-lg shadow-indigo-500/20 mb-6 transition-transform hover:scale-110"
                >
                    <span class="text-white font-black italic text-2xl uppercase">K</span>
                </div>

                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-2 uppercase">
                    Buat Akun
                </h2>

                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium italic">
                    Bergabung dengan ekosistem Kave. Tel-U Surabaya.
                </p>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Nama --}}
                <div>
                    <label for="name"
                        class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">
                        Nama Lengkap
                    </label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Contoh: Charlie Puth"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300 placeholder:text-slate-400"
                    >

                    <x-input-error :messages="$errors->get('name')" class="mt-2 ml-1" />
                </div>

                {{-- Email --}}
                <div>
                    <label for="email"
                        class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">
                        Email Mahasiswa
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="username"
                        placeholder="nama@student.telkomuniversity.ac.id"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300 placeholder:text-slate-400"
                    >

                    <x-input-error :messages="$errors->get('email')" class="mt-2 ml-1" />
                </div>

                {{-- Password --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="password"
                            class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">
                            Password
                        </label>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="new-password"
                            placeholder="••••••••"
                            class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300"
                        >

                        <x-input-error :messages="$errors->get('password')" class="mt-2 ml-1" />
                    </div>

                    <div>
                        <label for="password_confirmation"
                            class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">
                            Konfirmasi
                        </label>

                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            autocomplete="new-password"
                            placeholder="••••••••"
                            class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300"
                        >

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 ml-1" />
                    </div>
                </div>

                {{-- Submit --}}
                <div class="pt-4">
                    <button
                        type="submit"
                        class="w-full py-4 bg-slate-900 dark:bg-white text-white dark:text-black font-black rounded-2xl hover:bg-indigo-500 dark:hover:bg-indigo-500 hover:text-white transition-all duration-300 shadow-xl shadow-indigo-500/10 active:scale-[0.98] uppercase tracking-[0.1em]"
                    >
                        Daftar Akun
                    </button>
                </div>

                {{-- Login --}}
                <p class="text-center text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] pt-4">
                    Sudah punya akun?
                    <a
                        href="{{ route('login') }}"
                        class="text-indigo-500 hover:text-indigo-400 transition-colors duration-300 underline decoration-indigo-500/30 underline-offset-4"
                    >
                        Masuk ke Kave
                    </a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>

