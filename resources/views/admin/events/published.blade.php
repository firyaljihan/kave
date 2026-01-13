<x-app-layout>
    <div class="py-10 max-w-6xl mx-auto px-4">

        {{-- Header + Tombol Kembali (di atas) --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">
                    Event Terposting
                </h1>
                <p class="text-slate-500 text-sm font-medium">
                    Daftar event yang sedang tampil di user (status: published).
                </p>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-black uppercase tracking-widest hover:bg-[#6366f1] transition shadow-lg shadow-indigo-500/10">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-[2rem] border border-slate-100 dark:border-white/5 overflow-hidden shadow-xl shadow-indigo-500/5">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 dark:bg-white/5">
                        <tr class="text-left text-slate-500 dark:text-slate-300 uppercase tracking-widest text-[10px] font-black">
                            <th class="px-6 py-4">Event</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Penyelenggara</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Lokasi</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        @forelse($events as $event)
                            <tr class="text-slate-700 dark:text-slate-100 hover:bg-slate-50/60 dark:hover:bg-white/5 transition">
                                <td class="px-6 py-5">
                                    <div class="font-black text-slate-800 dark:text-white leading-tight">
                                        {{ $event->title }}
                                    </div>
                                    <div class="text-xs text-slate-400 font-bold tracking-wide mt-1">
                                        #{{ $event->id }}
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-indigo-50 dark:bg-white/5 border border-indigo-100 dark:border-white/5 text-indigo-700 dark:text-indigo-300 text-[10px] font-black uppercase tracking-widest">
                                        {{ $event->category->name ?? '-' }}
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-slate-600 dark:text-slate-300 font-bold">
                                    {{ $event->user->name ?? '-' }}
                                </td>

                                <td class="px-6 py-5 text-slate-600 dark:text-slate-300 font-bold">
                                    {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d M Y') }}
                                </td>

                                <td class="px-6 py-5 text-slate-500 dark:text-slate-400 font-medium max-w-[260px]">
                                    <div class="line-clamp-2">
                                        {{ $event->location }}
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.events.show', $event->id) }}"
                                           class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest hover:bg-[#6366f1] transition shadow-lg shadow-indigo-500/10">
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </a>

                                        <form action="{{ route('admin.events.published.destroy', $event->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Turunkan event ini dari tampilan user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-red-600 text-white text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition shadow-lg shadow-red-500/10">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-14 text-center">
                                    <i class="fa-solid fa-calendar-xmark text-4xl text-slate-300 mb-4"></i>
                                    <p class="text-slate-500 font-medium">Belum ada event yang terposting.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
