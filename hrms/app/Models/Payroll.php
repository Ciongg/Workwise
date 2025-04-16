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

    // app/Models/Payroll.php

    public function recalculateDeductions()
    {
        $deductionSettings = PayrollDeductionSetting::first();
        $basic = $this->basic_salary;
        $allowance = $this->allowance ?? 0;
        $overtime = $this->overtime_pay ?? 0;
        $gross = $basic + $allowance + $overtime;

        $sss = $basic * ($deductionSettings->sss_rate ?? 0.045);
        $philhealth = $basic * ($deductionSettings->philhealth_rate ?? 0.03);
        $pagibig = $deductionSettings->pagibig_fixed ?? 100;
        $withholding_tax = $basic * ($deductionSettings->withholding_tax_rate ?? 0.1);
        $deductions = $sss + $philhealth + $pagibig + $withholding_tax;

        $net = $gross - $deductions;

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
