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

    public function exportExcel()
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

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header columns
        $headers = [
            'No. Transaksi', 'Tanggal Donasi', 'Nama Donatur', 'Tipe Donatur', 
            'Jenis Donasi', 'Nominal Donasi', 'Metode Pembayaran', 
            'Keterangan', 'Petugas Input', 'Status'
        ];

        foreach ($headers as $colIndex => $headerText) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
            $sheet->setCellValue($colLetter . '1', $headerText);
        }

        $row = 2;
        foreach ($donations as $donation) {
            $sheet->setCellValue('A' . $row, $donation->transaction_number);
            $sheet->setCellValue('B' . $row, $donation->donation_date->format('Y-m-d H:i:s'));
            $sheet->setCellValue('C' . $row, $donation->donor->name ?? 'Donatur Umum');
            $sheet->setCellValue('D' . $row, $donation->donor->donor_type ?? '-');
            $sheet->setCellValue('E' . $row, $donation->donationType->name ?? '-');
            $sheet->setCellValue('F' . $row, (float) $donation->amount);
            $sheet->setCellValue('G' . $row, $donation->payment_method);
            $sheet->setCellValue('H' . $row, $donation->notes);
            $sheet->setCellValue('I' . $row, $donation->user->name ?? '-');
            $sheet->setCellValue('J' . $row, $donation->status);
            $row++;
        }

        // Auto size columns for perfect rendering
        foreach (range(1, count($headers)) as $colIndex) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $responseHeaders = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="laporan-donasi-' . date('Ymd-His') . '.xlsx"',
            'Cache-Control' => 'max-age=0',
        ];

        $callback = function () use ($writer) {
            $writer->save('php://output');
        };

        return response()->stream($callback, 200, $responseHeaders);
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
