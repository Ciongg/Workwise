<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivedPayroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'pay_period_start',
        'pay_period_end',
        'allowance',
        'overtime_pay',
        'gross_pay',
        'deductions',
        'additional_deductions',
        'net_pay',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
