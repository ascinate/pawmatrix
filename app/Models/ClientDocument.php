<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientDocument extends Model
{
        public $timestamps = false;
    protected $fillable = [
        'client_id',
        'document_type',
        'file_path',
        'uploaded_at'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
//     The ClientDocument model stores documents uploaded by a client, like ID proofs or forms. It:

// Belongs to a specific client (client_id).

// Stores the type of document, its file path, and upload date.
}

