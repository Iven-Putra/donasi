<?php

namespace App\Livewire\Donation;

use App\Models\Donation;
use App\Models\Donor;
use App\Models\DonationType;
use Livewire\Component;

class DonationForm extends Component
{
    public $donationId = null;
    public $isEdit = false;

    // Fields
    public $donation_date = '';
    public $donor_id = '';
    public $donation_type_id = '';
    public $amount = 0;
    public $payment_method = 'Transfer Bank';
    public $notes = '';
    public $status = 'Selesai';

    protected function rules()
    {
        return [
            'donation_date' => 'required|date',
            'donor_id' => 'required|exists:donors,id',
            'donation_type_id' => 'required|exists:donation_types,id',
            'amount' => 'required|numeric|min:1000', // Minimum Rp1.000
            'payment_method' => 'required|string|in:Tunai,Transfer Bank,QRIS,E-Wallet',
            'notes' => 'nullable|string',
            'status' => 'required|string|in:Draft,Selesai,Dibatalkan',
        ];
    }

    protected $validationAttributes = [
        'donation_date' => 'Tanggal Donasi',
        'donor_id' => 'Donatur',
        'donation_type_id' => 'Jenis Donasi',
        'amount' => 'Nominal Donasi',
        'payment_method' => 'Metode Pembayaran',
        'notes' => 'Keterangan',
        'status' => 'Status',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->donationId = $id;
            $this->isEdit = true;
            $donation = Donation::findOrFail($id);

            $this->donation_date = $donation->donation_date->format('Y-m-d\TH:i');
            $this->donor_id = $donation->donor_id;
            $this->donation_type_id = $donation->donation_type_id;
            $this->amount = (float) $donation->amount;
            $this->payment_method = $donation->payment_method;
            $this->notes = $donation->notes;
            $this->status = $donation->status;
        } else {
            $this->donation_date = now()->format('Y-m-d\TH:i');
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'donation_date' => $this->donation_date,
            'donor_id' => $this->donor_id,
            'donation_type_id' => $this->donation_type_id,
            'amount' => $this->amount,
            'payment_method' => $this->payment_method,
            'notes' => $this->notes,
            'status' => $this->status,
        ];

        if ($this->isEdit) {
            $donation = Donation::findOrFail($this->donationId);
            $donation->update($data);
            session()->flash('message', 'Transaksi donasi berhasil diperbarui.');
        } else {
            $data['user_id'] = auth()->id(); // Logged in operator/admin
            Donation::create($data);
            session()->flash('message', 'Transaksi donasi berhasil dicatat.');
        }

        return $this->redirectRoute('donations.index', navigate: true);
    }

    public function render()
    {
        $donors = Donor::where('is_active', true)->orderBy('name', 'asc')->get();
        $types = DonationType::where('is_active', true)->orderBy('name', 'asc')->get();
        $title = $this->isEdit ? 'Ubah Data Transaksi Donasi' : 'Pencatatan Donasi Baru';

        return view('livewire.donation.donation-form', [
            'donors' => $donors,
            'types' => $types,
        ])->layout('layouts.app', ['header' => $title]);
    }
}
