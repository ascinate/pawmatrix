<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{

       public $timestamps = false;
    protected $fillable = [
        'invoice_id',
        'product_id',
        'description',
        'quantity',
        'unit_price'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}