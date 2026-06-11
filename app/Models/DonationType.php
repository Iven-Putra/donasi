<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'flyer',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($type) {
            if (empty($type->code)) {
                $latestId = static::max('id') ?? 0;
                $nextId = $latestId + 1;
                $type->code = 'JNS-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Get donations under this type.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
