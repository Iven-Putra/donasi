<div class="max-w-2xl mx-auto">
    
    <form wire:submit="save" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        
        <!-- Header -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                    {{ $isEdit ? 'Ubah Data Donatur' : 'Daftarkan Donatur Baru' }}
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Silakan lengkapi formulir di bawah ini dengan data yang benar.</p>
            </div>
            <a href="{{ route('donors.index') }}" wire:navigate class="text-xs text-indigo-650 hover:text-indigo-750 dark:text-indigo-400 dark:hover:text-indigo-300 font-semibold">
                Kembali ke Daftar
            </a>
        </div>

        <!-- Form Body -->
        <div class="p-6 space-y-6">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                
                <!-- Nama Donatur -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap Donatur *</label>
                    <input type="text" wire:model="name" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Jenis Donatur -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Jenis Donatur *</label>
                    <select wire:model="donor_type" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="Perorangan">Perorangan</option>
                        <option value="Perusahaan">Perusahaan</option>
                        <option value="Komunitas">Komunitas</option>
                    </select>
                    @error('donor_type') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Tanggal Bergabung -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Bergabung *</label>
                    <input type="date" wire:model="join_date" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('join_date') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Nomor Telepon / WhatsApp *</label>
                    <input type="text" wire:model="phone" placeholder="08xxxxxxxxxx" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('phone') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <input type="email" wire:model="email" placeholder="nama@email.com" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('email') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Alamat Lengkap -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Alamat Lengkap</label>
                    <textarea wire:model="address" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    @error('address') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Kota -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Kota / Kabupaten</label>
                    <input type="text" wire:model="city" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('city') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Provinsi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Provinsi</label>
                    <input type="text" wire:model="province" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('province') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Status Aktif -->
                <div class="sm:col-span-2 flex items-center space-x-2 pt-2">
                    <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-gray-300 dark:border-gray-700 text-indigo-655 focus:ring-indigo-500">
                    <label for="is_active" class="text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer">
                        Donatur berstatus Aktif (Dapat menerima pencatatan donasi baru)
                    </label>
                    @error('is_active') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

            </div>

        </div>

        <!-- Form Footer -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 flex items-center justify-end space-x-3">
            <a href="{{ route('donors.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg shadow-sm transition-colors">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white text-sm font-bold rounded-lg shadow transition-colors focus:outline-none">
                <svg wire:loading class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ $isEdit ? 'Simpan Perubahan' : 'Daftarkan Donatur' }}
            </button>
        </div>

    </form>
</div>
