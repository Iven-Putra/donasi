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

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 rounded-xl flex items-center space-x-2">
            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span class="font-semibold text-sm">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Toolbar / Search and Filters -->
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
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari jenis donasi..." class="w-full pl-10 rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Action Button -->
            <div>
                <a href="{{ route('donation-types.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-50 dark:hover:bg-indigo-600 text-white text-sm font-bold rounded-lg shadow transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Jenis Donasi
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
                        <th class="px-6 py-4">Kode</th>
                        <th class="px-6 py-4">Nama Jenis Donasi</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($types as $type)
                        <tr class="hover:bg-gray-50/40 dark:hover:bg-gray-900/20 transition-colors duration-150">
                            <!-- Code -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-xs font-bold px-2.5 py-1 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 rounded-lg">
                                    {{ $type->code }}
                                </span>
                            </td>
                            <!-- Name -->
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900 dark:text-white">
                                {{ $type->name }}
                            </td>
                            <!-- Description -->
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400 max-w-sm">
                                {{ $type->description ?? '-' }}
                            </td>
                            <!-- Status Toggle -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button type="button" wire:click="toggleStatus({{ $type->id }})" class="focus:outline-none">
                                    @if($type->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-300 cursor-pointer">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800 dark:bg-gray-700/60 dark:text-gray-400 cursor-pointer">
                                            Nonaktif
                                        </span>
                                    @endif
                                </button>
                            </td>
                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Edit -->
                                    <a href="{{ route('donation-types.edit', $type->id) }}" wire:navigate class="p-1.5 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-750 transition-colors" title="Ubah">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>

                                    <!-- Delete -->
                                    <button type="button" 
                                            onclick="confirm('Apakah Anda yakin ingin menghapus jenis donasi ini?') || event.stopImmediatePropagation()"
                                            wire:click="delete({{ $type->id }})" 
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
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500 font-semibold">
                                Tidak ada jenis donasi yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($types->hasPages())
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-805">
                {{ $types->links() }}
            </div>
        @endif
    </div>

</div>
