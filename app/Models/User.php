<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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