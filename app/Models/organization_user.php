<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class organization_user extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'group_id',
    ];
    public function group()
    {
        return $this->belongsTo(organization_groups::class);
    }
}
