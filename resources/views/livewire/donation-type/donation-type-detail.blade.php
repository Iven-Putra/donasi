<div>
    
    <!-- Header with Back Link -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Rincian Penyaluran Program: {{ $type->name }}</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Menampilkan seluruh data transaksi donasi dengan status Selesai.</p>
        </div>
        <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg shadow-sm transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    <!-- Program Banner/Flyer -->
    @if($type->flyer)
        <div class="mb-8 w-full h-48 md:h-64 rounded-2xl overflow-hidden border border-gray-150 dark:border-gray-700 shadow-sm relative">
            <img src="{{ asset('storage/' . $type->flyer) }}" class="w-full h-full object-cover" alt="Flyer {{ $type->name }}">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex items-end p-6">
                <div>
                    <span class="text-xs font-bold px-2.5 py-1 bg-indigo-600 text-white rounded-md uppercase tracking-wider">
                        Program {{ $type->code }}
                    </span>
                    <h2 class="text-2xl md:text-3xl font-black text-white mt-2">{{ $type->name }}</h2>
                </div>
            </div>
        </div>
    @endif

    <!-- Summary KPI Card -->
    <div class="bg-indigo-50/50 dark:bg-indigo-950/20 rounded-2xl border border-indigo-100/50 dark:border-indigo-900/40 p-6 mb-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <span class="text-xs font-bold text-indigo-550 dark:text-indigo-400 uppercase tracking-wider">Total Donasi Terkumpul</span>
            <h1 class="text-3xl font-black text-indigo-700 dark:text-indigo-300 mt-1">
                Rp{{ number_format($type->donations()->where('status', 'Selesai')->sum('amount'), 0, ',', '.') }}
            </h1>
        </div>
        <div class="text-center sm:text-right">
            <span class="text-xs font-bold text-indigo-550 dark:text-indigo-400 uppercase tracking-wider block">Total Partisipasi</span>
            <span class="text-2xl font-black text-indigo-700 dark:text-indigo-300 mt-1 block">
                {{ $type->donations()->where('status', 'Selesai')->count() }} Kali
            </span>
        </div>
    </div>

    <!-- Toolbar / Search and Export -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            
            <!-- Search -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari No. Transaksi / Donatur..." class="w-full pl-10 rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Export -->
            <div class="flex items-center space-x-3">
                <button type="button" wire:click="exportCsv" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-650 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Ekspor Excel (CSV)
                </button>

                <a href="{{ route('donations.report-pdf') }}?typeFilter={{ $type->id }}&statusFilter=Selesai" target="_blank" class="inline-flex items-center px-4 py-2 border border-red-300 dark:border-red-900 bg-white dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-red-950/20 text-red-700 dark:text-red-400 text-sm font-semibold rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak PDF Rincian
                </a>
            </div>

        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">
                        <th class="px-6 py-4">No. Transaksi</th>
                        <th class="px-6 py-4">Tanggal / Waktu</th>
                        <th class="px-6 py-4">Nama Donatur</th>
                        <th class="px-6 py-4">Metode Bayar</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4">Petugas Input</th>
                        <th class="px-6 py-4 text-right">Nominal Donasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($donations as $donation)
                        <tr class="hover:bg-gray-50/40 dark:hover:bg-gray-900/20 transition-colors duration-150">
                            <!-- Transaction Number -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-xs font-bold px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 rounded">
                                    {{ $donation->transaction_number }}
                                </span>
                            </td>
                            <!-- Date -->
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">
                                {{ $donation->donation_date->translatedFormat('d M Y') }}<br>
                                <span class="text-xs text-gray-450 dark:text-gray-505">{{ $donation->donation_date->format('H:i') }} WIB</span>
                            </td>
                            <!-- Donor Name -->
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900 dark:text-white">
                                {{ $donation->donor->name ?? 'Donatur Umum' }}
                            </td>
                            <!-- Payment Method -->
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">
                                {{ $donation->payment_method }}
                            </td>
                            <!-- Notes -->
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400 max-w-xs truncate">
                                {{ $donation->notes ?? '-' }}
                            </td>
                            <!-- Officer -->
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">
                                {{ $donation->user->name ?? '-' }}
                            </td>
                            <!-- Amount -->
                            <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-indigo-600 dark:text-indigo-400">
                                Rp{{ number_format($donation->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500 font-semibold">
                                Tidak ada transaksi donasi yang tercatat untuk program ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($donations->hasPages())
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-805">
                {{ $donations->links() }}
            </div>
        @endif
    </div>

</div>
