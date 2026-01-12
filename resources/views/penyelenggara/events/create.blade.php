<x-app-layout>
    <div class="max-w-4xl mx-auto">
        <div class="mb-10">
            <a href="{{ route('penyelenggara.events.index') }}" class="text-slate-400 hover:text-indigo-600 text-sm font-bold mb-4 inline-block transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Event
            </a>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Buat Event Baru</h1>
            <p class="text-slate-500 text-sm font-medium">Isi detail lengkap kegiatan Anda.</p>
        </div>

        {{-- [BLOK VALIDASI ERROR] --}}
        @if ($errors->any())
            <div class="mb-8 p-6 bg-red-50 border border-red-200 rounded-2xl">
                <div class="flex items-center gap-3 text-red-600 font-bold mb-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <h3>Gagal Menyimpan Event</h3>
                </div>
                <ul class="list-disc list-inside text-sm text-red-500 space-y-1 ml-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('penyelenggara.events.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-800 p-8 sm:p-10 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-xl shadow-indigo-500/5 space-y-8">
            @csrf

            {{-- 1. UPLOAD POSTER DENGAN PREVIEW --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Poster Event</label>

                {{-- Container Upload --}}
                <div id="upload-container" class="relative w-full h-64 bg-slate-50 dark:bg-white/5 border-2 border-dashed border-slate-300 dark:border-white/10 rounded-3xl flex flex-col items-center justify-center text-slate-400 hover:border-[#6366f1] hover:text-[#6366f1] transition cursor-pointer group overflow-hidden">

                    {{-- Input File (Invisible tapi bisa diklik) --}}
                    <input type="file" name="image" required
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                           onchange="previewImage(event)">

                    {{-- Placeholder (Icon Cloud & Teks) --}}
                    <div id="placeholder" class="flex flex-col items-center justify-center w-full h-full transition-opacity duration-300">
                        <i class="fa-solid fa-cloud-arrow-up text-4xl mb-3 group-hover:scale-110 transition"></i>
                        <p class="text-xs font-bold uppercase tracking-widest">Klik untuk upload poster</p>
                        <p class="text-[10px] mt-1 opacity-60">PNG, JPG (Max 2MB)</p>
                    </div>

                    {{-- Preview Image (Hidden Awalnya) --}}
                    <img id="preview" src="#" alt="Preview Poster" class="hidden absolute inset-0 w-full h-full object-cover z-10">
                </div>

                @error('image') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                {{-- Nama Event --}}
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Nama Event</label>
                    <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Webinar Nasional Teknologi 2026"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all font-bold text-slate-800 dark:text-white">
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Kategori</label>
                    <select name="category_id" required class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all cursor-pointer">
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Harga --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Harga Tiket (Rupiah)</label>
                    <input type="text" name="price"
                        value="{{ old('price', 0) }}"
                        inputmode="numeric"
                        placeholder="Contoh: 100000 atau 100.000"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all">
                    <p class="text-xs text-slate-400 mt-2 font-medium">
                        Tips: Untuk gratis isi <span class="font-bold">0</span>. Kamu boleh pakai titik ribuan (contoh 100.000).
                    </p>
                </div>

                {{-- 2. TANGGAL MULAI (datetime-local) --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Waktu Mulai</label>
                    <input type="datetime-local" id="start_date" name="start_date" required value="{{ old('start_date') }}"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all text-slate-500 font-bold">
                </div>

                {{-- 3. TANGGAL SELESAI (datetime-local) --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Waktu Selesai</label>
                    <input type="datetime-local" id="end_date" name="end_date" required value="{{ old('end_date') }}"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all text-slate-500 font-bold">
                </div>

                {{-- Lokasi --}}
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Lokasi Pelaksanaan</label>
                    <input type="text" name="location" required value="{{ old('location') }}" placeholder="Contoh: Gedung Serbaguna Telkom University / Zoom Meeting"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all">
                </div>

                {{-- Deskripsi --}}
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Deskripsi Lengkap</label>
                    <textarea name="description" rows="6" required placeholder="Jelaskan detail event, persyaratan, dan benefit yang didapat peserta..."
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl outline-none focus:ring-2 focus:ring-[#6366f1]/20 focus:border-[#6366f1] transition-all">{{ old('description') }}</textarea>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="pt-6 border-t border-slate-100 dark:border-white/5 flex items-center justify-end gap-4">
                <a href="{{ route('penyelenggara.events.index') }}" class="px-6 py-4 rounded-xl text-slate-500 font-bold hover:bg-slate-50 transition uppercase tracking-widest text-xs">Batal</a>
                <button type="submit" class="px-8 py-4 bg-[#6366f1] hover:bg-indigo-700 text-white font-black rounded-xl shadow-lg shadow-indigo-500/30 transition-all uppercase tracking-widest text-xs">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Simpan Event
                </button>
            </div>
        </form>
    </div>

    {{-- SCRIPT: PREVIEW IMAGE & VALIDASI TANGGAL --}}
    <script>
        // 1. Fungsi Preview Image
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholder');
            const container = document.getElementById('upload-container');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    container.classList.remove('border-dashed', 'border-2'); // Hilangkan border putus-putus
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // 2. Logic Validasi Tanggal & Jam
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            // Set waktu minimal Start Date ke "Sekarang"
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset()); // Sesuaikan timezone lokal user
            const currentDateTime = now.toISOString().slice(0, 16); // Format YYYY-MM-DDTHH:mm

            startDateInput.min = currentDateTime;

            // Update End Date saat Start Date dipilih
            startDateInput.addEventListener('change', function() {
                if (this.value) {
                    // Tanggal Selesai minimal harus sama dengan Tanggal Mulai
                    endDateInput.min = this.value;

                    // Jika End Date yang sudah diisi ternyata lebih kecil dari Start Date baru -> Reset
                    if (endDateInput.value && endDateInput.value < this.value) {
                        endDateInput.value = '';
                        alert('Waktu selesai harus setelah waktu mulai!');
                    }
                }
            });
        });
    </script>
</x-app-layout>
