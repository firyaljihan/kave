<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-10">
            <a href="{{ route('admin.categories.index') }}"
                class="text-slate-400 hover:text-indigo-600 text-sm font-bold mb-4 inline-block transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Kategori
            </a>

            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Tambah Kategori</h1>
            <p class="text-slate-500 text-sm font-medium">Buat kategori baru untuk mengelompokkan event.</p>
        </div>

        @if ($errors->any())
            <div class="mb-8 p-6 bg-red-50 border border-red-200 rounded-2xl">
                <div class="flex items-center gap-3 text-red-600 font-bold mb-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <h3>Gagal Menyimpan Kategori</h3>
                </div>
                <ul class="list-disc list-inside text-sm text-red-500 space-y-1 ml-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div
            class="bg-white dark:bg-slate-800 p-8 sm:p-10 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-xl shadow-indigo-500/5">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">
                        Nama Kategori
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        placeholder="Contoh: Seminar, Musik, Teknologi"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all">

                    @error('name')
                        <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex items-center justify-end gap-4">
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-6 py-4 rounded-xl text-slate-500 font-bold hover:bg-slate-50 dark:hover:bg-white/5 transition uppercase tracking-widest text-xs">
                        Batal
                    </a>

                    <button type="submit"
                        class="px-8 py-4 bg-[#6366f1] hover:bg-indigo-700 text-white font-black rounded-xl shadow-lg shadow-indigo-500/30 transition-all uppercase tracking-widest text-xs">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
