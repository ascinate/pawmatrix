<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Appointment extends Model
{
     use HasFactory;
    protected $fillable = [
        'pet_id', // foreign key
        'client_id', // foreign key
        'vet_id', // foreign key
        'clinic_id', // foreign key
        'appointment_datetime',
        'duration_minutes',
        'status',
        'notes',
        'room',        // new ENUM/text field
        'reason',      // new ENUM/text field
        'created_at',
        'updated_at',
        // 'is_recurring',
        // 'recurrence_pattern',
        // 'recurrence_interval',
        // 'recurrence_end_date',
        // 'parent_appointment_id',
        // 'recurrence_weekdays'
    ];

    protected $casts = [
        'appointment_datetime' => 'datetime',
        // 'recurrence_end_date' => 'date',
        // 'is_recurring' => 'boolean',
        // 'recurrence_weekdays' => 'array',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function vet()
    {
        return $this->belongsTo(User::class, 'vet_id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function reminders()
    {
        return $this->hasMany(AppointmentReminder::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function childAppointments()
    {
        return $this->hasMany(Appointment::class, 'parent_appointment_id');
    }

    public function parentAppointment()
    {
        return $this->belongsTo(Appointment::class, 'parent_appointment_id');
    }

    public function dischargeNote()
{
    return $this->hasOne(DischargeNote::class, 'appointment_id');
}

public function medications()
{
    return $this->hasMany(Product::class, 'appointment_id')
        ->where('category', 'medication');
}
public function medicalRecord()
{
    return $this->hasOne(MedicalRecord::class, 'appointment_id');
}
}