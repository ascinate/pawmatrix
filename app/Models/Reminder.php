<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'priority',
        'due_date',
        'status',
        'related_type',
        'related_id'
    ];

    protected $casts = [
        'due_date' => 'date'
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}