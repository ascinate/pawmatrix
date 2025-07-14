<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
        public $timestamps = false;
    protected $fillable = [
        'record_id',
        'file_path',
        'file_type',
        'uploaded_at'
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class, 'record_id');
    }
}