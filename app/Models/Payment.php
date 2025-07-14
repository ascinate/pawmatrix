<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
     public $timestamps = false;
    protected $fillable = [
        'invoice_id',
        'method',
        'amount',
        'paid_at',
        'receipt_path'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}