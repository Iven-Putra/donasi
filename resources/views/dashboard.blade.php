<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard Pemantauan Donasi') }}
            </h2>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Pencatatan Aktif: {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Widget 0: Promotional Banner Image Slider -->
            <livewire:dashboard.image-slider />
            
            <!-- Widget 1: Statistics Summary & Donation Type breakdown -->
            <livewire:dashboard.dashboard-stats />

            <!-- Widget 2 & 3 Grid: Chart on Left, Recent logs on Right -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <livewire:dashboard.donation-chart />
                </div>
                <div>
                    <livewire:dashboard.recent-donations />
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
