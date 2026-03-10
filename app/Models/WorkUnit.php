<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkUnit extends Model
{
    protected $fillable = ['work_unit'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}