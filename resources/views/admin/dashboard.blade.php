<x-app-layout>
    <div class="mb-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Dashboard Admin</h1>
            <p class="text-slate-500 text-sm font-medium">Ringkasan aktivitas dan persetujuan event.</p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl shadow-sm">
            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
            <span class="text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Sistem Online</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] border border-slate-100 dark:border-white/5 shadow-xl shadow-indigo-500/5 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:scale-110 transition-transform duration-500">
                <i class="fa-solid fa-users text-6xl text-[#6366f1]"></i>
            </div>
            <p class="text-slate-500 text-xs font-black uppercase tracking-widest mb-2">Total User</p>
            <h3 class="text-5xl font-black text-slate-800 dark:text-white">{{ $totalUser }}</h3>
            <p class="text-slate-400 text-sm mt-4 font-medium">Mahasiswa & Penyelenggara</p>
        </div>

        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] border border-slate-100 dark:border-white/5 shadow-xl shadow-indigo-500/5 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:scale-110 transition-transform duration-500">
                <i class="fa-regular fa-calendar-check text-6xl text-[#6366f1]"></i>
            </div>
            <p class="text-slate-500 text-xs font-black uppercase tracking-widest mb-2">Total Event</p>
            <h3 class="text-5xl font-black text-slate-800 dark:text-white">{{ $totalEvents }}</h3>
            <p class="text-slate-400 text-sm mt-4 font-medium">Terdaftar di sistem</p>
        </div>

        <div class="bg-[#6366f1] p-8 rounded-[2rem] shadow-xl shadow-indigo-500/30 relative overflow-hidden group text-white">
            <div class="absolute top-0 right-0 p-8 opacity-20 group-hover:rotate-12 transition-transform duration-500">
                <i class="fa-solid fa-file-signature text-6xl"></i>
            </div>
            <p class="text-white/70 text-xs font-black uppercase tracking-widest mb-2">Butuh Review</p>
            <h3 class="text-5xl font-black">{{ $antrianEvents->count() }}</h3>
            <p class="text-indigo-200 text-sm mt-4 font-medium">Event menunggu persetujuan</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 dark:border-white/5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Antrian Persetujuan Event</h3>
                <p class="text-slate-500 text-sm mt-1">Review event sebelum dipublikasikan ke mahasiswa.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-white/5 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                        <th class="p-6">Event</th>
                        <th class="p-6">Penyelenggara</th>
                        <th class="p-6">Kategori</th>
                        <th class="p-6">Tgl Pelaksanaan</th>
                        <th class="p-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse($antrianEvents as $event)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                        <td class="p-6">
                            <div class="font-bold text-slate-800 dark:text-white">{{ $event->title }}</div>
                            <div class="text-xs text-slate-400 mt-1 truncate max-w-xs">{{ Str::limit($event->location, 30) }}</div>
                        </td>
                        <td class="p-6">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">
                                    {{ substr($event->user->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ $event->user->name }}</span>
                            </div>
                        </td>
                        <td class="p-6">
                            <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-white/10 text-slate-500 dark:text-slate-300 text-[10px] font-bold uppercase tracking-wide">
                                {{ $event->category->name }}
                            </span>
                        </td>
                        <td class="p-6">
                            <span class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                            </span>
                        </td>
                        <td class="p-6">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('admin.events.show', $event->id) }}" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 transition" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <form action="{{ route('admin.events.approve', $event->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Yakin ingin menyetujui event ini?')" class="w-10 h-10 flex items-center justify-center rounded-xl bg-green-100 text-green-600 hover:bg-green-500 hover:text-white transition shadow-lg shadow-green-500/20" title="Setujui (Approve)">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.events.reject', $event->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Yakin ingin menolak event ini?')" class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-100 text-red-600 hover:bg-red-500 hover:text-white transition shadow-lg shadow-red-500/20" title="Tolak (Reject)">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center">
                            <div class="inline-flex w-16 h-16 bg-slate-100 dark:bg-white/5 rounded-full items-center justify-center mb-4 text-slate-300">
                                <i class="fa-solid fa-check-double text-2xl"></i>
                            </div>
                            <p class="text-slate-500 font-medium">Tidak ada antrian event saat ini.</p>
                            <p class="text-slate-400 text-sm">Semua event sudah direview.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
