<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Meeting extends Model
{
    use HasFactory;
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
            $model->created_by = auth()->user()->id;
        });
    }
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'group_id',
        'scheduled_at',
        'title',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
