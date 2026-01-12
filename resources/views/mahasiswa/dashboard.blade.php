<x-app-layout>
    <div class="mb-10">
        <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Tiket Saya</h1>
        <p class="text-slate-500 text-sm font-medium">Daftar event yang Anda ikuti.</p>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3 text-green-700 font-bold text-sm">
            <i class="fa-solid fa-check-circle text-lg"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-12">
        <h3 class="flex items-center gap-3 text-lg font-bold text-slate-800 dark:text-white mb-6">
            <i class="fa-solid fa-ticket text-[#6366f1]"></i> Tiket Aktif
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($activeEvents as $pendaftaran)
                <div class="bg-white dark:bg-slate-800 rounded-[2rem] border border-slate-100 dark:border-white/5 overflow-hidden shadow-xl shadow-indigo-500/5 group hover:-translate-y-1 transition-transform duration-300 flex flex-col h-full">

                    {{-- Header Card --}}
                    <div class="bg-[#6366f1] p-6 text-white relative overflow-hidden shrink-0">
                        <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                        <span class="inline-block px-2 py-1 bg-white/20 rounded-lg text-[10px] font-bold uppercase tracking-widest mb-2 border border-white/20">
                            {{ $pendaftaran->event->category->name }}
                        </span>
                        <h4 class="text-xl font-black leading-tight line-clamp-2">{{ $pendaftaran->event->title }}</h4>
                    </div>

                    {{-- Body Card --}}
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-start gap-4 mb-4">
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

                        {{-- Spacer agar footer selalu di bawah --}}
                        <div class="mt-auto">
                            <div class="border-t border-dashed border-slate-200 dark:border-white/10 my-4"></div>

                            <div class="flex items-end justify-between">
                                <div class="flex flex-col gap-2">

                                    {{-- LOGIKA STATUS & TOMBOL TIKET --}}
                                    @if($pendaftaran->status == 'confirmed')
                                        {{-- 1. Jika Confirmed: Tampilkan Status Hijau & Tombol Tiket --}}
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                            <span class="text-xs font-bold text-green-600 uppercase tracking-wide">Confirmed</span>
                                        </div>

                                        <a href="{{ route('mahasiswa.tiket.show', $pendaftaran->id) }}"
                                           class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-lg hover:bg-indigo-600 transition shadow-lg shadow-indigo-500/20 mt-1">
                                            <i class="fa-solid fa-qrcode"></i> Lihat Tiket
                                        </a>

                                    @elseif($pendaftaran->status == 'pending' && $pendaftaran->payment_proof)
                                        {{-- 2. Jika Pending TAPI ada Bukti Bayar: Tampilkan Status Kuning --}}
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span>
                                            <span class="text-xs font-bold text-yellow-600 uppercase tracking-wide">Verifikasi</span>
                                        </div>
                                        <p class="text-[10px] text-slate-400 mt-1 leading-tight">Bukti terkirim.<br>Menunggu admin.</p>

                                    @else
                                        {{-- 3. Default Pending/Rejected --}}
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">{{ ucfirst($pendaftaran->status) }}</span>
                                        </div>
                                    @endif

                                </div>

                                {{-- Link Detail --}}
                                <a href="{{ route('events.show', $pendaftaran->event->id) }}" class="text-xs font-black text-[#6366f1] hover:underline uppercase tracking-widest mb-1">
                                    Detail
                                </a>
                            </div>
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

    {{-- Riwayat Kegiatan --}}
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
