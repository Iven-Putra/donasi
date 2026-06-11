<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'donation_date',
        'donor_id',
        'donation_type_id',
        'amount',
        'payment_method',
        'notes',
        'user_id',
        'status',
    ];

    protected $casts = [
        'donation_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($donation) {
            if (empty($donation->transaction_number)) {
                $dateObj = $donation->donation_date ? \Carbon\Carbon::parse($donation->donation_date) : now();
                $dateStr = $dateObj->format('Ymd');
                $prefix = 'TRX-' . $dateStr . '-';

                // Find the latest transaction number for today to increment safely
                $latest = static::where('transaction_number', 'like', $prefix . '%')
                    ->orderBy('transaction_number', 'desc')
                    ->first();

                if ($latest) {
                    $parts = explode('-', $latest->transaction_number);
                    $lastSeq = (int) end($parts);
                    $nextSeq = $lastSeq + 1;
                } else {
                    $nextSeq = 1;
                }

                $donation->transaction_number = $prefix . str_pad($nextSeq, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Get the donor of this donation.
     */
    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    /**
     * Get the donation type.
     */
    public function donationType()
    {
        return $this->belongsTo(DonationType::class, 'donation_type_id');
    }

    /**
     * Get the user (operator/admin) who input this donation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
