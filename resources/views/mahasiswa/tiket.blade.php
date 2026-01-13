<?php
/** @var \App\Models\Pendaftaran $ticket */
?>
<x-app-layout>
    <div class="py-12 flex flex-col items-center justify-center px-4">

        <div class="w-full max-w-4xl mb-8">
            <a href="{{ route('mahasiswa.dashboard') }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-indigo-600 transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="w-full max-w-4xl bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[500px] relative">

            <div class="w-full md:w-[35%] relative bg-slate-900 h-64 md:h-auto overflow-hidden">
                <img src="{{ asset('storage/' . $ticket->event->image) }}" class="absolute inset-0 w-full h-full object-cover opacity-60 scale-110 blur-[2px]">
                <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-indigo-900/90 via-slate-900/50 to-transparent"></div>

                <div class="hidden md:block absolute -right-4 top-0 w-8 h-8 bg-gray-100 dark:bg-gray-900 rounded-full z-10"></div>
                <div class="hidden md:block absolute -right-4 bottom-0 w-8 h-8 bg-gray-100 dark:bg-gray-900 rounded-full z-10"></div>

                <div class="absolute inset-0 p-10 flex flex-col justify-between text-white z-0">
                    <div>
                        <div class="flex items-center gap-2 mb-6">
                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-green-300">Official E-Ticket</span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-black leading-none mb-4 tracking-tight drop-shadow-lg">
                            {{ $ticket->event->title }}
                        </h2>
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white/10 backdrop-blur-sm border border-white/10">
                            <i class="fa-regular fa-calendar text-indigo-300"></i>
                            <span class="text-sm font-bold tracking-wide">
                                {{ \Carbon\Carbon::parse($ticket->event->start_date)->translatedFormat('d F Y') }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-2">Diselenggarakan Oleh</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                                <i class="fa-solid fa-crown text-white text-xs"></i>
                            </div>
                            <span class="text-sm font-bold truncate opacity-90">{{ optional($ticket->event->user)->name ?? 'Panitia Event' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-[65%] p-10 md:p-14 flex flex-col justify-between relative bg-white dark:bg-slate-800">

                <div class="hidden md:block absolute left-0 top-8 bottom-8 border-l-2 border-dashed border-slate-200 dark:border-slate-700"></div>

                <div class="hidden md:block absolute -left-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-gray-100 dark:bg-gray-900 rounded-full border border-gray-200 dark:border-slate-700 z-10"></div>

                <div class="flex flex-col md:flex-row justify-between items-start border-b border-slate-100 dark:border-white/5 pb-8 mb-8">
                    <div class="mb-4 md:mb-0">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Pemegang Tiket</p>
                        <h3 class="text-3xl font-black text-slate-800 dark:text-white mb-1">{{ Auth::user()->name }}</h3>
                        <p class="text-slate-500 font-medium text-sm flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-indigo-400"></i> {{ Auth::user()->email }}
                        </p>
                    </div>
                    <div class="text-left md:text-right bg-slate-50 dark:bg-white/5 p-4 rounded-2xl border border-slate-100 dark:border-white/5">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">ID Tiket</p>
                        <p class="text-3xl font-mono font-black text-indigo-600 tracking-tighter">#{{ $ticket->id }}</p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-10">

                    <div class="flex-1 space-y-6">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Jam Mulai</p>
                            <p class="text-2xl font-bold text-slate-800 dark:text-white">
                                {{ \Carbon\Carbon::parse($ticket->event->start_date)->format('H:i') }} <span class="text-base text-slate-400 font-medium">WIB</span>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Lokasi</p>
                            <p class="text-base font-bold text-slate-800 dark:text-white leading-relaxed">
                                {{ $ticket->event->location }}
                            </p>
                        </div>
                    </div>

                    <div class="shrink-0 flex flex-col items-center md:items-end">
                        <div class="bg-white p-3 rounded-2xl border-2 border-slate-100 shadow-sm">
                             {!! QrCode::size(140)->margin(0)->generate("KAVE-TIKET-" . $ticket->id . "-" . $ticket->user->email) !!}
                        </div>
                        <div class="mt-3 flex items-center gap-2 text-slate-400">
                            <i class="fa-solid fa-scan text-sm animate-pulse"></i>
                            <p class="text-[10px] font-bold uppercase tracking-widest">Scan di Pintu Masuk</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 dark:border-white/5 flex items-center justify-between">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold uppercase tracking-wide border border-green-100">
                        <i class="fa-solid fa-circle-check"></i> Paid & Valid
                    </div>
                    <p class="text-[10px] text-slate-400 font-medium uppercase tracking-widest">
                        Tiket ini bukti sah kepesertaan
                    </p>
                </div>

            </div>
        </div>

        <p class="mt-8 text-slate-400 text-xs text-center font-medium">
            © {{ date('Y') }} KAVE Event System.
        </p>

    </div>
</x-app-layout>
