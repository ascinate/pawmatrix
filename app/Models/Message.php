<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'sender_type',
        'message',
    ];

    /**
     * Get the sender (user or client) of the message.
     */
    public function sender()
    {
        if ($this->sender_type === 'user') {
            return $this->belongsTo(User::class, 'user_id');
        } elseif ($this->sender_type === 'client') {
            return $this->belongsTo(Client::class, 'client_id');
        }

        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function messages()
{
    return $this->hasMany(Message::class);
}

}
