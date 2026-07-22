<?php

namespace App\Models;

use Juniyasyos\IamClient\Models\UnitKerja;

class WorkUnit extends UnitKerja
{
    protected $table = 'work_units';

    protected $appends = ['work_unit'];

    public function getWorkUnitAttribute()
    {
        return $this->unit_name;
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}