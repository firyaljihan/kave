<x-guest-layout>
    <div class="w-full max-w-lg bg-white dark:bg-slate-900/50 rounded-[2.5rem] p-10 shadow-2xl shadow-indigo-500/10 border border-slate-100 dark:border-white/5 backdrop-blur-xl">
        <div class="text-center mb-10">
            <div class="inline-flex w-12 h-12 bg-[#6366f1] rounded-2xl items-center justify-center shadow-lg shadow-indigo-500/20 mb-6">
                <span class="text-white font-black italic text-2xl uppercase">K</span>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-2 uppercase">Buat Akun.</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium italic">Bergabung dengan ekosistem Kave. Tel-U Surabaya.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div>
                <label for="name" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Justin Mason"
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all duration-300">
                <x-input-error :messages="$errors->get('name')" class="mt-2 ml-1" />
            </div>

            <div>
                <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Email Mahasiswa</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="nama@student.telkomuniversity.ac.id"
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all duration-300">
                <x-input-error :messages="$errors->get('email')" class="mt-2 ml-1" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="password" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Password</label>
                    <input id="password" type="password" name="password" required placeholder="••••••••"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all duration-300">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 ml-1" />
                </div>
                <div>
                    <label for="password_confirmation" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Konfirmasi</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all duration-300">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-slate-900 dark:bg-white text-white dark:text-black font-black rounded-2xl hover:bg-[#6366f1] dark:hover:bg-indigo-500 hover:text-white transition-all duration-300 shadow-xl shadow-indigo-500/10 uppercase tracking-[0.1em]">Daftar Akun</button>
            </div>

            <p class="text-center text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] pt-4">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-[#6366f1] hover:text-indigo-400 transition-colors duration-300 underline decoration-[#6366f1]/30 underline-offset-4 tracking-normal">Masuk ke Kave.</a>
            </p>
        </form>
    </div>
</x-guest-layout>
