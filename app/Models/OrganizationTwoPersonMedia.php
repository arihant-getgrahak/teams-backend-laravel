<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
use OwenIt\Auditing\Contracts\Auditable;

class OrganizationTwoPersonMedia extends Model implements Auditable
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
        'sender_id',
        'receiver_id',
        'organization_id',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, "sender_id");
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, "receiver_id");
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, "organization_id");
    }
}
