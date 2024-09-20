<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
class OrganizationGroupMessage extends Model
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
        'message',
        'user_id',
    ];

    public function group()
    {
        return $this->belongsTo(OrganizationGroup::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
