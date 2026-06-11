<div class="max-w-4xl mx-auto">
    
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-xl flex items-center space-x-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-semibold text-sm">{{ session('message') }}</span>
        </div>
    @endif

    <form wire:submit="save" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        
        <!-- Header -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white">Formulir Profil Organisasi</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Informasi ini akan ditampilkan pada kuitansi bukti donasi dan laporan PDF.</p>
        </div>

        <div class="p-6 space-y-6">
            
            <!-- Logo Section -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-6">
                <div class="relative w-24 h-24 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden">
                    @if ($logo)
                        <!-- Live upload preview -->
                        <img src="{{ $logo->temporaryUrl() }}" class="w-full h-full object-contain" alt="Preview Logo">
                    @elseif ($existingLogo)
                        <!-- Database saved logo -->
                        <img src="{{ asset('storage/' . $existingLogo) }}" class="w-full h-full object-contain" alt="Logo Organisasi">
                    @else
                        <!-- Fallback icon -->
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    @endif

                    <div wire:loading wire:target="logo" class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>

                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Logo Organisasi</label>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mb-2">Pilih file logo format PNG, JPG, atau JPEG. Maksimal 2MB.</p>
                    <input type="file" wire:model="logo" id="logo-upload" class="hidden">
                    <button type="button" onclick="document.getElementById('logo-upload').click()" class="inline-flex items-center px-4 py-2 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-950/40 dark:hover:bg-indigo-900/50 border border-indigo-200 dark:border-indigo-850 text-indigo-700 dark:text-indigo-300 text-xs font-semibold rounded-lg transition-colors">
                        Unggah Logo Baru
                    </button>
                    @error('logo') <span class="block text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <hr class="border-gray-100 dark:border-gray-800">

            <!-- Fields Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Nama Organisasi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama Organisasi *</label>
                    <input type="text" wire:model="name" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('name') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- NPWP Organisasi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">NPWP Organisasi</label>
                    <input type="text" wire:model="tax_number" placeholder="00.000.000.0-000.000" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('tax_number') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Telepon -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Nomor Telepon</label>
                    <input type="text" wire:model="phone" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('phone') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <input type="email" wire:model="email" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('email') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Website -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Website URL</label>
                    <input type="url" wire:model="website" placeholder="https://contoh.org" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('website') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Alamat Lengkap -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Alamat Lengkap</label>
                    <textarea wire:model="address" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    @error('address') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Kota -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Kota / Kabupaten</label>
                    <input type="text" wire:model="city" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('city') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Provinsi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Provinsi</label>
                    <input type="text" wire:model="province" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('province') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Kode Pos -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Kode Pos</label>
                    <input type="text" wire:model="postal_code" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('postal_code') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Space -->
                <div></div>

                <!-- Nama Ketua -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama Ketua / Pimpinan</label>
                    <input type="text" wire:model="chairman_name" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('chairman_name') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Nama Bendahara -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama Bendahara</label>
                    <input type="text" wire:model="treasurer_name" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('treasurer_name') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

            </div>

        </div>

        <!-- Form Footer -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 flex items-center justify-end space-x-3">
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white text-sm font-bold rounded-lg shadow transition-colors focus:outline-none">
                <svg wire:loading class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Simpan Perubahan
            </button>
        </div>

    </form>
</div>
