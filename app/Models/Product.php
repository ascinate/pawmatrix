<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  
    protected $fillable = [
    'name',
    'category',
    'authorized_vet',
    'dosage_form',
    'quantity_in_stock',
    'refills',
    'valid_until',
    'use_by_date',
    'instructions',
];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function appointment()
{
    return $this->belongsTo(Appointment::class);
}
}