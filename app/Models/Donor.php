<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_code',
        'donor_type',
        'name',
        'phone',
        'email',
        'address',
        'city',
        'province',
        'join_date',
        'is_active',
    ];

    protected $casts = [
        'join_date' => 'date',
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($donor) {
            if (empty($donor->donor_code)) {
                // Generate a code based on the next ID
                // We use MAX(id) + 1 to avoid race conditions or duplicate code.
                $latestId = static::max('id') ?? 0;
                $nextId = $latestId + 1;
                $donor->donor_code = 'DNR-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Get donations made by this donor.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
