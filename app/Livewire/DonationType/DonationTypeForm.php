<?php

namespace App\Livewire\DonationType;

use App\Models\DonationType;
use Livewire\Component;
use Livewire\WithFileUploads;

class DonationTypeForm extends Component
{
    use WithFileUploads;

    public $typeId = null;
    public $isEdit = false;

    // Fields
    public $code = '';
    public $name = '';
    public $description = '';
    public $flyer = null; // Temp uploaded flyer file
    public $existingFlyer = null; // Saved flyer path
    public $is_active = true;

    protected function rules()
    {
        return [
            'code' => 'required|string|max:50|unique:donation_types,code,' . ($this->typeId ?? 'NULL'),
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'flyer' => 'nullable|image|max:2048', // max 2MB
            'is_active' => 'boolean',
        ];
    }

    protected $validationAttributes = [
        'code' => 'Kode Jenis Donasi',
        'name' => 'Nama Jenis Donasi',
        'description' => 'Deskripsi',
        'flyer' => 'Gambar/Flyer Donasi',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->typeId = $id;
            $this->isEdit = true;
            $type = DonationType::findOrFail($id);

            $this->code = $type->code;
            $this->name = $type->name;
            $this->description = $type->description;
            $this->existingFlyer = $type->flyer;
            $this->is_active = $type->is_active;
        } else {
            // Auto generate a suggested code for the user
            $latestId = DonationType::max('id') ?? 0;
            $nextId = $latestId + 1;
            $this->code = 'JNS-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        if ($this->flyer) {
            $flyerPath = $this->flyer->store('flyers', 'public');
            $data['flyer'] = $flyerPath;
            $this->existingFlyer = $flyerPath;
            $this->flyer = null;
        }

        if ($this->isEdit) {
            $type = DonationType::findOrFail($this->typeId);
            $type->update($data);
            session()->flash('message', 'Jenis donasi berhasil diperbarui.');
        } else {
            DonationType::create($data);
            session()->flash('message', 'Jenis donasi berhasil ditambahkan.');
        }

        return $this->redirectRoute('donation-types.index', navigate: true);
    }

    public function render()
    {
        $title = $this->isEdit ? 'Ubah Jenis Donasi' : 'Tambah Jenis Donasi Baru';
        return view('livewire.donation-type.donation-type-form')
            ->layout('layouts.app', ['header' => $title]);
    }
}
