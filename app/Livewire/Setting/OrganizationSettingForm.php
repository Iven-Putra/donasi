<?php

namespace App\Livewire\Setting;

use App\Models\Organization;
use Livewire\Component;
use Livewire\WithFileUploads;

class OrganizationSettingForm extends Component
{
    use WithFileUploads;

    public $organization;
    public $name;
    public $logo; // Temp uploaded file
    public $existingLogo; // DB stored path
    public $address;
    public $city;
    public $province;
    public $postal_code;
    public $phone;
    public $email;
    public $website;
    public $chairman_name;
    public $treasurer_name;
    public $tax_number;

    protected $rules = [
        'name' => 'required|string|max:255',
        'logo' => 'nullable|image|max:2048', // max 2MB
        'address' => 'nullable|string',
        'city' => 'nullable|string|max:100',
        'province' => 'nullable|string|max:100',
        'postal_code' => 'nullable|string|max:20',
        'phone' => 'nullable|string|max:50',
        'email' => 'nullable|email|max:100',
        'website' => 'nullable|url|max:255',
        'chairman_name' => 'nullable|string|max:255',
        'treasurer_name' => 'nullable|string|max:255',
        'tax_number' => 'nullable|string|max:50',
    ];

    public function mount()
    {
        $this->organization = Organization::first() ?? new Organization();

        $this->name = $this->organization->name;
        $this->existingLogo = $this->organization->logo;
        $this->address = $this->organization->address;
        $this->city = $this->organization->city;
        $this->province = $this->organization->province;
        $this->postal_code = $this->organization->postal_code;
        $this->phone = $this->organization->phone;
        $this->email = $this->organization->email;
        $this->website = $this->organization->website;
        $this->chairman_name = $this->organization->chairman_name;
        $this->treasurer_name = $this->organization->treasurer_name;
        $this->tax_number = $this->organization->tax_number;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'email' => $this->email,
            'website' => $this->website,
            'chairman_name' => $this->chairman_name,
            'treasurer_name' => $this->treasurer_name,
            'tax_number' => $this->tax_number,
        ];

        if ($this->logo) {
            $logoPath = $this->logo->store('logos', 'public');
            $data['logo'] = $logoPath;
            $this->existingLogo = $logoPath;
            $this->logo = null; // Reset file input
        }

        if ($this->organization->exists) {
            $this->organization->update($data);
        } else {
            $this->organization = Organization::create($data);
        }

        session()->flash('message', 'Profil Organisasi berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.setting.organization-setting-form')
            ->layout('layouts.app', ['header' => 'Pengaturan Profil Organisasi']);
    }
}
