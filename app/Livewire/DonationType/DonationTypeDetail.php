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

    public function exportExcel()
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

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header columns
        $headers = [
            'No. Transaksi', 'Tanggal Donasi', 'Nama Donatur', 
            'Nominal Donasi', 'Metode Pembayaran', 'Keterangan', 'Petugas Input', 'Status'
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
            $sheet->setCellValue('D' . $row, (float) $donation->amount);
            $sheet->setCellValue('E' . $row, $donation->payment_method);
            $sheet->setCellValue('F' . $row, $donation->notes);
            $sheet->setCellValue('G' . $row, $donation->user->name ?? '-');
            $sheet->setCellValue('H' . $row, $donation->status);
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
            'Content-Disposition' => 'attachment; filename="rincian-' . strtolower(str_replace(' ', '-', $this->type->name)) . '-' . date('Ymd-His') . '.xlsx"',
            'Cache-Control' => 'max-age=0',
        ];

        $callback = function () use ($writer) {
            $writer->save('php://output');
        };

        return response()->stream($callback, 200, $responseHeaders);
    }

    public function render()
    {
        $donationsQuery = Donation::query()
            ->where('donation_type_id', $this->type->id)
            ->where('status', 'Selesai') // Only show completed donations
            ->when($this->search, function ($query) {
                $query->where(function ($sub) {
                    $sub->where('transaction_number', 'like', '%' . $this->search . '%')
                        ->orWhereHas('donor', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            });

        $filteredTotal = $donationsQuery->sum('amount');
        
        $donations = $donationsQuery->with(['donor', 'user'])->orderBy('id', 'desc')->paginate(10);

        return view('livewire.donation-type.donation-type-detail', [
            'donations' => $donations,
            'filteredTotal' => $filteredTotal
        ])->layout('layouts.app', ['header' => 'Rincian Donasi: ' . $this->type->name]);
    }
}
