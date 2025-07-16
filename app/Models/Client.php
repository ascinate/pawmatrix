<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'dateofbirth',
        'address',
        'city',
        'state',
        'zipcode',
        'gender',
        'notes',
        'preferred_contact_method',
        'created_at',
        'updated_at'
    ];

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function documents()
    {
        return $this->hasMany(ClientDocument::class);
    }

    public function messages()
    {
    return $this->hasMany(Message::class);
    }

}
