<?php

namespace App\Livewire\Dashboard;

use App\Models\Donor;
use App\Models\Donation;
use App\Models\DonationType;
use Livewire\Component;

class DashboardStats extends Component
{
    public $totalDonors;
    public $totalDonationsCount;
    public $totalNominal;
    public $donationsThisMonth;
    public $donationsToday;
    public $donationsByType = [];

    public function mount()
    {
        $this->totalDonors = Donor::count();
        $this->totalDonationsCount = Donation::where('status', 'Selesai')->count();
        $this->totalNominal = Donation::where('status', 'Selesai')->sum('amount');
        
        $this->donationsThisMonth = Donation::where('status', 'Selesai')
            ->whereMonth('donation_date', now()->month)
            ->whereYear('donation_date', now()->year)
            ->sum('amount');
            
        $this->donationsToday = Donation::where('status', 'Selesai')
            ->whereDate('donation_date', today())
            ->sum('amount');

        // Fetch donations grouped by type
        $this->donationsByType = DonationType::withSum(['donations' => function ($query) {
            $query->where('status', 'Selesai');
        }], 'amount')
        ->get()
        ->map(function ($type) {
            return [
                'id' => $type->id,
                'name' => $type->name,
                'code' => $type->code,
                'flyer' => $type->flyer,
                'total' => $type->donations_sum_amount ?? 0
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-stats');
    }
}
