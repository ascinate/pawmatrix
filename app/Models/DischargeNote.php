<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DischargeNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'note',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
