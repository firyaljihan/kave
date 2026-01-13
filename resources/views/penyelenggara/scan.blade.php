<x-app-layout>
    {{-- Load Library HTML5-QRCode --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <div class="max-w-xl mx-auto py-10 px-4">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-slate-800 dark:text-white mb-2">Scan Tiket</h1>
            <p class="text-slate-500 text-sm">Arahkan kamera ke QR Code peserta.</p>
        </div>

        <div class="relative">
            <div id="reader" class="w-full"></div>
        </div>

        <form id="scanForm" action="{{ route('penyelenggara.scan.verify') }}" method="POST" class="mt-6">
            @csrf
            <input type="hidden" name="qr_code" id="result">
        </form>

        @if(session('success_scan'))
            @php $ticket = session('success_scan'); @endphp
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm animate-fade-in">
                <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl">
                    <div class="absolute top-0 left-0 w-full h-2 bg-green-500"></div>

                    <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl shadow-lg">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <h2 class="text-3xl font-black text-slate-800 mb-2">VALID!</h2>
                    <p class="text-slate-500 font-medium mb-6">Silakan masuk.</p>

                    <div class="bg-slate-50 p-4 rounded-xl text-left border border-slate-100 mb-6">
                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Nama Peserta</p>
                        <p class="font-bold text-slate-800 text-lg mb-2">{{ $ticket->user->name }}</p>
                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Event</p>
                        <p class="font-bold text-indigo-600 text-sm truncate">{{ $ticket->event->title }}</p>
                    </div>

                    <a href="{{ route('penyelenggara.scan.index') }}" class="block w-full py-4 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition uppercase tracking-widest text-xs">
                        Scan Berikutnya
                    </a>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm animate-fade-in">
                <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl">
                    <div class="absolute top-0 left-0 w-full h-2 bg-red-500"></div>
                    <div class="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl shadow-lg">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                    <h2 class="text-3xl font-black text-slate-800 mb-2">GAGAL!</h2>
                    <p class="text-slate-500 font-medium mb-6">{{ session('error') }}</p>
                    <a href="{{ route('penyelenggara.scan.index') }}" class="block w-full py-4 bg-slate-800 text-white font-bold rounded-xl hover:bg-black transition uppercase tracking-widest text-xs">
                        Coba Lagi
                    </a>
                </div>
            </div>
        @endif
    </div>

    {{-- Script Utama --}}
    <script>
        const beepSound = new Audio("{{ asset('sounds/beep.mp3') }}");

        function onScanSuccess(decodedText, decodedResult) {
            // 1. Masukkan data ke input hidden
            document.getElementById('result').value = decodedText;

            // 2. STOP scanner dengan benar sebelum submit
            // html5QrcodeScanner.clear() adalah Promise, kita harus tunggu (.then)
            // agar DOM tidak dihancurkan paksa sebelum library siap.
            html5QrcodeScanner.clear().then(_ => {
                document.getElementById('scanForm').submit();
            }).catch(error => {
                // Jika gagal clear, tetap paksa submit agar tidak macet
                console.warn("Gagal membersihkan scanner, tetap submit...", error);
                document.getElementById('scanForm').submit();
            });
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: {width: 250, height: 250}, aspectRatio: 1.0 },
            false
        );
        html5QrcodeScanner.render(onScanSuccess);
    </script>

    {{-- Styling CSS (Sama Persis dengan Punya Kamu) --}}
    <style>
        #reader {
            display: flex !important;
            flex-direction: column !important;
            gap: 20px !important;
            background: transparent !important;
            border: none !important;
        }

        #reader__scan_region {
            order: 1 !important;
            border-radius: 2.5rem !important;
            overflow: hidden !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            border: 4px solid #1e293b !important;
            background: black !important;
            min-height: 300px !important;
            position: relative !important;
        }

        #reader__scan_region::after {
            content: '';
            position: absolute;
            top: 0; left: 10%; right: 10%;
            height: 2px;
            background: #ef4444;
            box-shadow: 0 0 15px #ef4444;
            animation: scanAnimation 2s infinite ease-in-out;
            pointer-events: none;
            z-index: 10;
        }

        #reader__dashboard_section_csr {
            order: 2 !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 15px !important;
            width: 100% !important;
        }

        #reader__dashboard_section_csr select {
            appearance: none !important;
            background-color: #f1f5f9 !important;
            color: #334155 !important;
            border: 1px solid #cbd5e1 !important;
            padding: 12px 24px !important;
            border-radius: 12px;
            font-weight: bold !important;
            font-size: 13px !important;
            text-align: center !important;
            cursor: pointer !important;
            outline: none !important;
            width: 100% !important;
            max-width: 300px !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
        }

        #reader button {
            background-color: #4f46e5 !important;
            color: white !important;
            border: none !important;
            padding: 14px 28px !important;
            border-radius: 16px !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            font-size: 12px !important;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3) !important;
            transition: transform 0.2s !important;
            cursor: pointer !important;
        }
        #reader button:hover {
            transform: scale(1.05) !important;
            background-color: #4338ca !important;
        }

        #reader__dashboard_section_swaplink {
            order: 3 !important;
            margin-top: 5px !important;
            font-size: 12px !important;
            font-weight: bold !important;
            text-decoration: none !important;
            color: #64748b !important;
        }

        #reader__header_message { display: none !important; }

        @keyframes scanAnimation {
            0% { top: 10%; opacity: 0; }
            50% { opacity: 1; }
            100% { top: 90%; opacity: 0; }
        }

        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</x-app-layout>
