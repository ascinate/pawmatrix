<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SoapTemplate extends Model
{
    use HasFactory;

    protected $table = 'soap_templates';

    // Primary key
    protected $primaryKey = 'id';

    // Timestamps (manually handled since created_at exists but not updated_at)
    // public $timestamps = false;
        public const UPDATED_AT = null; // <-- This tells Laravel not to expect an 'updated_at' column

    public $timestamps = true; 

    // Mass assignable fields
    protected $fillable = [
        'name',
        'category',       // enum: general, surgery, dental, vaccination
        'subjective',
        'objective',
        'assessment',
        'plan',
        'created_by',     // user_id or vet_id
        'created_at',
    ];

    // Optional: Casts
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Relationship: the vet/user who created the template
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
