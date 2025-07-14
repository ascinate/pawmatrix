<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
  protected $fillable = [
    'appointment_id',  // <-- ADD THIS
    'pet_id',
    'visit_date',
    'vet_id',
    'subjective',
    'objective',
    'assessment',
    'plan',
    'custom_fields',
    'created_at',
    'updated_at'
];
    

   protected $casts = [
    'visit_date' => 'datetime',
    'custom_fields' => 'array'
];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function vet()
    {
        return $this->belongsTo(User::class, 'vet_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'record_id');
    }
    public function appointment()
    {
    return $this->belongsTo(Appointment::class);
    }
}