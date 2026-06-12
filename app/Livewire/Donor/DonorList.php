<?php

namespace App\Livewire\Donor;

use App\Models\Donor;
use Livewire\Component;
use Livewire\WithPagination;

class DonorList extends Component
{
    use WithPagination;

    public $search = '';
    public $typeFilter = '';
    public $statusFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $donor = Donor::findOrFail($id);
        
        // Prevent deletion if donor has donations
        if ($donor->donations()->count() > 0) {
            session()->flash('error', 'Donatur tidak dapat dihapus karena sudah memiliki riwayat transaksi donasi.');
            return;
        }

        $donor->delete();
        session()->flash('message', 'Data donatur berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $donor = Donor::findOrFail($id);
        $donor->is_active = !$donor->is_active;
        $donor->save();
        session()->flash('message', 'Status donatur berhasil diubah.');
    }

    public function exportExcel()
    {
        $donors = Donor::query()
            ->when($this->search, function ($query) {
                $query->where(function ($sub) {
                    $sub->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('donor_code', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('donor_type', $this->typeFilter);
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('is_active', $this->statusFilter === '1');
            })
            ->orderBy('id', 'desc')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header columns
        $headers = [
            'ID', 'Kode Donatur', 'Nama Donatur', 'Jenis Donatur', 
            'No. Telepon', 'Email', 'Alamat', 'Kota', 'Provinsi', 
            'Tanggal Gabung', 'Status'
        ];

        foreach ($headers as $colIndex => $headerText) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
            $sheet->setCellValue($colLetter . '1', $headerText);
        }

        $row = 2;
        foreach ($donors as $donor) {
            $sheet->setCellValue('A' . $row, $donor->id);
            $sheet->setCellValue('B' . $row, $donor->donor_code);
            $sheet->setCellValue('C' . $row, $donor->name);
            $sheet->setCellValue('D' . $row, $donor->donor_type);
            $sheet->setCellValue('E' . $row, $donor->phone);
            $sheet->setCellValue('F' . $row, $donor->email);
            $sheet->setCellValue('G' . $row, $donor->address);
            $sheet->setCellValue('H' . $row, $donor->city);
            $sheet->setCellValue('I' . $row, $donor->province);
            $sheet->setCellValue('J' . $row, $donor->join_date->format('Y-m-d'));
            $sheet->setCellValue('K' . $row, $donor->is_active ? 'Aktif' : 'Nonaktif');
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
            'Content-Disposition' => 'attachment; filename="data-donatur-' . date('Ymd-His') . '.xlsx"',
            'Cache-Control' => 'max-age=0',
        ];

        $callback = function () use ($writer) {
            $writer->save('php://output');
        };

        return response()->stream($callback, 200, $responseHeaders);
    }

    public function render()
    {
        $donors = Donor::query()
            ->when($this->search, function ($query) {
                $query->where(function ($sub) {
                    $sub->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('donor_code', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('donor_type', $this->typeFilter);
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('is_active', $this->statusFilter === '1');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.donor.donor-list', [
            'donors' => $donors
        ])->layout('layouts.app', ['header' => 'Master Data Donatur']);
    }
}
