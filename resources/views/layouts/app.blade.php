<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kave') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap'); body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] } } }
        }
    </script>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-200 antialiased">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="absolute z-50 left-0 top-0 lg:static lg:translate-x-0 w-64 h-screen bg-white dark:bg-slate-950 border-r border-slate-200 dark:border-white/5 transition-transform duration-300 flex flex-col">

            <div class="h-20 flex items-center justify-center border-b border-slate-100 dark:border-white/5">
                <a href="/" class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-[#6366f1] rounded-lg flex items-center justify-center text-white font-black italic">K</div>
                    <span class="text-xl font-bold uppercase tracking-tight">Kave<span class="text-[#6366f1]">.</span></span>
                </a>
            </div>

            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">

                {{-- ================= MENU ADMIN ================= --}}
                @if(Auth::user()->role === 'admin')
                    <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 mt-2">Administrator</p>

                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#6366f1] text-white shadow-lg shadow-indigo-500/30' : 'text-slate-500 hover:bg-slate-50 dark:hover:bg-white/5' }}">
                        <i class="fa-solid fa-chart-pie w-5 text-center"></i> <span class="font-bold text-sm">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'bg-[#6366f1] text-white shadow-lg shadow-indigo-500/30' : 'text-slate-500 hover:bg-slate-50 dark:hover:bg-white/5' }}">
                        <i class="fa-solid fa-users-gear w-5 text-center"></i> <span class="font-bold text-sm">Kelola User</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-[#6366f1] text-white shadow-lg shadow-indigo-500/30' : 'text-slate-500 hover:bg-slate-50 dark:hover:bg-white/5' }}">
                        <i class="fa-solid fa-tags w-5 text-center"></i> <span class="font-bold text-sm">Kategori</span>
                    </a>
                    <a href="{{ route('admin.events.published') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.events.published*') ? 'bg-[#6366f1] text-white shadow-lg shadow-indigo-500/30' : 'text-slate-500 hover:bg-slate-50 dark:hover:bg-white/5' }}">
                        <i class="fa-solid fa-calendar-check w-5 text-center"></i> <span class="font-bold text-sm">Event Terposting</span>
                    </a>

                {{-- ================= MENU PENYELENGGARA ================= --}}
                @elseif(Auth::user()->role === 'penyelenggara')
                    <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 mt-2">Penyelenggara</p>

                    <a href="{{ route('penyelenggara.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('penyelenggara.dashboard') ? 'bg-[#6366f1] text-white shadow-lg shadow-indigo-500/30' : 'text-slate-500 hover:bg-slate-50 dark:hover:bg-white/5' }}">
                        <i class="fa-solid fa-gauge-high w-5 text-center"></i> <span class="font-bold text-sm">Dashboard</span>
                    </a>

                    <a href="{{ route('penyelenggara.events.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('penyelenggara.events.*') ? 'bg-[#6366f1] text-white shadow-lg shadow-indigo-500/30' : 'text-slate-500 hover:bg-slate-50 dark:hover:bg-white/5' }}">
                        <i class="fa-solid fa-calendar-check w-5 text-center"></i> <span class="font-bold text-sm">Kelola Event</span>
                    </a>

                {{-- ================= MENU MAHASISWA ================= --}}
                @elseif(Auth::user()->role === 'mahasiswa')
                    <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 mt-2">Mahasiswa</p>

                    <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-[#6366f1] text-white shadow-lg shadow-indigo-500/30' : 'text-slate-500 hover:bg-slate-50 dark:hover:bg-white/5' }}">
                        <i class="fa-solid fa-ticket w-5 text-center"></i> <span class="font-bold text-sm">Tiket Saya</span>
                    </a>

                    <a href="{{ route('mahasiswa.explore') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('mahasiswa.explore') ? 'bg-[#6366f1] text-white shadow-lg shadow-indigo-500/30' : 'text-slate-500 hover:bg-slate-50 dark:hover:bg-white/5' }}">
                        <i class="fa-solid fa-compass w-5 text-center"></i> <span class="font-bold text-sm">Cari Event</span>
                    </a>
                @endif

            </nav>

            <div class="p-4 border-t border-slate-100 dark:border-white/5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i> <span class="font-bold text-sm">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden relative">

            <header class="bg-white dark:bg-slate-950 h-20 flex items-center justify-between px-6 border-b border-slate-100 dark:border-white/5 lg:hidden">
                <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <span class="font-bold text-lg">Kave.</span>
                <div class="w-8"></div> </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 dark:bg-slate-900 p-6 lg:p-10">

                @if(session('success'))
                    <div class="mb-6 bg-green-500/10 border border-green-500/20 text-green-600 px-4 py-3 rounded-xl font-bold flex items-center gap-3">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-600 px-4 py-3 rounded-xl font-bold flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}

            </main>
        </div>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>
    </div>
</body>
</html>
