<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
class OrganizationGroup extends Model
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
        'name',
    ];
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function messages()
    {
        return $this->hasMany(OrganizationGroupMessage::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'organization_group_user');
    }
}
