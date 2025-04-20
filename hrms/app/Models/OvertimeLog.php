<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeLog extends Model
{
    protected $fillable = [
        'employee_id',
        'request_id',
        'ot_time_in',
        'ot_time_out',
        'total_hours',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function request()
    {
        return $this->belongsTo(EmployeeRequest::class, 'request_id');
    }
}
