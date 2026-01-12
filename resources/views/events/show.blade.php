<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $event->title }} - Kave.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 antialiased">

    <nav class="bg-white border-b border-slate-100 fixed top-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 hover:opacity-80 transition">
                <div
                    class="w-8 h-8 bg-[#6366f1] rounded-lg flex items-center justify-center text-white font-black italic">
                    K</div>
                <span class="text-xl font-bold uppercase tracking-tight">Kave<span
                        class="text-[#6366f1]">.</span></span>
            </a>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-500 hover:text-[#6366f1]">Ke
                        Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-500 hover:text-[#6366f1]">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="relative pt-32 pb-12 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">
                <a href="/" class="hover:text-[#6366f1]">Home</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <a href="/#events" class="hover:text-[#6366f1]">Event</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-slate-800 line-clamp-1">{{ $event->title }}</span>
            </div>

            <div class="grid lg:grid-cols-3 gap-12">
                <div class="lg:col-span-2">
                    <span
                        class="inline-block px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-black uppercase tracking-widest mb-4 border border-indigo-100">
                        {{ $event->category->name }}
                    </span>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 leading-tight mb-6">
                        {{ $event->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-6 text-sm font-medium text-slate-500">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-user-tie text-[#6366f1]"></i>
                            <span>Oleh: <span class="text-slate-900 font-bold">{{ $event->user->name }}</span></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-calendar text-[#6366f1]"></i>
                            <span>Diposting: {{ $event->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid lg:grid-cols-3 gap-12 items-start">

            <div class="lg:col-span-2 space-y-12">
                <div class="rounded-[2rem] overflow-hidden shadow-2xl shadow-indigo-500/10 border border-slate-100">
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                        class="w-full h-auto object-cover">
                </div>

                <div class="prose prose-lg prose-indigo max-w-none text-slate-600">
                    <h3 class="font-bold text-slate-900 text-2xl mb-4">Tentang Event Ini</h3>
                    <div class="whitespace-pre-line leading-relaxed">
                        {{ $event->description }}
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 sticky top-24 space-y-8">

                <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100">
                    <h3 class="font-bold text-xl mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-[#6366f1]"></i> Detail Pelaksanaan
                    </h3>

                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div
                                class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
                                <i class="fa-regular fa-clock text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Waktu</p>
                                <p class="font-bold text-slate-800">
                                    {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('l, d F Y') }}</p>
                                <p class="text-sm text-slate-500">S.d
                                    {{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div
                                class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
                                <i class="fa-solid fa-location-dot text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Lokasi</p>
                                <p class="font-bold text-slate-800 leading-tight">{{ $event->location }}</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div
                                class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
                                <i class="fa-solid fa-ticket text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Harga Tiket
                                </p>
                                <p class="font-black text-2xl text-[#6366f1]">
                                    {{ $event->price == 0 ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 my-8"></div>

                    @auth
                        @if(Auth::user()->role === 'mahasiswa')
                            <a href="{{ route('mahasiswa.checkout', $event->id) }}"
                            class="inline-flex items-center justify-center w-full py-4 bg-[#6366f1] hover:bg-indigo-700 text-white font-black rounded-2xl shadow-lg shadow-indigo-500/30 transition uppercase tracking-widest text-xs">
                            <i class="fa-solid fa-ticket mr-2"></i> Daftar
                            </a>

                        @else
                            <div class="bg-slate-100 text-slate-500 p-4 rounded-xl text-center text-sm font-medium">
                                <i class="fa-solid fa-user-lock mb-2 block text-xl"></i>
                                Anda login sebagai <strong>{{ ucfirst(Auth::user()->role) }}</strong>.<br>
                                Pendaftaran hanya untuk Mahasiswa.
                            </div>
                        @endif

                    @else
                        <div class="space-y-3">
                            <a href="{{ route('login') }}"
                                class="block w-full py-4 bg-slate-900 text-white font-bold rounded-xl text-center hover:bg-slate-800 transition shadow-xl">
                                Login untuk Daftar
                            </a>
                            <p class="text-center text-xs text-slate-400">
                                Belum punya akun? <a href="{{ route('register') }}"
                                    class="text-[#6366f1] font-bold hover:underline">Daftar Akun</a>
                            </p>
                        </div>
                    @endauth

                </div>
            </div>

        </div>
    </main>

    <footer class="bg-white border-t border-slate-100 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-6 text-center text-slate-400 text-sm font-medium">
            &copy; 2026 Kave. Platform Event Kampus.
        </div>
    </footer>

</body>

</html>
