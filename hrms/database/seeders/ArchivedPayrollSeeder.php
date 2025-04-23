<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ArchivedPayroll;
use App\Models\Employee;

class ArchivedPayrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            // February payroll
            ArchivedPayroll::create([
                'employee_id' => $employee->id,
                'pay_period_start' => '2025-02-01',
                'pay_period_end' => '2025-02-28',
                'salary' => $employee->workInfo->salary,
                'allowance' => 1000,
                'overtime_pay' => rand(0, 300),
                'gross_pay' => $employee->workInfo->salary + 1000 + rand(0, 300),
                'deductions' => $this->calculateDeductions($employee->workInfo->salary),
                'additional_deductions' => rand(0, 300),
                'net_pay' => $this->calculateNetPay($employee->workInfo->salary, 1000, rand(0, 300), rand(0, 300)),
                'status' => 'paid',
            ]);

            // March payroll
            ArchivedPayroll::create([
                'employee_id' => $employee->id,
                'pay_period_start' => '2025-03-01',
                'pay_period_end' => '2025-03-31',
                'salary' => $employee->workInfo->salary,
                'allowance' => 1000,
                'overtime_pay' => rand(0, 300),
                'gross_pay' => $employee->workInfo->salary + 1000 + rand(0, 300),
                'deductions' => $this->calculateDeductions($employee->workInfo->salary),
                'additional_deductions' => rand(0, 300),
                'net_pay' => $this->calculateNetPay($employee->workInfo->salary, 1000, rand(0, 300), rand(0, 300)),
                'status' => 'paid',
            ]);
        }
    }

    private function calculateDeductions($salary)
    {
        $sss = $salary * 0.045; // 4.5%
        $philhealth = $salary * 0.03; // 3%
        $pagibig = 100; // Fixed amount
        $withholding_tax = $salary * 0.1; // 10%

        return $sss + $philhealth + $pagibig + $withholding_tax;
    }

    private function calculateNetPay($salary, $allowance, $overtime, $additionalDeductions)
    {
        $gross = $salary + $allowance + $overtime;
        $deductions = $this->calculateDeductions($salary);

        return $gross - ($deductions + $additionalDeductions);
    }
}
