<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'branding_json',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'branding_json' => 'array'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
//     The Clinic model represents a veterinary clinic. It:

// Stores clinic details like name, contact info, and branding settings (in JSON format).

// Has many appointments linked to it.

// Automatically casts branding_json to an array for easy access in PHP
}