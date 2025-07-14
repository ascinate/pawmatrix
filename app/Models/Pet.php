<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'species',
        'breed',
        'gender',
        'birthdate',
        'weight_kg',
        'microchip_number',
        'vaccination_status',
        'allergies',
        'notes',
        'image',
        'created_at',
        'updated_at'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

        protected $casts = [
        'birthdate' => 'datetime',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function treatmentBoard()
    {
        return $this->hasOne(TreatmentBoard::class);
    }
}