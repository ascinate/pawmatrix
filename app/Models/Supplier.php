<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'contact_info'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}