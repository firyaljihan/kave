<x-app-layout>
    <div class="mb-10">
        <a href="{{ route('admin.dashboard') }}"
           class="text-slate-400 hover:text-indigo-600 text-sm font-bold mb-4 inline-block transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Dashboard Admin
        </a>

        <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Detail Event (Admin)</h1>
        <p class="text-slate-500 text-sm font-medium">Halaman review event untuk approve / reject.</p>
    </div>

    <div class="grid lg:grid-cols-3 gap-8 items-start">

        {{-- KIRI: Poster + Konten --}}
        <div class="lg:col-span-2 space-y-8">

            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-white/5 overflow-hidden shadow-xl shadow-indigo-500/5">
                @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                        class="w-full h-auto object-cover">
                @else
                    <div class="p-12 text-center text-slate-400">
                        Poster belum tersedia.
                    </div>
                @endif
            </div>

            <div class="bg-white dark:bg-slate-800 p-8 sm:p-10 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-sm">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-black uppercase tracking-widest border border-indigo-100">
                        {{ $event->category->name ?? '-' }}
                    </span>

                    @if($event->status === 'published')
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-black uppercase tracking-widest border border-green-200">
                            Published
                        </span>
                    @elseif($event->status === 'pending')
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-black uppercase tracking-widest border border-yellow-200">
                            Pending
                        </span>
                    @elseif($event->status === 'draft')
                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-black uppercase tracking-widest border border-slate-200">
                            Draft
                        </span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-black uppercase tracking-widest border border-red-200">
                            {{ $event->status }}
                        </span>
                    @endif
                </div>

                <h2 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-white leading-tight">
                    {{ $event->title }}
                </h2>

                <div class="mt-4 flex flex-wrap items-center gap-6 text-sm font-medium text-slate-500">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-user-tie text-[#6366f1]"></i>
                        <span>Penyelenggara: <span class="font-bold text-slate-800 dark:text-white">{{ $event->user->name ?? '-' }}</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-regular fa-calendar text-[#6366f1]"></i>
                        <span>Dibuat: {{ $event->created_at?->format('d M Y, H:i') }}</span>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-3">Deskripsi</h3>
                    <div class="text-slate-600 dark:text-slate-300 whitespace-pre-line leading-relaxed">
                        {{ $event->description }}
                    </div>
                </div>
            </div>
        </div>

        {{-- KANAN: Detail + Aksi --}}
        <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-24">

            <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] border border-slate-100 dark:border-white/5 shadow-sm">
                <h3 class="font-bold text-xl mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-[#6366f1]"></i> Detail Pelaksanaan
                </h3>

                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 bg-indigo-50 dark:bg-white/5 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
                            <i class="fa-regular fa-clock text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Waktu</p>
                            <p class="font-bold text-slate-800 dark:text-white">
                                {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('l, d F Y • H:i') }}
                            </p>
                            <p class="text-sm text-slate-500">
                                s.d {{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('l, d F Y • H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-10 h-10 bg-indigo-50 dark:bg-white/5 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
                            <i class="fa-solid fa-location-dot text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Lokasi</p>
                            <p class="font-bold text-slate-800 dark:text-white leading-tight">{{ $event->location }}</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-10 h-10 bg-indigo-50 dark:bg-white/5 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
                            <i class="fa-solid fa-ticket text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Harga</p>
                            <p class="font-black text-2xl text-[#6366f1]">
                                {{ $event->price == 0 ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                @if($event->status === 'published')
                    <div class="mt-8">
                        <a href="{{ route('events.show', $event->id) }}" target="_blank"
                           class="block w-full py-3 rounded-xl bg-slate-900 text-white font-bold text-center hover:bg-slate-800 transition">
                            <i class="fa-solid fa-eye mr-2"></i> Buka Halaman Publik
                        </a>
                    </div>
                @endif
            </div>

            <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] border border-slate-100 dark:border-white/5 shadow-sm">
                <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Aksi Admin</h3>

                @if($event->status === 'pending')
                    <div class="grid grid-cols-2 gap-3">
                        <form action="{{ route('admin.events.approve', $event->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                onclick="return confirm('Yakin ingin menyetujui event ini?')"
                                class="w-full py-3 rounded-xl bg-green-600 hover:bg-green-500 text-white font-black text-xs uppercase tracking-widest transition">
                                <i class="fa-solid fa-check mr-2"></i> Approve
                            </button>
                        </form>

                        <form action="{{ route('admin.events.reject', $event->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                onclick="return confirm('Yakin ingin menolak event ini?')"
                                class="w-full py-3 rounded-xl bg-red-600 hover:bg-red-500 text-white font-black text-xs uppercase tracking-widest transition">
                                <i class="fa-solid fa-xmark mr-2"></i> Reject
                            </button>
                        </form>
                    </div>
                @else
                    <p class="text-sm text-slate-500">
                        Event ini statusnya <span class="font-bold">{{ $event->status }}</span>.
                        Tombol approve/reject hanya muncul saat status <span class="font-bold">pending</span>.
                    </p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
