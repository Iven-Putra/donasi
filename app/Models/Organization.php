<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'address',
        'city',
        'province',
        'postal_code',
        'phone',
        'email',
        'website',
        'chairman_name',
        'treasurer_name',
        'tax_number',
    ];
}
