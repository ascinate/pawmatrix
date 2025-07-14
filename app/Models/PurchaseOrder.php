<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    public $timestamps = false; // Add this line
    
    protected $fillable = [
        'supplier_id',
        'order_date',
        'expected_delivery',
        'status',
        'notes'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}