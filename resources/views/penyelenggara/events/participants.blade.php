<x-app-layout>
    <div class="mb-10">
        <a href="{{ route('penyelenggara.events.index') }}"
            class="text-slate-400 hover:text-indigo-600 text-sm font-bold mb-4 inline-block transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Event
        </a>
        <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Data Peserta</h1>
        <p class="text-slate-500 text-sm font-medium">
            Event: <span class="text-[#6366f1] font-bold">{{ $event->title }}</span>
        </p>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 text-green-700 p-4 rounded-xl border border-green-200 font-bold text-sm">
            <i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 dark:border-white/5 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 dark:text-white">Daftar Mahasiswa Terdaftar</h3>
            <span class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-xs font-bold uppercase tracking-widest">
                Total: {{ $pendaftarans->count() }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                {{-- HEAD: Hanya Judul Kolom (Jangan ada logika di sini) --}}
                <thead class="bg-slate-50 dark:bg-white/5 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                    <tr>
                        <th class="p-6">No</th>
                        <th class="p-6">Nama Mahasiswa</th>
                        <th class="p-6">Email</th>
                        <th class="p-6">Bukti Bayar</th>
                        <th class="p-6">Status</th>
                        <th class="p-6 text-right">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY: Di sini looping datanya --}}
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
                            <td class="p-6 text-sm text-slate-500">
                                {{ $data->user->email }}
                            </td>

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

                            {{-- Status Badge --}}
                            <td class="p-6">
                                @if($data->status === 'confirmed')
                                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold uppercase tracking-wide">
                                        <i class="fa-solid fa-check"></i> Success
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
                                        <i class="fa-solid fa-xmark"></i> Rejected
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi (Tombol) --}}
                            <td class="p-6 text-right">
                                {{-- Tombol muncul hanya jika status 'paid' (sudah upload bukti) atau 'pending' --}}
                                @if($data->status === 'paid' || $data->status === 'pending')
                                    <div class="flex justify-end gap-2">
                                        {{-- FORM CONFIRM --}}
                                        <form action="{{ route('penyelenggara.payment.confirm', $data->id) }}" method="POST">
                                            @csrf
                                            <button onclick="return confirm('Yakin validasi pembayaran ini?')" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-500/20 transition">
                                                Approve
                                            </button>
                                        </form>

                                        {{-- FORM REJECT --}}
                                        <form action="{{ route('penyelenggara.payment.reject', $data->id) }}" method="POST">
                                            @csrf
                                            <button onclick="return confirm('Tolak peserta ini?')" class="px-4 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 text-xs font-black uppercase tracking-widest transition">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 font-bold">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-regular fa-folder-open text-4xl mb-4 text-slate-300"></i>
                                    <p>Belum ada peserta yang mendaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
