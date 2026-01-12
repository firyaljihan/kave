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

    <div
        class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 dark:border-white/5 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 dark:text-white">Daftar Mahasiswa Terdaftar</h3>
            <span class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-xs font-bold uppercase tracking-widest">
                Total: {{ $pendaftarans->count() }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead
                    class="bg-slate-50 dark:bg-white/5 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                    <tr>
                        <th class="p-6">No</th>
                        <th class="p-6">Nama Mahasiswa</th>
                        <th class="p-6">Email</th>
                        <th class="p-6">Tanggal Daftar</th>
                        <td class="p-6">
                            @if($data->status === 'confirmed')
                                <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold uppercase tracking-wide">
                                    <i class="fa-solid fa-check"></i> Success
                                </span>
                            @elseif($data->status === 'pending')
                                <span class="inline-flex items-center gap-2 px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-[10px] font-bold uppercase tracking-wide">
                                    <i class="fa-solid fa-clock"></i> Pending
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-3 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-bold uppercase tracking-wide">
                                    <i class="fa-solid fa-xmark"></i> Rejected
                                </span>
                            @endif
                        </td>
                        <td class="p-6">
                            @if($data->payment_proof)
                                <a href="{{ asset('storage/' . $data->payment_proof) }}" target="_blank"
                                class="px-3 py-2 rounded-xl bg-slate-100 dark:bg-white/5 text-slate-700 dark:text-slate-200 text-xs font-bold hover:bg-slate-200 dark:hover:bg-white/10 transition">
                                    <i class="fa-solid fa-receipt mr-2"></i> Lihat Bukti
                                </a>
                            @else
                                <span class="text-xs text-slate-400">-</span>
                            @endif

                            @if($data->status === 'pending')
                                <div class="mt-3 flex gap-2">
                                    <form action="{{ route('penyelenggara.pendaftarans.confirm', $data->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="px-3 py-2 rounded-xl bg-green-600 hover:bg-green-500 text-white text-xs font-black uppercase tracking-widest">
                                            Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('penyelenggara.pendaftarans.reject', $data->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="px-3 py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white text-xs font-black uppercase tracking-widest">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse($pendaftarans as $index => $data)
                        <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition">
                            <td class="p-6 text-slate-500 font-bold">{{ $index + 1 }}</td>
                            <td class="p-6 font-bold text-slate-800 dark:text-white">
                                {{ $data->user->name }}
                            </td>
                            <td class="p-6 text-sm text-slate-500">
                                {{ $data->user->email }}
                            </td>
                            <td class="p-6 text-sm text-slate-500">
                                {{ $data->created_at->format('d M Y, H:i') }} WIB
                            </td>
                            <td class="p-6">
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-600 rounded-full text-[10px] font-bold uppercase tracking-wide">
                                    <i class="fa-solid fa-check"></i> Confirmed
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400">
                                Belum ada peserta yang mendaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
