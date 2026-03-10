<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'username','email','password','role_id','is_active'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function meetingsCreated()
    {
        return $this->hasMany(Meeting::class,'created_by');
    }
}