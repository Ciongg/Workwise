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
        'salary',
        'work_status',
        'hire_date',
        'work_start_time',
        'work_end_time',
        'break_start_time',
        'break_end_time',
      
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


  

}
