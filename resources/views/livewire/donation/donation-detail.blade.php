<div class="max-w-2xl mx-auto">

    <!-- Card Container -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        
        <!-- Header -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">Rincian Tanda Terima</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Bukti sah penerimaan donasi organisasi.</p>
            </div>
            <a href="{{ route('donations.index') }}" wire:navigate class="text-xs text-indigo-650 hover:text-indigo-750 dark:text-indigo-400 dark:hover:text-indigo-300 font-semibold">
                Kembali ke Daftar
            </a>
        </div>

        <!-- Receipt Layout -->
        <div class="p-8 space-y-6">
            
            <!-- Receipt Branding Header -->
            <div class="flex flex-col sm:flex-row items-center justify-between border-b border-gray-100 dark:border-gray-750 pb-6 gap-4">
                <div class="text-center sm:text-left">
                    <h2 class="text-xl font-black text-indigo-600 dark:text-indigo-400">TANDA TERIMA DONASI</h2>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Nomor Transaksi: {{ $donation->transaction_number }}</p>
                </div>
                <div class="text-center sm:text-right text-xs text-gray-500 dark:text-gray-400">
                    <p class="font-bold">Tanggal Cetak</p>
                    <p class="mt-0.5">{{ now()->translatedFormat('d F Y H:i') }} WIB</p>
                </div>
            </div>

            <!-- Receipt Info Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                <!-- Donor Info -->
                <div class="space-y-1">
                    <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase">Telah Diterima Dari</span>
                    <p class="font-bold text-base text-gray-850 dark:text-white">{{ $donation->donor->name ?? 'Donatur Umum' }}</p>
                    <p class="text-gray-600 dark:text-gray-450">{{ $donation->donor->phone }}</p>
                    <p class="text-gray-650 dark:text-gray-450 text-xs truncate">{{ $donation->donor->email ?? '-' }}</p>
                </div>
                <!-- Transaction Info -->
                <div class="space-y-1 sm:text-right">
                    <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase">Rincian Transaksi</span>
                    <p class="text-gray-800 dark:text-gray-250"><span class="font-bold">Tanggal Donasi:</span> {{ $donation->donation_date->translatedFormat('d M Y H:i') }}</p>
                    <p class="text-gray-800 dark:text-gray-250"><span class="font-bold">Metode Bayar:</span> {{ $donation->payment_method }}</p>
                    <p class="text-gray-800 dark:text-gray-250"><span class="font-bold">Status:</span> 
                        <span class="font-semibold {{ $donation->status === 'Selesai' ? 'text-emerald-500' : 'text-amber-500' }}">
                            {{ $donation->status }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Donation Amount Panel -->
            <div class="p-6 bg-indigo-50/50 dark:bg-indigo-950/20 rounded-2xl border border-indigo-100/40 dark:border-indigo-900/40 flex flex-col items-center justify-center space-y-2">
                <span class="text-xs font-bold text-indigo-550 dark:text-indigo-400 uppercase tracking-wider">Jumlah Penyaluran Donasi</span>
                <h1 class="text-3xl font-black text-indigo-700 dark:text-indigo-300">
                    Rp{{ number_format($donation->amount, 0, ',', '.') }}
                </h1>
                <p class="text-xs text-gray-555 dark:text-gray-400 font-semibold italic text-center">
                    "Terbilang: {{ \App\Helpers\CoretanTerbilang::convert($donation->amount) }} Rupiah"
                </p>
            </div>

            <!-- Donation Items Detail -->
            <div class="border border-gray-150 dark:border-gray-700 rounded-xl overflow-hidden text-sm">
                <div class="grid grid-cols-3 bg-gray-50 dark:bg-gray-900 font-bold p-3 border-b border-gray-150 dark:border-gray-700 text-gray-550 dark:text-gray-400 text-xs uppercase">
                    <div class="col-span-2">Deskripsi Program Donasi</div>
                    <div class="text-right">Alokasi Donasi</div>
                </div>
                <div class="grid grid-cols-3 p-4 gap-2">
                    <div class="col-span-2">
                        <p class="font-bold text-gray-800 dark:text-gray-250">
                            {{ $donation->donationType->name ?? 'Program Umum' }}
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                            {{ $donation->notes ?? 'Penyaluran dana program kepedulian bersama.' }}
                        </p>
                    </div>
                    <div class="text-right font-bold text-gray-900 dark:text-white">
                        Rp{{ number_format($donation->amount, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- Footer Signatures -->
            <div class="grid grid-cols-2 gap-4 text-xs text-center pt-8 border-t border-gray-100 dark:border-gray-750">
                <div class="space-y-16">
                    <p class="text-gray-400 dark:text-gray-500 uppercase font-semibold">Penerima / Petugas</p>
                    <div>
                        <p class="font-bold text-gray-850 dark:text-white">{{ $donation->user->name ?? '-' }}</p>
                        <p class="text-gray-400 dark:text-gray-500">Staf Organisasi</p>
                    </div>
                </div>
                <div class="space-y-16">
                    <p class="text-gray-400 dark:text-gray-500 uppercase font-semibold">Penyetor / Donatur</p>
                    <div>
                        <p class="font-bold text-gray-850 dark:text-white">{{ $donation->donor->name ?? 'Donatur Umum' }}</p>
                        <p class="text-gray-400 dark:text-gray-500">Pemberi Donasi</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Action Button Footer -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 flex flex-wrap items-center justify-end gap-3">
            <!-- Print Receipt -->
            <a href="{{ route('donations.pdf', $donation->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-rose-600 hover:bg-rose-700 dark:bg-rose-505 dark:hover:bg-rose-650 text-white text-sm font-semibold rounded-lg shadow transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Bukti (PDF)
            </a>

            <!-- Send WhatsApp -->
            <a href="{{ $this->getWhatsappUrl() }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-505 dark:hover:bg-emerald-650 text-white text-sm font-semibold rounded-lg shadow transition-colors">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.022-.015-.022-.015-.502-.255-.09-.045-.165-.075-.24-.075-.075 0-.15.03-.225.105-.075.075-.3.375-.375.45-.075.075-.15.09-.24.045-.09-.045-.375-.14-.72-.45-.27-.24-.45-.525-.51-.615-.06-.09-.015-.135.03-.18.045-.045.09-.105.135-.165.045-.06.06-.105.09-.18.03-.075.015-.15 0-.225-.015-.075-.24-.57-.33-.78-.09-.21-.18-.18-.24-.18h-.225c-.075 0-.195.03-.3.15-.105.105-.405.39-.405.96 0 .57.42 1.125.48 1.2.06.075.825 1.26 2 1.785.285.12.51.195.69.255.285.09.54.075.75.045.225-.03.705-.285.81-.555.105-.27.105-.51.075-.555-.03-.045-.105-.075-.225-.135zM12 2C6.48 2 2 6.48 2 12c0 2.17.7 4.19 1.89 5.84l-1.25 4.58 4.7-.1.08.05A9.954 9.954 0 0012 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm0 18c-1.84 0-3.55-.53-5-1.45l-.36-.21-2.78.06.84-3.07-.23-.37A7.95 7.95 0 014 12c0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8z" />
                </svg>
                Kirim via WhatsApp
            </a>
        </div>

    </div>
</div>
