<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentReminder extends Model
{
    protected $fillable = [
        'appointment_id',
        'method',
        'sent_at'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);// Appoinmentremainder belongs to a sing
    }
}