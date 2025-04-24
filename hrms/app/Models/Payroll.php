<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
class Payroll extends Model
{
    /** @use HasFactory<\Database\Factories\PayrollFactory> */
    use HasFactory;
    use SoftDeletes;
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


    public function recalculateDeductions()
    {
        $deductionSettings = PayrollDeductionSetting::first();
        $basic_salary = $this->employee->workInfo->salary ?? 0;
        $allowance = $this->allowance ?? 0;
        $overtime = $this->overtime_pay ?? 0;
        $gross = $basic_salary + $allowance + $overtime;

        $sss = $basic_salary * ($deductionSettings->sss_rate ?? 0.045);
        $philhealth = $basic_salary * ($deductionSettings->philhealth_rate ?? 0.03);
        $pagibig = $basic_salary * ($deductionSettings->pagibig_rate ?? 0.01);
        $withholding_tax = $basic_salary * ($deductionSettings->withholding_tax_rate ?? 0.1);
        $deductions = $sss + $philhealth + $pagibig + $withholding_tax;

        $net = $gross - ($deductions + $this->additional_deductions);

        $this->gross_pay = $gross;
        $this->deductions = $deductions;
        $this->net_pay = $net;
      

        $this->save();
    }


    public function employee()
    {
    return $this->belongsTo(Employee::class);
    }
}
