<div>
    
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-xl flex items-center space-x-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-semibold text-sm">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Toolbar / Search and Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-8">
        
        <!-- Action Buttons Bar -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6 pb-6 border-b border-gray-100 dark:border-gray-750">
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">Pencarian & Laporan</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Gunakan filter untuk menyaring data dan mengunduh laporan donasi.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <button type="button" wire:click="exportCsv" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-650 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Ekspor CSV
                </button>
                <a href="{{ route('donations.report-pdf') }}?startDate={{ $startDate }}&endDate={{ $endDate }}&typeFilter={{ $typeFilter }}&donorFilter={{ $donorFilter }}&statusFilter={{ $statusFilter }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-red-300 dark:border-red-900 bg-white dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-red-950/20 text-red-700 dark:text-red-400 text-sm font-semibold rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Rekap PDF
                </a>
                <a href="{{ route('donations.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-505 dark:hover:bg-indigo-650 text-white text-sm font-bold rounded-lg shadow transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Catat Transaksi Donasi
                </a>
            </div>
        </div>

        <!-- Filters Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
            
            <!-- Search -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Cari Keyword</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="No. Transaksi / Donatur" class="w-full pl-9 rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Date Start -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Tanggal Mulai</label>
                <input type="date" wire:model.live="startDate" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- Date End -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Tanggal Selesai</label>
                <input type="date" wire:model.live="endDate" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- Donation Type -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Jenis Donasi</label>
                <select wire:model.live="typeFilter" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua Jenis</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Status</label>
                <select wire:model.live="statusFilter" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Draft">Draft</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
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
                        <th class="px-6 py-4">Donatur</th>
                        <th class="px-6 py-4">Program</th>
                        <th class="px-6 py-4 text-right">Nominal</th>
                        <th class="px-6 py-4">Metode</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
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
                                <span class="text-xs text-gray-450 dark:text-gray-500">{{ $donation->donation_date->format('H:i') }} WIB</span>
                            </td>
                            <!-- Donor Name -->
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900 dark:text-white">
                                {{ $donation->donor->name ?? 'Donatur Umum' }}
                            </td>
                            <!-- Donation Type -->
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">
                                {{ $donation->donationType->name ?? '-' }}
                            </td>
                            <!-- Amount -->
                            <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-gray-900 dark:text-white">
                                Rp{{ number_format($donation->amount, 0, ',', '.') }}
                            </td>
                            <!-- Payment Method -->
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400 text-xs">
                                {{ $donation->payment_method }}
                            </td>
                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($donation->status === 'Selesai')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-300">
                                        Selesai
                                    </span>
                                @elseif($donation->status === 'Draft')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-950/50 dark:text-amber-300">
                                        Draft
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800 dark:bg-gray-700/60 dark:text-gray-400">
                                        Batal
                                    </span>
                                @endif
                            </td>
                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Detail -->
                                    <a href="{{ route('donations.show', $donation->id) }}" wire:navigate class="p-1.5 text-gray-500 hover:text-indigo-650 dark:text-gray-400 dark:hover:text-indigo-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-750 transition-colors" title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('donations.edit', $donation->id) }}" wire:navigate class="p-1.5 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-750 transition-colors" title="Ubah">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>

                                    <!-- Delete -->
                                    <button type="button" 
                                            onclick="confirm('Apakah Anda yakin ingin menghapus data transaksi donasi ini?') || event.stopImmediatePropagation()"
                                            wire:click="delete({{ $donation->id }})" 
                                            class="p-1.5 text-gray-500 hover:text-rose-600 dark:text-gray-400 dark:hover:text-rose-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-750 transition-colors" 
                                            title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500 font-semibold">
                                Tidak ada data transaksi donasi yang ditemukan.
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
