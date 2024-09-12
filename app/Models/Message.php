<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
    ];

    public function sender_id()
    {
        return $this->belongsTo(User::class);
    }
    public function receiver_id()
    {
        return $this->belongsTo(User::class);
    }
}
