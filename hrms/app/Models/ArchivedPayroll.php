<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArchivedPayroll extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'pay_period_start',
        'pay_period_end',
        'salary',
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
        return $this->belongsTo(Employee::class)->withTrashed(); // Include soft-deleted employees
    }

    public function getDeductionsBreakdownAttribute()
    {
        $deductionSettings = \App\Models\PayrollDeductionSetting::first();

        $sss = $this->gross_pay * ($deductionSettings->sss_rate ?? 0.045);
        $philhealth = $this->gross_pay * ($deductionSettings->philhealth_rate ?? 0.03);
        $pagibig = $deductionSettings->pagibig_fixed ?? 100;
        $withholding_tax = $this->gross_pay * ($deductionSettings->withholding_tax_rate ?? 0.1);

        return [
            'sss' => $sss,
            'philhealth' => $philhealth,
            'pagibig' => $pagibig,
            'withholding_tax' => $withholding_tax,
        ];
    }
}
