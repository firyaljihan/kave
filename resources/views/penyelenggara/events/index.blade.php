<x-app-layout>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Kelola Event</h1>
            <p class="text-slate-500 text-sm font-medium">Buat, edit, dan pantau status event Anda.</p>
        </div>
        <a href="{{ route('penyelenggara.events.create') }}" class="px-6 py-3 bg-[#6366f1] hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Buat Event Baru
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-white/5 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                        <th class="p-6">Info Event</th>
                        <th class="p-6">Jadwal & Lokasi</th>
                        <th class="p-6">Status</th>
                        <th class="p-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse($events as $event)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">

                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . $event->image) }}" class="w-16 h-16 rounded-xl object-cover shadow-sm">
                                <div>
                                    <div class="font-bold text-slate-800 dark:text-white line-clamp-1 text-lg">
                                        {{ $event->title }}
                                    </div>
                                    <div class="text-xs text-slate-400 mt-1 uppercase tracking-wide font-bold">
                                        {{ $event->category->name }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="p-6">
                            <div class="text-sm font-bold text-slate-600 dark:text-slate-300">
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                            </div>
                            <div class="text-xs text-slate-400 mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot"></i> {{ Str::limit($event->location, 20) }}
                            </div>
                        </td>

                        <td class="p-6">
                            @if($event->status == 'published')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-100 text-green-600 text-[10px] font-bold uppercase tracking-wide border border-green-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Published
                                </span>
                            @elseif($event->status == 'pending')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-yellow-100 text-yellow-600 text-[10px] font-bold uppercase tracking-wide border border-yellow-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Menunggu Review
                                </span>
                            @elseif($event->status == 'draft')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold uppercase tracking-wide border border-slate-200">
                                    Draft
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 text-red-600 text-[10px] font-bold uppercase tracking-wide border border-red-200">
                                    Ditolak
                                </span>
                            @endif
                        </td>

                        <td class="p-6">
                            <div class="flex items-center justify-center gap-2">

                                {{-- 1. TOMBOL AJUKAN PUBLISH (Hanya muncul jika status DRAFT) --}}
                                @if($event->status == 'draft')
                                    <form action="{{ route('penyelenggara.events.submit', $event->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin data sudah benar dan ingin mengajukan event ini ke Admin?')"
                                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-[#6366f1] text-white hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30 group/submit relative"
                                            title="Ajukan Publish ke Admin">
                                            <i class="fa-solid fa-paper-plane"></i>
                                            <span class="absolute bottom-full mb-2 hidden group-hover/submit:block w-max px-2 py-1 bg-black text-white text-[10px] rounded">Ajukan</span>
                                        </button>
                                    </form>
                                @endif

                                {{-- 2. TOMBOL LIHAT PESERTA --}}
                                <a href="{{ route('penyelenggara.events.participants', $event->id) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition border border-indigo-100" title="Lihat Peserta">
                                    <i class="fa-solid fa-users"></i>
                                </a>

                                {{-- 3. TOMBOL EDIT (Disembunyikan jika status published agar data aman) --}}
                                @if($event->status != 'published')
                                    <a href="{{ route('penyelenggara.events.edit', $event->id) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition border border-slate-200" title="Edit Event">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                @endif

                                {{-- 4. TOMBOL HAPUS --}}
                                <form action="{{ route('penyelenggara.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus event ini? Data yang dihapus tidak bisa dikembalikan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition border border-red-100" title="Hapus Event">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center text-slate-400">
                            <div class="inline-flex w-16 h-16 bg-slate-100 dark:bg-white/5 rounded-full items-center justify-center mb-4">
                                <i class="fa-solid fa-box-open text-2xl text-slate-300"></i>
                            </div>
                            <p class="font-medium">Belum ada event.</p>
                            <p class="text-sm">Klik tombol "Buat Event Baru" di atas untuk memulai.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
