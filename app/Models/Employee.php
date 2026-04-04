<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'full_name',
        'nip',
        'employee_type_id',
        'work_unit_id',
        'email',
        'phone',
        'signature_path',
        'is_active'
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class);
    }
    public function workUnit()
    {
        return $this->belongsTo(WorkUnit::class);
    }
}