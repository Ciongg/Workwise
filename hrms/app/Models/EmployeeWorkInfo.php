<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeWorkInfo extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeWorkInfoFactory> */
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'department',
        'position',
        'work_status',
        'hire_date',
      
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


  

}
