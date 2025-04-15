<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\EmployeeWorkInfo;
use App\Models\EmployeeBankInfo;
use App\Models\EmployeeLoanInfo;
use App\Models\EmployeeIdentificationInfo;
use Illuminate\Support\Facades\Hash;

class EmployeeCreate extends Component
{
    public $first_name, $last_name, $middle_name, $suffix, $gender, $birthdate,
           $email, $phone_number, $marital_status, $address, $emergency_contact_number, $password, $role;

    public $department, $position, $work_status, $hire_date;

    public $bank_name, $account_number, $account_type;

    public $loan_type, $loan_amount, $monthly_amortization;

    public $sss_number, $pag_ibig_number, $philhealth_number, $tin_number;

    public function submit()
    {
        $employee = Employee::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'suffix' => $this->suffix,
            'gender' => $this->gender,
            'birthdate' => $this->birthdate,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'marital_status' => $this->marital_status,
            'address' => $this->address,
            'emergency_contact_number' => $this->emergency_contact_number,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        $employee->workInfo()->create([
            'department' => $this->department,
            'position' => $this->position,
            'work_status' => $this->work_status,
            'hire_date' => $this->hire_date,
        ]);

        $employee->bankInfo()->create([
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'account_type' => $this->account_type,
        ]);

        $employee->loanInfo()->create([
            'loan_type' => $this->loan_type,
            'loan_amount' => $this->loan_amount,
            'monthly_amortization' => $this->monthly_amortization,
        ]);

        $employee->identificationInfo()->create([
            'sss_number' => $this->sss_number,
            'pag_ibig_number' => $this->pag_ibig_number,
            'philhealth_number' => $this->philhealth_number,
            'tin_number' => $this->tin_number,
        ]);

        session()->flash('success', 'Employee created successfully.');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.employee-create');
    }
}
