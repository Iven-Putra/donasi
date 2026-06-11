<?php

namespace App\Livewire\Dashboard;

use App\Models\Donation;
use App\Models\Donor;
use Livewire\Component;

class RecentDonations extends Component
{
    public $recentDonations = [];
    public $topDonors = [];

    public function mount()
    {
        // Fetch 10 most recent donations
        $this->recentDonations = Donation::with(['donor', 'donationType'])
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        // Fetch top 10 donors based on total donation amounts
        $this->topDonors = Donor::withSum(['donations' => function ($query) {
            $query->where('status', 'Selesai');
        }], 'amount')
        ->orderBy('donations_sum_amount', 'desc')
        ->limit(10)
        ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.recent-donations');
    }
}
