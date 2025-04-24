<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'time_in',
        'time_out',
        'total_hours',
        'status', // <-- add this
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function overtimeLogs()
    {
        return $this->hasMany(OvertimeLog::class);
    }
}
