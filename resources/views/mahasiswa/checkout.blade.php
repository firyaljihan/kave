<x-app-layout>
    <div class="mb-10">
        <a href="{{ route('events.show', $event->id) }}"
           class="text-slate-400 hover:text-indigo-600 text-sm font-bold mb-4 inline-block transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Detail Event
        </a>

        <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Rincian Pendaftaran</h1>
        <p class="text-slate-500 text-sm font-medium">Periksa detail event dan (jika berbayar) upload bukti pembayaran.</p>
    </div>

    @if ($errors->any())
        <div class="mb-8 p-6 bg-red-50 border border-red-200 rounded-2xl">
            <div class="flex items-center gap-3 text-red-600 font-bold mb-2">
                <i class="fa-solid fa-circle-exclamation"></i>
                <h3>Gagal</h3>
            </div>
            <ul class="list-disc list-inside text-sm text-red-500 space-y-1 ml-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-8 items-start">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-indigo-100">
                        {{ $event->category->name }}
                    </span>

                    @if($event->price == 0)
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase tracking-widest border border-green-200">
                            Gratis
                        </span>
                    @else
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-[10px] font-black uppercase tracking-widest border border-yellow-200">
                            Berbayar
                        </span>
                    @endif
                </div>

                <h2 class="text-2xl font-black text-slate-800 dark:text-white">{{ $event->title }}</h2>

                <div class="mt-4 grid sm:grid-cols-2 gap-4 text-sm text-slate-600 dark:text-slate-300">
                    <div class="flex items-start gap-3">
                        <i class="fa-regular fa-clock text-[#6366f1] mt-1"></i>
                        <div>
                            <div class="font-bold text-slate-800 dark:text-white">Waktu</div>
                            <div>{{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('l, d F Y • H:i') }}</div>
                            <div class="text-slate-500">s.d {{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('l, d F Y • H:i') }}</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot text-[#6366f1] mt-1"></i>
                        <div>
                            <div class="font-bold text-slate-800 dark:text-white">Lokasi</div>
                            <div>{{ $event->location }}</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-ticket text-[#6366f1] mt-1"></i>
                        <div>
                            <div class="font-bold text-slate-800 dark:text-white">Harga</div>
                            <div class="font-black text-[#6366f1]">
                                {{ $event->price == 0 ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-user-tie text-[#6366f1] mt-1"></i>
                        <div>
                            <div class="font-bold text-slate-800 dark:text-white">Penyelenggara</div>
                            <div>{{ $event->user->name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-24">
            <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] border border-slate-100 dark:border-white/5 shadow-sm">
                <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Konfirmasi</h3>

                @if($event->price > 0)
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 mb-5">
                        <div class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Instruksi Pembayaran</div>
                        <div class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                            Silakan lakukan pembayaran ke:
                            <div class="mt-2 font-bold text-slate-800 dark:text-white">
                                {{ $event->bank_name ?? '-' }} • {{ $event->bank_account_number ?? '-' }}
                            </div>
                            <div class="text-slate-500">a.n {{ $event->bank_account_holder ?? '-' }}</div>

                        </div>
                    </div>
                @endif

                <form action="{{ route('mahasiswa.pendaftaran.store', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if($event->price > 0)
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">
                            Upload Bukti Transfer
                        </label>
                        <input type="file" name="payment_proof" required
                            class="w-full px-4 py-3 bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl text-sm">
                        <p class="text-xs text-slate-400 mt-2">Format: JPG/PNG, max 2MB.</p>
                    @endif

                    <button type="submit"
                        class="mt-6 w-full py-4 bg-[#6366f1] hover:bg-indigo-700 text-white font-black rounded-2xl shadow-lg shadow-indigo-500/20 transition uppercase tracking-widest text-xs">
                        {{ $event->price == 0 ? 'Daftar Sekarang' : 'Kirim Bukti & Daftar' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
