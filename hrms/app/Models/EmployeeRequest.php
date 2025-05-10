<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'request_type',
        'reason',
        'leave_reason',
        'start_time',
        'end_time',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function overtimeLog() {
        return $this->hasOne(OvertimeLog::class, 'request_id');
    }
}
