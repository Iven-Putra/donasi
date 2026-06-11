<div class="max-w-2xl mx-auto">
    
    <form wire:submit="save" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        
        <!-- Header -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                    {{ $isEdit ? 'Ubah Jenis Donasi' : 'Tambah Jenis Donasi Baru' }}
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Silakan lengkapi formulir di bawah ini dengan benar.</p>
            </div>
            <a href="{{ route('donation-types.index') }}" wire:navigate class="text-xs text-indigo-650 hover:text-indigo-750 dark:text-indigo-400 dark:hover:text-indigo-300 font-semibold">
                Kembali ke Daftar
            </a>
        </div>

        <!-- Form Body -->
        <div class="p-6 space-y-6">
            
            <div class="space-y-6">
                
                <!-- Kode Jenis Donasi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Kode Jenis Donasi *</label>
                    <input type="text" wire:model="code" placeholder="Contoh: ZKT" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 uppercase">
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Gunakan kode pendek unik untuk mempermudah identifikasi program.</p>
                    @error('code') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Nama Jenis Donasi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama Program Jenis Donasi *</label>
                    <input type="text" wire:model="name" placeholder="Contoh: Zakat Fitrah" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Gambar/Flyer Donasi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Gambar / Flyer Program</label>
                    <div class="flex items-center space-x-4">
                        <div class="relative w-28 h-20 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg flex items-center justify-center overflow-hidden">
                            @if ($flyer)
                                <img src="{{ $flyer->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview Flyer">
                            @elseif ($existingFlyer)
                                <img src="{{ asset('storage/' . $existingFlyer) }}" class="w-full h-full object-cover" alt="Flyer Donasi">
                            @else
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            @endif

                            <div wire:loading wire:target="flyer" class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="flex-1">
                            <input type="file" wire:model="flyer" id="flyer-upload" class="hidden" accept="image/*">
                            <button type="button" onclick="document.getElementById('flyer-upload').click()" class="inline-flex items-center px-3.5 py-2 border border-gray-305 dark:border-gray-700 bg-white dark:bg-gray-850 hover:bg-gray-50 dark:hover:bg-gray-750 text-gray-700 dark:text-gray-300 text-xs font-semibold rounded-lg shadow-sm transition-colors">
                                Pilih Gambar
                            </button>
                            <p class="text-[10px] text-gray-400 dark:text-gray-505 mt-1">PNG, JPG, JPEG. Maksimal 2MB.</p>
                            @error('flyer') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Deskripsi Program</label>
                    <textarea wire:model="description" rows="4" placeholder="Penjelasan singkat mengenai peruntukan donasi ini..." class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    @error('description') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Status Aktif -->
                <div class="flex items-center space-x-2 pt-2">
                    <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-gray-300 dark:border-gray-700 text-indigo-655 focus:ring-indigo-500">
                    <label for="is_active" class="text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer">
                        Status Aktif (Tampilkan jenis donasi ini sebagai pilihan transaksi)
                    </label>
                    @error('is_active') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

            </div>

        </div>

        <!-- Form Footer -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 flex items-center justify-end space-x-3">
            <a href="{{ route('donation-types.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg shadow-sm transition-colors">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white text-sm font-bold rounded-lg shadow transition-colors focus:outline-none">
                <svg wire:loading class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ $isEdit ? 'Simpan Perubahan' : 'Tambahkan Jenis Donasi' }}
            </button>
        </div>

    </form>
</div>
