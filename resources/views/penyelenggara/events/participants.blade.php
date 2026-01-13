<x-app-layout>
    {{-- Container Utama dengan Alpine.js untuk Tab Switching --}}
    <div class="py-10 px-4 max-w-7xl mx-auto" x-data="{ activeTab: 'pendaftar' }">

        {{-- Header & Navigasi Balik --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <a href="{{ route('penyelenggara.events.index') }}"
                   class="text-slate-400 hover:text-indigo-600 text-sm font-bold mb-4 inline-block transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Event
                </a>
                <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Data Peserta</h1>
                <p class="text-slate-500 text-sm font-medium mt-1">
                    Event: <span class="text-[#6366f1] font-bold">{{ $event->title }}</span>
                </p>
            </div>

            {{-- Tombol Tab Navigasi --}}
            <div class="flex p-1 bg-slate-100 dark:bg-slate-800 rounded-xl self-start md:self-end">
                <button
                    @click="activeTab = 'pendaftar'"
                    :class="activeTab === 'pendaftar' ? 'bg-white dark:bg-slate-700 text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                    class="px-6 py-2.5 rounded-lg text-xs font-bold uppercase tracking-widest transition-all">
                    Semua Pendaftar ({{ $pendaftarans->count() }})
                </button>
                <button
                    @click="activeTab = 'hadir'"
                    :class="activeTab === 'hadir' ? 'bg-white dark:bg-slate-700 text-green-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                    class="px-6 py-2.5 rounded-lg text-xs font-bold uppercase tracking-widest transition-all flex items-center gap-2">
                    <i class="fa-solid fa-qrcode"></i> Hadir ({{ $pesertaHadir->count() }})
                </button>
            </div>
        </div>

        {{-- ================= TAB 1: SEMUA PENDAFTAR (Sistem Lama + Status Hadir) ================= --}}
        <div x-show="activeTab === 'pendaftar'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-100 dark:border-white/5">
                    <h3 class="font-bold text-slate-800 dark:text-white">Manajemen Pendaftaran & Pembayaran</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 dark:bg-white/5 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                            <tr>
                                <th class="p-6">No</th>
                                <th class="p-6">Nama Mahasiswa</th>
                                <th class="p-6">Email</th>
                                <th class="p-6">Bukti Bayar</th>
                                <th class="p-6">Status Bayar</th>
                                <th class="p-6 text-center">Kehadiran</th> {{-- Kolom Baru --}}
                                <th class="p-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                            @forelse($pendaftarans as $index => $data)
                                <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition">
                                    {{-- No --}}
                                    <td class="p-6 text-slate-500 font-bold">{{ $index + 1 }}</td>

                                    {{-- Nama --}}
                                    <td class="p-6 font-bold text-slate-800 dark:text-white">
                                        {{ $data->user->name }}
                                        <div class="text-[10px] text-slate-400 font-normal mt-1">
                                            Daftar: {{ $data->created_at->format('d M Y') }}
                                        </div>
                                    </td>

                                    {{-- Email --}}
                                    <td class="p-6 text-sm text-slate-500">{{ $data->user->email }}</td>

                                    {{-- Bukti Bayar --}}
                                    <td class="p-6">
                                        @if($data->payment_proof)
                                            <a href="{{ asset('storage/' . $data->payment_proof) }}" target="_blank"
                                            class="inline-flex items-center px-3 py-2 rounded-xl bg-slate-100 dark:bg-white/5 text-slate-700 dark:text-slate-200 text-xs font-bold hover:bg-indigo-50 hover:text-indigo-600 transition">
                                                <i class="fa-solid fa-receipt mr-2"></i> Lihat Foto
                                            </a>
                                        @else
                                            <span class="text-xs text-slate-400 italic">- Tidak ada -</span>
                                        @endif
                                    </td>

                                    {{-- Status Pembayaran --}}
                                    <td class="p-6">
                                        @if($data->status === 'confirmed')
                                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold uppercase tracking-wide">
                                                <i class="fa-solid fa-check"></i> Lunas
                                            </span>
                                        @elseif($data->status === 'paid')
                                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-[10px] font-bold uppercase tracking-wide">
                                                <i class="fa-solid fa-clock"></i> Cek Bukti
                                            </span>
                                        @elseif($data->status === 'pending')
                                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] font-bold uppercase tracking-wide">
                                                Belum Bayar
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-bold uppercase tracking-wide">
                                                <i class="fa-solid fa-xmark"></i> Ditolak
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Status Kehadiran (BARU) --}}
                                    <td class="p-6 text-center">
                                        @if($data->is_checked_in)
                                            <span class="inline-flex flex-col items-center">
                                                <i class="fa-solid fa-circle-check text-green-500 text-lg"></i>
                                                <span class="text-[10px] font-bold text-green-600 uppercase mt-1">Hadir</span>
                                            </span>
                                        @else
                                            <span class="text-slate-300">
                                                <i class="fa-solid fa-minus"></i>
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi (Approve/Reject) --}}
                                    <td class="p-6 text-right">
                                        @if($data->status === 'paid' || $data->status === 'pending')
                                            <div class="flex justify-end gap-2">
                                                <form action="{{ route('penyelenggara.payment.confirm', $data->id) }}" method="POST">
                                                    @csrf
                                                    <button onclick="return confirm('Yakin validasi pembayaran ini?')" class="w-8 h-8 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white flex items-center justify-center transition shadow-lg shadow-indigo-500/30" title="Terima">
                                                        <i class="fa-solid fa-check text-xs"></i>
                                                    </button>
                                                </form>

                                                <form action="{{ route('penyelenggara.payment.reject', $data->id) }}" method="POST">
                                                    @csrf
                                                    <button onclick="return confirm('Tolak peserta ini?')" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition" title="Tolak">
                                                        <i class="fa-solid fa-xmark text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400 font-bold opacity-50">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-regular fa-folder-open text-4xl mb-4 text-slate-300"></i>
                                            <p>Belum ada pendaftar.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ================= TAB 2: DATA KEHADIRAN (Real-time Scan) ================= --}}
        <div x-show="activeTab === 'hadir'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-green-100 dark:border-green-500/20 shadow-xl shadow-green-500/5 overflow-hidden">

                <div class="p-6 bg-green-50/50 dark:bg-green-900/10 border-b border-green-100 flex items-center gap-4">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-lg">
                        <i class="fa-solid fa-users-viewfinder"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-green-800 dark:text-green-400">Laporan Kehadiran (Real-time)</h3>
                        <p class="text-xs text-green-600">Daftar peserta yang berhasil scan QR Code di lokasi.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                        <thead class="bg-slate-50 dark:bg-white/5 text-xs uppercase font-bold text-slate-400 tracking-widest">
                            <tr>
                                <th class="px-6 py-4">No</th>
                                <th class="px-6 py-4">Nama Peserta</th>
                                <th class="px-6 py-4">Tiket ID</th>
                                <th class="px-6 py-4">Waktu Check-in</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                            @forelse($pesertaHadir as $hadir)
                                <tr class="hover:bg-green-50/30 transition">
                                    <td class="px-6 py-4 font-bold text-green-600">#{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 font-bold text-slate-800 dark:text-white">{{ $hadir->user->name }}</td>
                                    <td class="px-6 py-4 font-mono text-xs text-slate-500">TIC-{{ $hadir->id }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-700 dark:text-slate-200">{{ $hadir->updated_at->format('H:i') }} WIB</span>
                                            <span class="text-[10px] text-slate-400">{{ $hadir->updated_at->format('d M Y') }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-400">
                                            <i class="fa-solid fa-qrcode text-4xl mb-3 opacity-30"></i>
                                            <p class="font-medium italic">Belum ada peserta yang check-in/scan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
