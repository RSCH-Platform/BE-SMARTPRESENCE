<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingRoom extends Model
{
    protected $fillable = [
        'name','location','capacity','is_active'
    ];

    public function meetings()
    {
        return $this->hasMany(Meeting::class,'room_id');
    }
}