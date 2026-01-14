<x-app-layout>
    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Kelola Pengguna</h1>
            <p class="text-slate-500 text-sm font-medium">Daftar semua akun terdaftar (Mahasiswa & Penyelenggara).</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-6 py-3 bg-[#6366f1] hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition flex items-center gap-2">
            <i class="fa-solid fa-user-plus"></i> Tambah User Baru
        </a>
    </div>

    {{-- Tabel User --}}
    <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-white/5 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                        <th class="p-6">Nama Pengguna</th>
                        <th class="p-6">Role / Peran</th>
                        <th class="p-6">Terdaftar</th>
                        <th class="p-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                        {{-- Kolom Nama --}}
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800 dark:text-white">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Kolom Role Badge --}}
                        <td class="p-6">
                            @if($user->role === 'admin')
                                <span class="px-3 py-1 rounded-full bg-slate-900 text-white text-[10px] font-bold uppercase">Admin</span>
                            @elseif($user->role === 'penyelenggara')
                                <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-600 text-[10px] font-bold uppercase">Penyelenggara</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold uppercase">Mahasiswa</span>
                            @endif
                        </td>

                        {{-- Kolom Tanggal Daftar --}}
                        <td class="p-6">
                            <span class="text-sm font-medium text-slate-500">
                                {{ $user->created_at->format('d M Y') }}
                            </span>
                        </td>

                        {{-- Kolom Aksi (Update & Delete) --}}
                        <td class="p-6">
                            <div class="flex items-center justify-center gap-2">

                                {{-- FORM 1: Update Role --}}
                                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')

                                    <select name="role" class="text-xs border-slate-200 rounded-lg focus:ring-indigo-500 py-2">
                                        <option value="mahasiswa" {{ $user->role == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                        <option value="penyelenggara" {{ $user->role == 'penyelenggara' ? 'selected' : '' }}>Penyelenggara</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>

                                    <button type="submit" class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition" title="Simpan Perubahan Role">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                    </button>
                                </form>

                                {{-- FORM 2: Hapus User --}}
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus user {{ $user->name }}? Data ini tidak bisa dikembalikan.')"
                                            class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition"
                                            title="Hapus User">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400">Belum ada user lain.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-6 border-t border-slate-100 dark:border-white/5">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
