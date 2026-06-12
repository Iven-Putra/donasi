<div>
    <!-- KPI Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        
        <!-- Total Donatur -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Donatur</p>
                    <h3 class="text-3xl font-bold mt-1 text-gray-900 dark:text-white">{{ number_format($totalDonors, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-gray-500 dark:text-gray-400">
                <span class="text-emerald-500 font-semibold flex items-center mr-1">
                    <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    Aktif
                </span>
                dalam sistem
            </div>
        </div>

        <!-- Total Donasi -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Donasi</p>
                    <h3 class="text-3xl font-bold mt-1 text-gray-900 dark:text-white">{{ number_format($totalDonationsCount, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-gray-500 dark:text-gray-400">
                <span class="text-emerald-500 font-semibold mr-1">Status Selesai</span>
                tercatat
            </div>
        </div>

        <!-- Total Nominal Donasi -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Nominal</p>
                    <h3 class="text-2xl font-bold mt-1.5 text-gray-900 dark:text-white">Rp{{ number_format($totalNominal, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-gray-500 dark:text-gray-400">
                <span class="text-rose-500 font-semibold mr-1">Kumulatif</span>
                seluruh waktu
            </div>
        </div>

        <!-- Donasi Bulan Ini -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Bulan Ini</p>
                    <h3 class="text-2xl font-bold mt-1.5 text-gray-900 dark:text-white">Rp{{ number_format($this->donationsThisMonth, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-gray-500 dark:text-gray-400">
                <span class="text-amber-500 font-semibold mr-1">{{ now()->translatedFormat('F Y') }}</span>
                berjalan
            </div>
        </div>

        <!-- Donasi Hari Ini -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Hari Ini</p>
                    <h3 class="text-2xl font-bold mt-1.5 text-gray-900 dark:text-white">Rp{{ number_format($this->donationsToday, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-sky-50 dark:bg-sky-950/50 text-sky-600 dark:text-sky-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-gray-500 dark:text-gray-400">
                <span class="text-sky-500 font-semibold mr-1">{{ now()->translatedFormat('d F Y') }}</span>
                realtime
            </div>
        </div>

    </div>

    <!-- Donasi Per Jenis -->
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Donasi Per Jenis Program</h4>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($donationsByType as $type)
                @if(!empty($type['flyer']))
                    <a href="{{ route('donation-types.details', $type['id']) }}" wire:navigate class="relative block p-4 rounded-xl border border-gray-100 dark:border-gray-800 hover:shadow-md transition-all duration-300 overflow-hidden group min-h-[110px] flex flex-col justify-between">
                        <!-- Flyer image background -->
                        <img src="{{ asset('storage/' . $type['flyer']) }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 z-0" alt="{{ $type['name'] }}">
                        <!-- Premium dark overlay/mask -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/50 to-black/35 group-hover:from-black/80 group-hover:via-black/45 group-hover:to-black/30 transition-all duration-300 z-10"></div>
                        
                        <!-- Content -->
                        <div class="relative z-20 flex flex-col h-full justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="text-[10px] font-extrabold px-2 py-0.5 bg-white/20 text-white rounded backdrop-blur-sm border border-white/10 tracking-wider">
                                    {{ $type['code'] }}
                                </span>
                                <span class="text-sm font-semibold text-white truncate max-w-[120px] group-hover:text-indigo-200 transition-colors" title="{{ $type['name'] }}">
                                    {{ $type['name'] }}
                                </span>
                            </div>
                            <p class="text-lg font-bold text-white mt-4">
                                Rp{{ number_format($type['total'], 0, ',', '.') }}
                            </p>
                        </div>
                    </a>
                @else
                    <a href="{{ route('donation-types.details', $type['id']) }}" wire:navigate class="block p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-100 dark:border-gray-800 hover:border-indigo-500 dark:hover:border-indigo-400 hover:shadow-md transition-all duration-300 min-h-[110px] flex flex-col justify-between group">
                        <div class="flex flex-col h-full justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="text-[10px] font-extrabold px-2 py-0.5 bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 rounded tracking-wider">
                                    {{ $type['code'] }}
                                </span>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 truncate max-w-[120px] group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors" title="{{ $type['name'] }}">
                                    {{ $type['name'] }}
                                </span>
                            </div>
                            <p class="text-lg font-bold text-gray-900 dark:text-white mt-4">
                                Rp{{ number_format($type['total'], 0, ',', '.') }}
                            </p>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>
