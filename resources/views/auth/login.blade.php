<x-guest-layout>
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
                Selamat Datang.
            </h2>

            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium italic">
                Masuk ke dashboard Kave. kamu.
            </p>
        </div>

        {{-- Session Status --}}
        <x-auth-session-status
            class="mb-4"
            :status="session('status')"
        />

        {{-- Form --}}
        <form
            method="POST"
            action="{{ route('login') }}"
            class="space-y-6"
        >
            @csrf

            {{-- Email --}}
            <div>
                <label
                    for="email"
                    class="block text-[10px] font-black text-slate-400 uppercase
                           tracking-[0.2em] mb-2 ml-1"
                >
                    Email Mahasiswa
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="nama@student.telkomuniversity.ac.id"
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5
                           border border-slate-200 dark:border-white/10
                           rounded-2xl text-slate-900 dark:text-white
                           outline-none focus:ring-2 focus:ring-[#6366f1]/20
                           focus:border-[#6366f1] transition-all duration-300"
                >

                <x-input-error
                    :messages="$errors->get('email')"
                    class="mt-2"
                />
            </div>

            {{-- Password --}}
            <div class="mt-4">
                <label
                    for="password"
                    class="block text-[10px] font-black text-slate-400 uppercase
                           tracking-[0.2em] mb-2 ml-1"
                >
                    Password
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5
                           border border-slate-200 dark:border-white/10
                           rounded-2xl text-slate-900 dark:text-white
                           outline-none focus:ring-2 focus:ring-[#6366f1]/20
                           focus:border-[#6366f1] transition-all duration-300
                           placeholder:text-slate-400"
                >

                @if (Route::has('password.request'))
                    <div class="mt-2 ml-1 flex justify-end">
                        <a
                            href="{{ route('password.request') }}"
                            class="text-[10px] font-extrabold text-[#6366f1]
                                   hover:text-indigo-400 uppercase tracking-widest
                                   transition-colors duration-300 italic"
                        >
                            Lupa Password?
                        </a>
                    </div>
                @endif

                <x-input-error
                    :messages="$errors->get('password')"
                    class="mt-2 ml-1"
                />
            </div>

            {{-- Remember & Submit --}}
            <div class="space-y-6 pt-2">
                <div class="flex items-center ml-1">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="w-4 h-4 rounded border-slate-300
                               text-[#6366f1] focus:ring-[#6366f1]"
                    >
                    <label
                        for="remember_me"
                        class="ms-2 text-[10px] font-black text-slate-500
                               uppercase tracking-widest cursor-pointer"
                    >
                        Ingat saya
                    </label>
                </div>

                <button
                    type="submit"
                    class="w-full py-4 bg-slate-900 dark:bg-white
                           text-white dark:text-black font-black rounded-2xl
                           hover:bg-[#6366f1] dark:hover:bg-indigo-500
                           hover:text-white transition-all duration-300
                           shadow-xl shadow-indigo-500/10
                           uppercase tracking-widest text-xs"
                >
                    Log In
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
