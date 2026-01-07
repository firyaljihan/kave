<x-app-layout>
    <div class="max-w-4xl mx-auto">
        <div class="mb-10">
            <a href="{{ route('penyelenggara.events.index') }}"
                class="text-slate-400 hover:text-indigo-600 text-sm font-bold mb-4 inline-block transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Event
            </a>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Edit Event</h1>
            <p class="text-slate-500 text-sm font-medium">Perbarui informasi kegiatan <span
                    class="text-[#6366f1] font-bold">{{ $event->title }}</span>.</p>
        </div>

        <form action="{{ route('penyelenggara.events.update', $event->id) }}" method="POST"
            enctype="multipart/form-data"
            class="bg-white dark:bg-slate-800 p-8 sm:p-10 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-xl shadow-indigo-500/5 space-y-8">
            @csrf
            @method('PUT') <div class="grid md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Poster
                        Saat Ini</label>
                    <div class="rounded-2xl overflow-hidden border border-slate-200">
                        <img src="{{ asset('storage/' . $event->image) }}" alt="Poster Lama"
                            class="w-full h-auto object-cover">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Ganti
                        Poster (Opsional)</label>
                    <div
                        class="relative w-full h-full min-h-[150px] bg-slate-50 dark:bg-white/5 border-2 border-dashed border-slate-300 dark:border-white/10 rounded-3xl flex flex-col items-center justify-center text-slate-400 hover:border-[#6366f1] hover:text-[#6366f1] transition cursor-pointer group overflow-hidden">
                        <input type="file" name="image"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <i class="fa-solid fa-cloud-arrow-up text-3xl mb-2 group-hover:scale-110 transition"></i>
                        <p class="text-xs font-bold uppercase tracking-widest text-center px-4">Klik untuk ganti poster
                            baru</p>
                        <p class="text-[10px] mt-1 opacity-60">Biarkan kosong jika tidak ingin mengganti</p>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Nama
                        Event</label>
                    <input type="text" name="title" required value="{{ old('title', $event->title) }}"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all font-bold text-slate-800 dark:text-white">
                </div>

                <div>
                    <label
                        class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Kategori</label>
                    <select name="category_id" required
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all cursor-pointer">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $event->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Harga
                        Tiket (Rupiah)</label>
                    <input type="number" name="price" min="0" required value="{{ old('price', $event->price) }}"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all">
                    <p class="text-[10px] text-slate-400 mt-2 ml-1">*Isi 0 jika gratis</p>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Tanggal
                        Mulai</label>
                    <input type="date" name="start_date" required value="{{ old('start_date', $event->start_date) }}"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all text-slate-500">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Tanggal
                        Selesai</label>
                    <input type="date" name="end_date" required value="{{ old('end_date', $event->end_date) }}"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all text-slate-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Lokasi
                        Pelaksanaan</label>
                    <input type="text" name="location" required value="{{ old('location', $event->location) }}"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Deskripsi
                        Lengkap</label>
                    <textarea name="description" rows="6" required
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all">{{ old('description', $event->description) }}</textarea>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 dark:border-white/5 flex items-center justify-between gap-4">
                <div class="text-xs text-slate-400 italic">
                    <i class="fa-solid fa-circle-info mr-1"></i> Perubahan mungkin memerlukan review ulang Admin.
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('penyelenggara.events.index') }}"
                        class="px-6 py-4 rounded-xl text-slate-500 font-bold hover:bg-slate-50 transition uppercase tracking-widest text-xs">Batal</a>
                    <button type="submit"
                        class="px-8 py-4 bg-[#6366f1] hover:bg-indigo-700 text-white font-black rounded-xl shadow-lg shadow-indigo-500/30 transition-all uppercase tracking-widest text-xs">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
