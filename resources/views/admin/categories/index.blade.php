<x-app-layout>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Kelola Kategori</h1>
            <p class="text-slate-500 text-sm font-medium">
                Kategori dipakai penyelenggara saat membuat event. Kategori yang sudah dipakai event tidak bisa dihapus.
            </p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
            class="px-6 py-3 bg-[#6366f1] hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Kategori
        </a>
    </div>

    <div
        class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 dark:bg-white/5 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                        <th class="p-6 w-16">No</th>
                        <th class="p-6">Kategori</th>
                        <th class="p-6 text-center">Jumlah Event</th>
                        <th class="p-6">Dibuat</th>
                        <th class="p-6 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                            <td class="p-6 text-slate-500 font-bold">{{ $loop->iteration }}</td>

                            <td class="p-6">
                                <div class="font-bold text-slate-800 dark:text-white">{{ $category->name }}</div>
                                <div class="text-xs text-slate-400">ID: {{ $category->id }}</div>
                            </td>

                            <td class="p-6 text-center">
                                <span
                                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 border border-indigo-100 text-[10px] font-black uppercase tracking-widest">
                                    <i class="fa-solid fa-calendar-check"></i>
                                    {{ $category->events->count() }} event
                                </span>
                            </td>

                            <td class="p-6">
                                <span class="text-sm font-medium text-slate-500">
                                    {{ $category->created_at->format('d M Y') }}
                                </span>
                            </td>

                            <td class="p-6">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-white/10 transition border border-slate-200 dark:border-white/10"
                                        title="Edit Kategori">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini? Jika kategori sudah dipakai event, sistem akan menolak penghapusan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition border border-red-100"
                                            title="Hapus Kategori">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400">
                                <div
                                    class="inline-flex w-16 h-16 bg-slate-100 dark:bg-white/5 rounded-full items-center justify-center mb-4">
                                    <i class="fa-solid fa-tags text-2xl text-slate-300"></i>
                                </div>
                                <p class="font-medium">Belum ada kategori.</p>
                                <p class="text-sm">Klik tombol “Tambah Kategori” untuk membuat kategori baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
