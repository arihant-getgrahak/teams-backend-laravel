<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
class group extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        "isUpdate",
        "isDelete",
        "deletedAt",
        "type",
    ];

    public static function boot() {
        parent::boot();
    
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
    protected $keyType = 'string';
    public $incrementing = false;

    public function sender()
    {
        return $this->belongsTo(User::class, "sender_id");
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, "receiver_id");
    }
}

