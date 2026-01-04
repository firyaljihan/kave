<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kave - Event Telkom University Surabaya</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white text-gray-900 font-sans">

    <nav class="flex items-center justify-between px-6 py-6 max-w-7xl mx-auto">
        <div class="flex items-center gap-2">
            <div class="bg-blue-600 text-white font-bold p-2 rounded-lg">K</div>
            <span class="text-2xl font-extrabold tracking-tight text-slate-900">Kave.</span>
        </div>

        <div class="hidden md:flex space-x-8 font-medium text-gray-600">
            <a href="#" class="hover:text-blue-600 transition">Product</a>
            <a href="#" class="hover:text-blue-600 transition">Features</a>
            <a href="#" class="hover:text-blue-600 transition">Resources</a>
            <a href="#" class="hover:text-blue-600 transition">Company</a>
        </div>

        <div class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-blue-600">Dashboard &rarr;</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-blue-600">Log in &rarr;</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hidden md:inline-block bg-blue-600 text-white px-5 py-2 rounded-full font-bold hover:bg-blue-700 transition">
                            Sign Up
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12 md:py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            <div class="space-y-6">
                <h1 class="text-5xl md:text-6xl font-extrabold leading-tight text-slate-900">
                    Platform Terpadu <br>
                    Informasi Event <br>
                    <span class="text-blue-600">Telkom University</span> <br>
                    <span class="text-blue-600">Surabaya.</span>
                </h1>

                <p class="text-lg text-gray-600 leading-relaxed max-w-lg">
                    Temukan berbagai kegiatan mahasiswa, workshop, hingga seminar dalam satu wadah.
                    Kami mempermudah mahasiswa Telkom University Surabaya untuk mengeksplorasi setiap peluang dan pengalaman di kampus.
                </p>

                <div class="pt-4">
                    <a href="#explore" class="inline-block bg-blue-600 text-white text-lg font-bold px-8 py-4 rounded-full shadow-lg hover:bg-blue-700 hover:shadow-xl transition transform hover:-translate-y-1">
                        Cari Event
                    </a>
                </div>
            </div>

            <div class="relative">
                <img src="https://images.unsplash.com/photo-1544531586-fde5298cdd40?q=80&w=2070&auto=format&fit=crop"
                     alt="Event Audience"
                     class="rounded-[2.5rem] shadow-2xl w-full object-cover h-[500px] rotate-2 hover:rotate-0 transition duration-500">

                <div class="absolute -z-10 top-10 -right-10 w-24 h-24 bg-yellow-400 rounded-full blur-xl opacity-50"></div>
                <div class="absolute -z-10 bottom-10 -left-10 w-32 h-32 bg-blue-400 rounded-full blur-xl opacity-50"></div>
            </div>

        </div>
    </main>

    <section id="explore" class="bg-gray-50 py-20 mt-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Event Terbaru</h2>
                    <p class="text-gray-500 mt-2">Jangan sampai ketinggalan kegiatan seru minggu ini.</p>
                </div>
                <a href="#" class="text-blue-600 font-semibold hover:underline">Lihat Semua &rarr;</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($events as $event)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden border border-gray-100">
                    <div class="h-48 bg-gray-200 overflow-hidden">
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>

                    <div class="p-6">
                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded-full">
                            {{ $event->category->name ?? 'Umum' }}
                        </span>
                        <h3 class="text-xl font-bold mt-3 text-gray-900 line-clamp-1">{{ $event->title }}</h3>
                        <p class="text-gray-500 text-sm mt-1 mb-4 flex items-center gap-1">
                            📅 {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                        </p>

                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                            <span class="font-bold text-blue-600">
                                {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                            </span>
                            <a href="{{ route('events.show', $event->id) }}" class="text-sm font-semibold text-gray-600 hover:text-blue-600">Detail &rarr;</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($events->isEmpty())
                <div class="text-center py-10">
                    <p class="text-gray-500">Belum ada event yang dipublish.</p>
                </div>
            @endif
        </div>
    </section>

    <footer class="bg-white border-t border-gray-100 py-10 mt-10">
        <div class="max-w-7xl mx-auto px-6 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Kave Event Management. Telkom University Surabaya.
        </div>
    </footer>

</body>
</html>
