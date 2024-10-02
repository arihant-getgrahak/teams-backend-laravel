<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
use OwenIt\Auditing\Contracts\Auditable;

class OrganizationGroupMedia extends Model implements Auditable
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
        'organization_group_id',
        'organization_id',
        'senders_id',
        
    ];

    public function organizationGroup()
    {
        return $this->belongsTo(OrganizationGroup::class, 'organization_group_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function senders()
    {
        return $this->belongsTo(User::class, 'senders_id');
    }
}
