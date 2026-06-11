<div x-data="{ tab: 'recent' }" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 h-full">
    
    <!-- Tab Controls -->
    <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-4 mb-5">
        <div class="flex space-x-4">
            <button @click="tab = 'recent'" 
                    :class="tab === 'recent' ? 'text-indigo-600 dark:text-indigo-400 border-indigo-600 dark:border-indigo-400' : 'text-gray-500 border-transparent hover:text-gray-700 dark:hover:text-gray-300'" 
                    class="pb-2 border-b-2 font-bold text-sm transition-all duration-200 focus:outline-none">
                10 Donasi Terakhir
            </button>
            <button @click="tab = 'top'" 
                    :class="tab === 'top' ? 'text-indigo-600 dark:text-indigo-400 border-indigo-600 dark:border-indigo-400' : 'text-gray-500 border-transparent hover:text-gray-700 dark:hover:text-gray-300'" 
                    class="pb-2 border-b-2 font-bold text-sm transition-all duration-200 focus:outline-none">
                Top 10 Donatur
            </button>
        </div>
    </div>

    <!-- Tab 1: 10 Donasi Terakhir -->
    <div x-show="tab === 'recent'" class="space-y-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-xs text-gray-500 dark:text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800">
                        <th class="py-2">Donatur / Tanggal</th>
                        <th class="py-2">Jenis</th>
                        <th class="py-2 text-right">Nominal</th>
                        <th class="py-2 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($recentDonations as $donation)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/30 transition-colors duration-150">
                            <td class="py-3">
                                <p class="font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $donation->donor->name ?? 'Donatur Umum' }}
                                </p>
                                <span class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ $donation->donation_date->translatedFormat('d M Y H:i') }}
                                </span>
                            </td>
                            <td class="py-3 text-gray-600 dark:text-gray-400 text-xs font-medium">
                                {{ $donation->donationType->name ?? '-' }}
                            </td>
                            <td class="py-3 text-right font-bold text-gray-900 dark:text-white">
                                Rp{{ number_format($donation->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3 text-center">
                                @if($donation->status === 'Selesai')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300">
                                        Selesai
                                    </span>
                                @elseif($donation->status === 'Draft')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-300">
                                        Draft
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-rose-50 dark:bg-rose-950/50 text-rose-700 dark:text-rose-300">
                                        Batal
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-gray-400 dark:text-gray-500">
                                Belum ada data transaksi donasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 2: Top 10 Donatur Terbesar -->
    <div x-show="tab === 'top'" class="space-y-4" style="display: none;">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-xs text-gray-500 dark:text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800">
                        <th class="py-2">Peringkat / Donatur</th>
                        <th class="py-2">Tipe</th>
                        <th class="py-2 text-right">Total Donasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($topDonors as $index => $donor)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/30 transition-colors duration-150">
                            <td class="py-3 flex items-center space-x-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold 
                                    {{ $index === 0 ? 'bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300' : '' }}
                                    {{ $index === 1 ? 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-300' : '' }}
                                    {{ $index === 2 ? 'bg-orange-100 text-orange-800 dark:bg-orange-950/60 dark:text-orange-300' : '' }}
                                    {{ $index > 2 ? 'bg-gray-50 text-gray-600 dark:bg-gray-900 dark:text-gray-400' : '' }}">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $donor->name }}</p>
                                    <span class="text-xs text-gray-400 dark:text-gray-500">{{ $donor->phone }}</span>
                                </div>
                            </td>
                            <td class="py-3 text-gray-500 dark:text-gray-400 text-xs">
                                {{ $donor->donor_type }}
                            </td>
                            <td class="py-3 text-right font-bold text-indigo-600 dark:text-indigo-400">
                                Rp{{ number_format($donor->donations_sum_amount ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-8 text-center text-gray-400 dark:text-gray-500">
                                Belum ada data donatur dengan status selesai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
