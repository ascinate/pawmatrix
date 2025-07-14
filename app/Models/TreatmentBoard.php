<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentBoard extends Model
{
    protected $table = 'treatment_board';
    protected $fillable = [
        'pet_id',
        'status',
        'updated_by',
        'updated_at'
    ];

    protected $casts = [
    'updated_at' => 'datetime',
];
    public $timestamps = false;

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}