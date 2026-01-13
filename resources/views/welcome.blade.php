<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kave. | Platform Event Kampus</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
    </style>
</head>
<body class="bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-200 antialiased transition-colors duration-300">

    <nav class="fixed top-0 w-full z-50 bg-white/90 dark:bg-slate-950/90 backdrop-blur-md border-b border-slate-100 dark:border-white/5">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-12 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#6366f1] rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <span class="text-white font-black italic text-xl">K</span>
                </div>
                <span class="text-2xl font-bold tracking-tighter dark:text-white uppercase">Kave<span class="text-[#6366f1]">.</span></span>
            </div>

            <div class="hidden md:flex items-center gap-10 text-sm font-semibold text-slate-500 dark:text-slate-400">
                <a href="#about" class="hover:text-indigo-600 dark:hover:text-white transition">Tentang</a>
                <a href="#events" class="hover:text-indigo-600 dark:hover:text-white transition">Event</a>
                <a href="#propose" class="hover:text-indigo-600 dark:hover:text-white transition">Penyelenggara</a>
            </div>

            <div class="flex items-center gap-4">
                <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')"
                        class="p-2.5 rounded-xl bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-500 dark:text-indigo-400 hover:bg-slate-100 transition">
                    <i x-show="!darkMode" class="fa-solid fa-moon"></i>
                    <i x-show="darkMode" class="fa-solid fa-sun"></i>
                </button>

                @auth
                    <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-slate-900 dark:bg-white text-white dark:text-black text-xs font-extrabold rounded-xl shadow-sm hover:opacity-90 transition uppercase tracking-wider">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:block text-xs font-bold hover:text-indigo-600 transition uppercase tracking-widest">Masuk</a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 bg-[#6366f1] text-white text-xs font-extrabold rounded-xl hover:bg-indigo-500 transition shadow-md shadow-indigo-500/20 uppercase tracking-widest">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="relative pt-44 pb-24 lg:pt-56 lg:pb-32">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-12 grid lg:grid-cols-2 gap-16 items-center">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-xs font-extrabold uppercase tracking-[0.2em] mb-8">
                    Telkom University Surabaya
                </div>
                <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-[1.1] mb-8">
                    Temukan event <br><span class="text-[#6366f1]">dengan mudah.</span>
                </h1>
                <p class="text-lg lg:text-xl text-slate-500 dark:text-slate-400 leading-relaxed mb-10 max-w-xl">
                    Kave adalah platform pusat informasi kegiatan mahasiswa Tel-U Surabaya. Cari, daftar, dan kembangkan diri dalam satu klik.
                </p>
                <div class="flex items-center gap-6">
                    <a href="#events" class="px-8 py-4 bg-slate-900 dark:bg-white text-white dark:text-black font-extrabold rounded-2xl text-base hover:translate-y-[-4px] transition shadow-xl">Jelajahi Event</a>
                    <a href="#about" class="px-6 py-4 text-slate-600 dark:text-slate-300 font-bold text-base hover:text-indigo-600 transition flex items-center gap-2">Fitur Utama <i class="fa-solid fa-arrow-right-long"></i></a>
                </div>
            </div>
            <div class="relative hidden lg:block">
                <div class="absolute -inset-4 bg-indigo-500/10 rounded-[3rem] blur-3xl"></div>
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80"
                     class="relative rounded-[2.5rem] w-full aspect-[4/3] object-cover border border-slate-200 dark:border-white/5 shadow-2xl transition-transform duration-700 hover:scale-[1.01]" alt="Campus Life">
            </div>
        </div>
    </section>

    <section id="about" class="py-24 lg:py-32 bg-slate-50/50 dark:bg-slate-900/10 border-y border-slate-100 dark:border-white/5">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
            <div class="mb-16 lg:mb-20">
                <h2 class="text-indigo-600 dark:text-indigo-400 font-extrabold tracking-[0.2em] text-xs uppercase mb-4">Kenapa memilih Kave?</h2>
                <p class="text-3xl lg:text-4xl font-extrabold dark:text-white tracking-tight">Fitur Utama Kami.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-12 lg:gap-20">
                @php
                    $features = [
                        ['icon' => 'fa-bolt-lightning', 'title' => 'Update Cepat', 'desc' => 'Dapatkan info event kampus terbaru secara real-time langsung dari organisasi mahasiswa.'],
                        ['icon' => 'fa-id-card-clip', 'title' => 'Akses Mudah', 'desc' => 'Pendaftaran simpel menggunakan data mahasiswa, tidak perlu isi form panjang berkali-kali.'],
                        ['icon' => 'fa-award', 'title' => 'Terpercaya', 'desc' => 'Semua data user terjamin keamanannya dan semua event diawasi oleh pihak kampus']
                    ];
                @endphp
                @foreach($features as $f)
                <div class="group">
                    <div class="w-14 h-14 bg-[#6366f1]/10 rounded-2xl flex items-center justify-center mb-8 text-[#6366f1] group-hover:bg-[#6366f1] group-hover:text-white transition-all duration-500 shadow-sm">
                        <i class="fa-solid {{ $f['icon'] }} text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-2xl mb-4 dark:text-white">{{ $f['title'] }}</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-base leading-relaxed max-w-sm">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="events" class="py-24 lg:py-32">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
            <div class="flex items-center justify-between mb-16">
                <h2 class="text-3xl lg:text-4xl font-extrabold dark:text-white tracking-tight uppercase">Event <span class="text-[#6366f1]">Terbaru</span></h2>
                <div class="h-[1px] flex-1 bg-slate-100 dark:bg-white/5 mx-12 hidden sm:block"></div>
                <a href="#events" class="text-xs font-black text-slate-400 hover:text-[#6366f1] transition tracking-[0.3em] uppercase">Lihat Semua</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($events as $event)
                    <div class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/5 rounded-[2rem] overflow-hidden shadow-sm hover:shadow-2xl hover:translate-y-[-8px] transition-all duration-500">
                        <div class="relative h-64 overflow-hidden">
                            <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="{{ $event->title }}">
                            <div class="absolute top-6 left-6">
                                <span class="bg-white/95 backdrop-blur px-4 py-1.5 rounded-full text-[10px] font-black text-slate-900 uppercase tracking-widest shadow-sm">
                                    {{ $event->category->name }}
                                </span>
                            </div>
                        </div>

                        <div class="p-8 text-left">
                            <div class="flex items-center gap-3 text-xs font-bold text-[#6366f1] uppercase tracking-widest mb-4">
                                <i class="fa-regular fa-calendar-days text-sm"></i>
                                {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d M Y') }}
                            </div>
                            <h3 class="text-2xl font-bold mb-6 dark:text-white line-clamp-2 leading-tight group-hover:text-[#6366f1] transition-colors">
                                {{ $event->title }}
                            </h3>
                            <div class="flex items-center justify-between pt-6 border-t border-slate-50 dark:border-white/5">
                                <span class="text-xs text-slate-400 font-semibold flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot"></i> {{ Str::limit($event->location, 20) }}
                                </span>
                                <a href="{{ route('events.show', $event->id) }}" class="text-xs font-black text-[#6366f1] hover:tracking-widest transition-all">
                                    DETAIL
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-32 text-center border-2 border-dashed border-slate-100 dark:border-white/5 rounded-[3rem]">
                        <p class="text-slate-400 text-lg font-medium italic">Belum ada event tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="propose" class="pb-32 px-6 lg:px-12">
        <div class="max-w-[1440px] mx-auto">
            <div class="relative bg-slate-900 dark:bg-indigo-900/40 rounded-[3.5rem] p-12 lg:p-24 overflow-hidden shadow-2xl shadow-indigo-500/20 text-center border border-white/5">

                <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(#fff 1.5px, transparent 1.5px); background-size: 40px 40px;"></div>

                <div class="relative z-10">
                    <h2 class="text-4xl lg:text-6xl font-extrabold text-white mb-8 leading-tight tracking-tight">
                        Punya event keren? <br>Publikasikan di Kave.
                    </h2>
                    <p class="text-slate-300 max-w-2xl mx-auto mb-12 text-base lg:text-xl leading-relaxed">
                        Tinggalkan email Anda di bawah ini. Tim kami akan segera menghubungi Anda untuk membantu proses publikasi event di ekosistem Telkom University Surabaya.
                    </p>

                    <div class="mt-8 flex justify-center gap-4">
                        <a href="https://wa.me/6282141425416?text=Halo%20Admin%20Kave,%20saya%20ingin%20mempublikasikan%20event%20di%20Kave."
                        target="_blank"
                        class="inline-flex items-center gap-2 bg-white text-blue-900 font-bold py-3 px-8 rounded-full shadow-lg hover:bg-gray-100 transition duration-300 transform hover:scale-105">

                            {{-- Ikon WhatsApp (SVG) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#25D366">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>

                            Hubungi Kami via WhatsApp
                        </a>
                    </div>

                    <p class="mt-6 text-slate-500 text-xs font-medium uppercase tracking-widest">
                        <i class="fa-solid fa-shield-halved mr-2"></i> Data Anda aman bersama tim kami
                    </p>
                </div>

                <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-600 rounded-full blur-[120px] opacity-20"></div>
                <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-400 rounded-full blur-[120px] opacity-10"></div>
            </div>
        </div>
    </section>

    <footer class="py-16 border-t border-slate-100 dark:border-white/5">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-12 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-3 grayscale opacity-60">
                <div class="w-8 h-8 bg-slate-900 dark:bg-white rounded-lg flex items-center justify-center">
                    <span class="text-white dark:text-black font-black text-xs">K</span>
                </div>
                <span class="text-lg font-bold tracking-tighter uppercase dark:text-white">Kave.</span>
            </div>
            <p class="text-slate-400 text-[10px] font-black tracking-[0.4em] uppercase">&copy; 2026 Telkom University Surabaya</p>
        </div>
    </footer>

</body>
</html>
