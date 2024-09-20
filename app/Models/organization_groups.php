<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class organization_groups extends Model
{
    use HasFactory;

    protected $fillable = [
        "group_name",
        "organization_id",
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function users()
    {
        return $this->hasMany(organization_user::class);
    }
}
