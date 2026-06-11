<?php

namespace App\Livewire\Donation;

use App\Models\Donation;
use App\Models\Organization;
use Livewire\Component;

class DonationDetail extends Component
{
    public $donation;

    public function mount($id)
    {
        $this->donation = Donation::with(['donor', 'donationType', 'user'])
            ->findOrFail($id);
    }

    public function getWhatsappUrl()
    {
        $donor = $this->donation->donor;
        if (!$donor || !$donor->phone) {
            return '#';
        }

        // Format Indonesian phone numbers safely
        $phone = preg_replace('/[^0-9]/', '', $donor->phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $org = Organization::first() ?? new Organization(['name' => 'Yayasan Donasi']);

        // Format Indonesian Receipt Message
        $message = "Halo *" . $donor->name . "*,\n\n" .
            "Terima kasih atas donasi yang Anda salurkan melalui *" . $org->name . "*.\n" .
            "Berikut adalah bukti pencatatan tanda terima donasi Anda:\n\n" .
            "• *No. Transaksi:* " . $this->donation->transaction_number . "\n" .
            "• *Tanggal:* " . $this->donation->donation_date->translatedFormat('d F Y H:i') . " WIB\n" .
            "• *Program:* Donasi " . ($this->donation->donationType->name ?? '-') . "\n" .
            "• *Nominal:* Rp" . number_format($this->donation->amount, 0, ',', '.') . "\n" .
            "• *Metode:* " . $this->donation->payment_method . "\n" .
            "• *Status:* " . $this->donation->status . "\n\n" .
            "Semoga mendapat balasan berlipat ganda dan berkah bagi kita semua. Amin.\n\n" .
            "Hubungi kami untuk informasi lebih lanjut.";

        return "https://api.whatsapp.com/send?phone=" . $phone . "&text=" . urlencode($message);
    }

    public function render()
    {
        return view('livewire.donation.donation-detail')
            ->layout('layouts.app', ['header' => 'Detail Transaksi Donasi #' . $this->donation->transaction_number]);
    }
}
