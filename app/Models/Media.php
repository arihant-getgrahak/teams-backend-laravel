<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
use OwenIt\Auditing\Contracts\Auditable;


class Media extends Model implements Auditable
{
    use HasFactory;

    use \OwenIt\Auditing\Auditable;

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
        'filename',
        'file_path',
        'receiver_id',
    ];

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
