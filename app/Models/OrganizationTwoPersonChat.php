<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
class OrganizationTwoPersonChat extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'organization_id',
        'sender_id',
        'receiver_id',
        'message',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
