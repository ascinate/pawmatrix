<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // new foreign key column
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'vet_id');
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'vet_id');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function soapTemplates()
    {
        return $this->hasMany(SoapTemplate::class, 'created_by');
    }

    public function treatmentBoardUpdates()
    {
        return $this->hasMany(TreatmentBoard::class, 'updated_by');
    }
}
