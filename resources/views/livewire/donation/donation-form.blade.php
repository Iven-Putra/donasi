<div class="max-w-2xl mx-auto">
    
    <form wire:submit="save" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        
        <!-- Header -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                    {{ $isEdit ? 'Ubah Transaksi Donasi' : 'Pencatatan Transaksi Donasi Baru' }}
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Pastikan nominal dan donatur yang dipilih telah sesuai.</p>
            </div>
            <a href="{{ route('donations.index') }}" wire:navigate class="text-xs text-indigo-650 hover:text-indigo-750 dark:text-indigo-400 dark:hover:text-indigo-300 font-semibold">
                Kembali ke Daftar
            </a>
        </div>

        <!-- Form Body -->
        <div class="p-6 space-y-6">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                
                <!-- Donatur -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Pilih Donatur *</label>
                    <select wire:model="donor_id" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Pilih Donatur --</option>
                        @foreach($donors as $donor)
                            <option value="{{ $donor->id }}">{{ $donor->donor_code }} - {{ $donor->name }} ({{ $donor->phone }})</option>
                        @endforeach
                    </select>
                    @error('donor_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Jenis Donasi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Pilih Program / Jenis Donasi *</label>
                    <select wire:model="donation_type_id" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Pilih Jenis --</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->code }} - {{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('donation_type_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Tanggal Transaksi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal & Waktu *</label>
                    <input type="datetime-local" wire:model="donation_date" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('donation_date') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Nominal Donasi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Nominal Donasi (Rp) *</label>
                    <input type="number" wire:model="amount" placeholder="Rp" min="0" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('amount') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Metode Pembayaran -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Metode Pembayaran *</label>
                    <select wire:model="payment_method" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="QRIS">QRIS</option>
                        <option value="E-Wallet">E-Wallet</option>
                    </select>
                    @error('payment_method') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Status Transaksi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Status Transaksi *</label>
                    <select wire:model="status" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="Selesai">Selesai</option>
                        <option value="Draft">Draft</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                    </select>
                    @error('status') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Keterangan / Notes -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Keterangan Tambahan</label>
                    <textarea wire:model="notes" rows="3" placeholder="Catatan opsional..." class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    @error('notes') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

            </div>

        </div>

        <!-- Form Footer -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 flex items-center justify-end space-x-3">
            <a href="{{ route('donations.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg shadow-sm transition-colors">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white text-sm font-bold rounded-lg shadow transition-colors focus:outline-none">
                <svg wire:loading class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ $isEdit ? 'Simpan Transaksi' : 'Catat Donasi' }}
            </button>
        </div>

    </form>
</div>
