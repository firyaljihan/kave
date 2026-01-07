<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-10">
            <a href="{{ route('admin.users.index') }}" class="text-slate-400 hover:text-indigo-600 text-sm font-bold mb-4 inline-block transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar User
            </a>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Tambah User Baru</h1>
            <p class="text-slate-500 text-sm font-medium">Buat akun untuk Penyelenggara Event atau Admin baru.</p>
        </div>

        <div class="bg-white dark:bg-slate-800 p-8 sm:p-10 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-xl shadow-indigo-500/5">
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Nama Lengkap / Organisasi</label>
                    <input type="text" name="name" required placeholder="Contoh: BEM Fakultas Informatika"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Email</label>
                    <input type="email" name="email" required placeholder="email@organisasi.com"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Peran (Role)</label>
                    <select name="role" class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all appearance-none cursor-pointer">
                        <option value="penyelenggara">Penyelenggara (Organisasi/BEM)</option>
                        <option value="admin">Admin Tambahan</option>
                        <option value="mahasiswa">Mahasiswa</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Password Default</label>
                    <input type="text" name="password" value="password123" required
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all font-mono text-slate-600">
                    <p class="text-xs text-slate-400 mt-2 italic">*User dapat mengganti password ini setelah login.</p>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-[#6366f1] hover:bg-indigo-700 text-white font-black rounded-2xl shadow-lg shadow-indigo-500/30 transition-all uppercase tracking-widest text-xs">
                        Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
