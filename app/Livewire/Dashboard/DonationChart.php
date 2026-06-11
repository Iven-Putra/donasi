<?php

namespace App\Livewire\Dashboard;

use App\Models\Donation;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DonationChart extends Component
{
    public $labels = [];
    public $values = [];

    public function mount()
    {
        // Prepare container for the last 6 months
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $data[$month->format('Y-m')] = [
                'label' => $month->translatedFormat('M Y'),
                'value' => 0
            ];
        }

        // Fetch sum of donations for status = Selesai grouped by month
        $donations = Donation::select(
            DB::raw("DATE_FORMAT(donation_date, '%Y-%m') as month"),
            DB::raw("SUM(amount) as total")
        )
        ->where('status', 'Selesai')
        ->where('donation_date', '>=', now()->subMonths(5)->startOfMonth())
        ->groupBy('month')
        ->get();

        foreach ($donations as $donation) {
            if (isset($data[$donation->month])) {
                $data[$donation->month]['value'] = (float) $donation->total;
            }
        }

        $this->labels = array_column($data, 'label');
        $this->values = array_column($data, 'value');
    }

    public function render()
    {
        return view('livewire.dashboard.donation-chart');
    }
}
