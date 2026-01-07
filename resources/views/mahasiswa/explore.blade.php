<x-app-layout>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Jelajahi Event</h1>
            <p class="text-slate-500 text-sm font-medium">Temukan kegiatan seru untuk diikuti.</p>
        </div>

        <form action="{{ route('mahasiswa.explore') }}" method="GET" class="relative w-full sm:w-72">
            <input type="text" name="search" placeholder="Cari event..." value="{{ request('search') }}"
                class="w-full pl-12 pr-4 py-3 bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl outline-none focus:border-[#6366f1] focus:ring-1 focus:ring-[#6366f1] transition text-sm">
            <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)
            <div class="bg-white dark:bg-slate-800 rounded-[2rem] border border-slate-100 dark:border-white/5 overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col h-full">
                <div class="h-48 overflow-hidden relative">
                    <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover">
                    <div class="absolute top-4 left-4">
                         <span class="px-3 py-1 bg-white/90 backdrop-blur rounded-full text-[10px] font-black uppercase tracking-widest text-slate-800">
                             {{ $event->category->name }}
                         </span>
                    </div>
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    <div class="text-[10px] font-bold text-[#6366f1] uppercase tracking-widest mb-2">
                        {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d M Y') }}
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white leading-tight mb-4 line-clamp-2">
                        {{ $event->title }}
                    </h3>

                    <div class="mt-auto pt-6 border-t border-slate-50 dark:border-white/5 flex items-center justify-between">
                        <div class="text-xs text-slate-500 font-medium truncate max-w-[120px]">
                            <i class="fa-solid fa-location-dot mr-1"></i> {{ $event->location }}
                        </div>
                        <a href="{{ route('events.show', $event->id) }}" class="px-4 py-2 bg-slate-900 dark:bg-white text-white dark:text-black rounded-lg text-xs font-bold hover:bg-[#6366f1] dark:hover:bg-indigo-400 dark:hover:text-white transition uppercase tracking-wide">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20">
                <p class="text-slate-400 font-medium">Tidak ditemukan event yang cocok.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
