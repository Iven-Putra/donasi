<?php

namespace App\Livewire\DonationType;

use App\Models\DonationType;
use Livewire\Component;
use Livewire\WithPagination;

class DonationTypeList extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $type = DonationType::findOrFail($id);

        // Prevent deletion if the type has been used in transactions
        if ($type->donations()->count() > 0) {
            session()->flash('error', 'Jenis donasi tidak dapat dihapus karena sudah memiliki riwayat transaksi.');
            return;
        }

        $type->delete();
        session()->flash('message', 'Jenis donasi berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $type = DonationType::findOrFail($id);
        $type->is_active = !$type->is_active;
        $type->save();
        session()->flash('message', 'Status jenis donasi berhasil diubah.');
    }

    public function render()
    {
        $types = DonationType::query()
            ->when($this->search, function ($query) {
                $query->where(function ($sub) {
                    $sub->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('code', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('code', 'asc')
            ->paginate(10);

        return view('livewire.donation-type.donation-type-list', [
            'types' => $types
        ])->layout('layouts.app', ['header' => 'Master Jenis Donasi']);
    }
}
