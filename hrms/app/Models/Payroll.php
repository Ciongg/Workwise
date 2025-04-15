<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    /** @use HasFactory<\Database\Factories\PayrollFactory> */
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'pay_period_start',
        'pay_period_end',
        'basic_salary',
        'allowance',
        'overtime_pay',
        'gross_pay',
        'deductions',
        'net_pay',
        'status',
    ];

    public function employee()
    {
    return $this->belongsTo(Employee::class);
    }
}
