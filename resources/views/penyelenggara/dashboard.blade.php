<x-app-layout>
    <div class="mb-10">
        <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Dashboard Penyelenggara</h1>
        <p class="text-slate-500 text-sm font-medium">Pantau performa event dan partisipasi mahasiswa.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] border border-slate-100 dark:border-white/5 shadow-xl shadow-indigo-500/5 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:scale-110 transition-transform duration-500">
                <i class="fa-solid fa-bullhorn text-6xl text-[#6366f1]"></i>
            </div>
            <p class="text-slate-500 text-xs font-black uppercase tracking-widest mb-2">Event Aktif</p>
            <h3 class="text-5xl font-black text-slate-800 dark:text-white">{{ $activeEvents }}</h3>
            <p class="text-slate-400 text-sm mt-4 font-medium">Sedang dipublikasikan</p>
        </div>

        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] border border-slate-100 dark:border-white/5 shadow-xl shadow-indigo-500/5 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:scale-110 transition-transform duration-500">
                <i class="fa-solid fa-users-viewfinder text-6xl text-[#6366f1]"></i>
            </div>
            <p class="text-slate-500 text-xs font-black uppercase tracking-widest mb-2">Total Peserta</p>
            <h3 class="text-5xl font-black text-slate-800 dark:text-white">{{ $totalParticipants }}</h3>
            <p class="text-slate-400 text-sm mt-4 font-medium">Mahasiswa mendaftar</p>
        </div>

        <div class="bg-[#6366f1] p-8 rounded-[2rem] shadow-xl shadow-indigo-500/30 relative overflow-hidden group text-white">
            <div class="absolute top-0 right-0 p-8 opacity-20 group-hover:rotate-12 transition-transform duration-500">
                <i class="fa-solid fa-layer-group text-6xl"></i>
            </div>
            <p class="text-white/70 text-xs font-black uppercase tracking-widest mb-2">Total Event</p>
            <h3 class="text-5xl font-black">{{ $totalEvents }}</h3>
            <p class="text-indigo-200 text-sm mt-4 font-medium">Termasuk Draft & Selesai</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 dark:border-white/5 flex justify-between items-center">
            <h3 class="text-xl font-bold text-slate-800 dark:text-white">Event Terbaru Anda</h3>
            <a href="{{ route('penyelenggara.events.index') }}" class="text-xs font-bold text-[#6366f1] hover:text-indigo-500 uppercase tracking-widest">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 dark:bg-white/5 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                    <tr>
                        <th class="p-6">Judul Event</th>
                        <th class="p-6">Tanggal</th>
                        <th class="p-6">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse($recentEvents as $event)
                    <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition">
                        <td class="p-6 font-bold text-slate-800 dark:text-white">{{ $event->title }}</td>
                        <td class="p-6 text-sm text-slate-500">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</td>
                        <td class="p-6">
                            @if($event->status == 'published')
                                <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-[10px] font-bold uppercase">Published</span>
                            @elseif($event->status == 'draft')
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-bold uppercase">Draft</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-[10px] font-bold uppercase">Rejected</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-8 text-center text-slate-400">Belum ada event yang dibuat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
