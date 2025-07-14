<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action_type',
        'description',
        'related_entity',
        'related_id',
        'timestamp'
    ];
     protected $table = 'activity_log';
     public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}