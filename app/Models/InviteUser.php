<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
use OwenIt\Auditing\Contracts\Auditable;


class InviteUser extends Model implements Auditable
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
        'email',
        'token',
        'expires_at',
        "organization_id",
        "invitedTo",
        "invitedBy"
    ];

    public function invitedBy()
    {
        return $this->belongsTo(User::class, "invitedBy");
    }

    public function invitedTo()
    {
        return $this->belongsTo(User::class, "invitedTo");
    }
}
