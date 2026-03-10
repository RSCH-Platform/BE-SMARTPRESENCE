<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeType extends Model
{
    protected $fillable = ['employee_type'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}