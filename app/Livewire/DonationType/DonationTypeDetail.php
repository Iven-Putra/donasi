<?php

namespace App\Livewire\DonationType;

use App\Models\Donation;
use App\Models\DonationType;
use Livewire\Component;
use Livewire\WithPagination;

class DonationTypeDetail extends Component
{
    use WithPagination;

    public $type;
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount($id)
    {
        $this->type = DonationType::findOrFail($id);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function exportCsv()
    {
        $donations = Donation::query()
            ->with(['donor', 'user'])
            ->where('donation_type_id', $this->type->id)
            ->where('status', 'Selesai')
            ->when($this->search, function ($query) {
                $query->where(function ($sub) {
                    $sub->where('transaction_number', 'like', '%' . $this->search . '%')
                        ->orWhereHas('donor', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="rincian-' . strtolower(str_replace(' ', '-', $this->type->name)) . '-' . date('Ymd-His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($donations) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM

            // Header columns
            fputcsv($file, [
                'No. Transaksi', 'Tanggal Donasi', 'Nama Donatur', 
                'Nominal Donasi', 'Metode Pembayaran', 'Keterangan', 'Petugas Input', 'Status'
            ]);

            foreach ($donations as $donation) {
                fputcsv($file, [
                    $donation->transaction_number,
                    $donation->donation_date->format('Y-m-d H:i:s'),
                    $donation->donor->name ?? 'Donatur Umum',
                    (float) $donation->amount,
                    $donation->payment_method,
                    $donation->notes,
                    $donation->user->name ?? '-',
                    $donation->status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $donations = Donation::query()
            ->with(['donor', 'user'])
            ->where('donation_type_id', $this->type->id)
            ->where('status', 'Selesai') // Only show completed donations
            ->when($this->search, function ($query) {
                $query->where(function ($sub) {
                    $sub->where('transaction_number', 'like', '%' . $this->search . '%')
                        ->orWhereHas('donor', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.donation-type.donation-type-detail', [
            'donations' => $donations
        ])->layout('layouts.app', ['header' => 'Rincian Donasi: ' . $this->type->name]);
    }
}
