<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        "creator_id",
        "scheduled",
        "created_by",
    ];

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
    protected $keyType = 'string';
    public $incrementing = false;

    public function creator()
    {
        return $this->belongsTo(User::class, "creator_id");
    }
}
