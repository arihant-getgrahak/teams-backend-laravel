<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
use OwenIt\Auditing\Contracts\Auditable;

class GroupMedia extends Model implements Auditable
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

    protected $ketType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'filename',
        'file_path',
        'group_id',
        "sender_id"
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, "sender_id");
    }
}
