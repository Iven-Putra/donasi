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

    public function exportCsv()
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

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data-donatur-' . date('Ymd-His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($donors) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for proper Excel encoding
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header columns
            fputcsv($file, [
                'ID', 'Kode Donatur', 'Nama Donatur', 'Jenis Donatur', 
                'No. Telepon', 'Email', 'Alamat', 'Kota', 'Provinsi', 
                'Tanggal Gabung', 'Status'
            ]);

            foreach ($donors as $donor) {
                fputcsv($file, [
                    $donor->id,
                    $donor->donor_code,
                    $donor->name,
                    $donor->donor_type,
                    $donor->phone,
                    $donor->email,
                    $donor->address,
                    $donor->city,
                    $donor->province,
                    $donor->join_date->format('Y-m-d'),
                    $donor->is_active ? 'Aktif' : 'Nonaktif',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
