<?php

namespace App\Livewire\Donation;

use App\Models\Donation;
use App\Models\Donor;
use App\Models\DonationType;
use Livewire\Component;
use Livewire\WithPagination;

class DonationList extends Component
{
    use WithPagination;

    // Filters
    public $search = '';
    public $donorFilter = '';
    public $typeFilter = '';
    public $statusFilter = '';
    public $startDate = '';
    public $endDate = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'donorFilter' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
    ];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingDonorFilter() { $this->resetPage(); }
    public function updatingTypeFilter() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }
    public function updatingStartDate() { $this->resetPage(); }
    public function updatingEndDate() { $this->resetPage(); }

    public function delete($id)
    {
        $donation = Donation::findOrFail($id);
        $donation->delete();
        session()->flash('message', 'Transaksi donasi berhasil dihapus.');
    }

    public function toggleStatus($id, $newStatus)
    {
        $donation = Donation::findOrFail($id);
        $donation->status = $newStatus;
        $donation->save();
        session()->flash('message', 'Status transaksi berhasil diperbarui.');
    }

    public function exportCsv()
    {
        $donations = Donation::query()
            ->with(['donor', 'donationType', 'user'])
            ->when($this->search, function ($query) {
                $query->where(function ($sub) {
                    $sub->where('transaction_number', 'like', '%' . $this->search . '%')
                        ->orWhereHas('donor', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->donorFilter, function ($query) {
                $query->where('donor_id', $this->donorFilter);
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('donation_type_id', $this->typeFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->startDate, function ($query) {
                $query->whereDate('donation_date', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('donation_date', '<=', $this->endDate);
            })
            ->orderBy('donation_date', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan-donasi-' . date('Ymd-His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($donations) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM

            // Header columns
            fputcsv($file, [
                'No. Transaksi', 'Tanggal Donasi', 'Nama Donatur', 'Tipe Donatur', 
                'Jenis Donasi', 'Nominal Donasi', 'Metode Pembayaran', 
                'Keterangan', 'Petugas Input', 'Status'
            ]);

            foreach ($donations as $donation) {
                fputcsv($file, [
                    $donation->transaction_number,
                    $donation->donation_date->format('Y-m-d H:i:s'),
                    $donation->donor->name ?? 'Donatur Umum',
                    $donation->donor->donor_type ?? '-',
                    $donation->donationType->name ?? '-',
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
            ->with(['donor', 'donationType', 'user'])
            ->when($this->search, function ($query) {
                $query->where(function ($sub) {
                    $sub->where('transaction_number', 'like', '%' . $this->search . '%')
                        ->orWhereHas('donor', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->donorFilter, function ($query) {
                $query->where('donor_id', $this->donorFilter);
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('donation_type_id', $this->typeFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->startDate, function ($query) {
                $query->whereDate('donation_date', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('donation_date', '<=', $this->endDate);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Fetch options for filters
        $donors = Donor::where('is_active', true)->orderBy('name', 'asc')->get();
        $types = DonationType::where('is_active', true)->orderBy('name', 'asc')->get();

        return view('livewire.donation.donation-list', [
            'donations' => $donations,
            'donors' => $donors,
            'types' => $types,
        ])->layout('layouts.app', ['header' => 'Daftar Transaksi Donasi']);
    }
}
