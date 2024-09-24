<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
class Organization extends Model
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

        "name",
        "created_by",
        "description",
        "group_id",
        "user_id",
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'organizations');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, "created_by");
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }


        'name',
        'description',
        "created_by"
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'organization_user');
    }

    public function groups()
    {
        return $this->hasMany(OrganizationGroup::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, "created_by");
    }

}
