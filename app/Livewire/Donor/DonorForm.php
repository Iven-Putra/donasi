<?php

namespace App\Livewire\Donor;

use App\Models\Donor;
use Livewire\Component;

class DonorForm extends Component
{
    public $donorId = null;
    public $isEdit = false;

    // Fields
    public $donor_type = 'Perorangan';
    public $name = '';
    public $phone = '';
    public $email = '';
    public $address = '';
    public $city = '';
    public $province = '';
    public $join_date = '';
    public $is_active = true;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'donor_type' => 'required|string|in:Perorangan,Perusahaan,Komunitas',
            'phone' => 'required|string|unique:donors,phone,' . ($this->donorId ?? 'NULL'),
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'join_date' => 'required|date',
            'is_active' => 'boolean',
        ];
    }

    protected $validationAttributes = [
        'name' => 'Nama Donatur',
        'donor_type' => 'Jenis Donatur',
        'phone' => 'Nomor Telepon',
        'email' => 'Email',
        'address' => 'Alamat',
        'city' => 'Kota',
        'province' => 'Provinsi',
        'join_date' => 'Tanggal Bergabung',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->donorId = $id;
            $this->isEdit = true;
            $donor = Donor::findOrFail($id);

            $this->donor_type = $donor->donor_type;
            $this->name = $donor->name;
            $this->phone = $donor->phone;
            $this->email = $donor->email;
            $this->address = $donor->address;
            $this->city = $donor->city;
            $this->province = $donor->province;
            $this->join_date = $donor->join_date->format('Y-m-d');
            $this->is_active = $donor->is_active;
        } else {
            $this->join_date = date('Y-m-d');
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'donor_type' => $this->donor_type,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'city' => $this->city,
            'province' => $this->province,
            'join_date' => $this->join_date,
            'is_active' => $this->is_active,
        ];

        if ($this->isEdit) {
            $donor = Donor::findOrFail($this->donorId);
            $donor->update($data);
            session()->flash('message', 'Donatur berhasil diperbarui.');
        } else {
            Donor::create($data);
            session()->flash('message', 'Donatur berhasil didaftarkan.');
        }

        return $this->redirectRoute('donors.index', navigate: true);
    }

    public function render()
    {
        $title = $this->isEdit ? 'Ubah Data Donatur' : 'Tambah Donatur Baru';
        return view('livewire.donor.donor-form')
            ->layout('layouts.app', ['header' => $title]);
    }
}
