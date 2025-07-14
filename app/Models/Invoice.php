<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'client_id',
        'appointment_id',
        'invoice_date',
        'total',
        'tax',
        'discount',
        'status',
        'created_at'
    ];

    // Add date casting
    protected $casts = [
        'invoice_date' => 'datetime',
        'created_at' => 'datetime'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}