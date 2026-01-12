<x-app-layout>
    <div class="mb-10">
        <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Tiket Saya</h1>
        <p class="text-slate-500 text-sm font-medium">Daftar event yang Anda ikuti.</p>
    </div>

    <div class="mb-12">
        <h3 class="flex items-center gap-3 text-lg font-bold text-slate-800 dark:text-white mb-6">
            <i class="fa-solid fa-ticket text-[#6366f1]"></i> Tiket Aktif
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($activeEvents as $pendaftaran)
                <div class="bg-white dark:bg-slate-800 rounded-[2rem] border border-slate-100 dark:border-white/5 overflow-hidden shadow-xl shadow-indigo-500/5 group hover:-translate-y-1 transition-transform duration-300">
                    <div class="bg-[#6366f1] p-6 text-white relative overflow-hidden">
                        <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                        <span class="inline-block px-2 py-1 bg-white/20 rounded-lg text-[10px] font-bold uppercase tracking-widest mb-2 border border-white/20">
                            {{ $pendaftaran->event->category->name }}
                        </span>
                        <h4 class="text-xl font-black leading-tight">{{ $pendaftaran->event->title }}</h4>
                    </div>

                    <div class="p-6">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="w-12 h-12 bg-indigo-50 dark:bg-white/5 rounded-2xl flex flex-col items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold shrink-0 border border-indigo-100 dark:border-white/5">
                                <span class="text-sm uppercase">{{ \Carbon\Carbon::parse($pendaftaran->event->start_date)->format('M') }}</span>
                                <span class="text-xl leading-none">{{ \Carbon\Carbon::parse($pendaftaran->event->start_date)->format('d') }}</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Waktu & Lokasi</p>
                                <p class="text-sm font-bold text-slate-800 dark:text-white">{{ \Carbon\Carbon::parse($pendaftaran->event->start_date)->format('H:i') }} WIB</p>
                                <p class="text-xs text-slate-500 line-clamp-1">{{ $pendaftaran->event->location }}</p>
                            </div>
                        </div>

                        <div class="border-t border-dashed border-slate-200 dark:border-white/10 my-4"></div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                               @php
                                 $status = $pendaftaran->status;
                                @endphp
                                @if($status === 'confirmed')
                                <span class="inline-flex items-center gap-2 text-green-600 text-xs font-bold">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    SUCCESS
                                </span>
                                @elseif($status === 'pending')
                                <span class="inline-flex items-center gap-2 text-yellow-700 text-xs font-bold">
                                    <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                    MENUNGGU KONFIRMASI
                                </span>
                                @elseif($status === 'rejected')
                                <span class="inline-flex items-center gap-2 text-red-600 text-xs font-bold">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    DITOLAK
                                </span>
                                @else
                                <span class="inline-flex items-center gap-2 text-slate-500 text-xs font-bold">
                                    <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                    {{ strtoupper($status) }}
                                </span>
                                @endif
                            </div>
                            <a href="{{ route('events.show', $pendaftaran->event->id) }}" class="text-xs font-black text-[#6366f1] hover:underline uppercase tracking-widest">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center border-2 border-dashed border-slate-200 dark:border-white/10 rounded-[2rem]">
                    <i class="fa-solid fa-ticket-simple text-4xl text-slate-300 mb-4"></i>
                    <p class="text-slate-500 font-medium">Belum ada tiket aktif.</p>
                    <a href="{{ route('mahasiswa.explore') }}" class="mt-4 inline-block px-6 py-2 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-[#6366f1] transition uppercase tracking-widest">
                        Cari Event
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <div>
        <h3 class="flex items-center gap-3 text-lg font-bold text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-200 dark:border-white/5 pb-4">
            <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Kegiatan
        </h3>

        <div class="space-y-4">
            @forelse($historyEvents as $pendaftaran)
                <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-100 dark:border-white/5 flex flex-col md:flex-row items-center gap-6 opacity-75 hover:opacity-100 transition">
                    <div class="w-full md:w-24 h-24 rounded-2xl overflow-hidden shrink-0">
                        <img src="{{ asset('storage/' . $pendaftaran->event->image) }}" class="w-full h-full object-cover grayscale">
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h4 class="text-lg font-bold text-slate-800 dark:text-white mb-1">{{ $pendaftaran->event->title }}</h4>
                        <p class="text-sm text-slate-500">
                            {{ \Carbon\Carbon::parse($pendaftaran->event->start_date)->translatedFormat('d F Y') }} • {{ $pendaftaran->event->location }}
                        </p>
                    </div>
                    <div>
                        <span class="px-4 py-2 bg-slate-100 dark:bg-white/5 text-slate-500 rounded-xl text-xs font-bold uppercase tracking-widest">
                            Selesai
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-center text-slate-400 text-sm italic py-8">Belum ada riwayat kegiatan.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
