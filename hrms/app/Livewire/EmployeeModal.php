<?php

namespace App\Livewire;
use Livewire\Livewire;
use Livewire\Component;
use App\Models\Employee;
class EmployeeModal extends Component
{
    
    public $employee;
    public $first_name, $last_name, $middle_name, $suffix, $gender, $birthdate;
    public $email, $phone_number, $address, $marital_status, $emergency_contact_number, $role;
      // Work Info
      public $department, $position, $work_status, $hire_date;
    
      // Bank Info
      public $bank_name, $account_number, $account_type;
      
      // Identification Info
      public $sss_number, $pag_ibig_number, $philhealth_number, $tin_number;

      public $loan_type, $loan_amount, $monthly_amortization;


      protected $listeners = ['refreshEmployee' => 'refreshEmployees'];

    public function refreshEmployees($employeeId)
    {
        $this->resetForm();

        $this->employee = Employee::find($employeeId);
        if ($this->employee) {
            $this->mount($this->employee);
        }
    }

    public function resetForm()
{
    $this->reset([
        'employee',
        'first_name',
        'last_name',
        'middle_name',
        'suffix',
        'gender',
        'birthdate',
        'email',
        'phone_number',
        'address',
        'marital_status',
        'emergency_contact_number',
        'role',
        'department',
        'position',
        'work_status',
        'hire_date',
        'bank_name',
        'account_number',
        'account_type',
        'sss_number',
        'pag_ibig_number',
        'philhealth_number',
        'tin_number',
        'loan_type',
        'loan_amount',
        'monthly_amortization',
    ]);
}



    public function mount($employee)
    {
        $this->employee = $employee;

            $this->first_name = $employee->first_name;
            $this->last_name = $employee->last_name;
            $this->middle_name = $employee->middle_name;
            $this->suffix = $employee->suffix;
            $this->gender = $employee->gender;
            $this->birthdate = $employee->birthdate;
            $this->email = $employee->email;
            $this->phone_number = $employee->phone_number;
            $this->address = $employee->address;
            $this->marital_status = $employee->marital_status;
            $this->emergency_contact_number = $employee->emergency_contact_number;
            $this->role = $employee->role;

            if ($employee->workInfo) {
            $this->department = $employee->workInfo->department;
            $this->position = $employee->workInfo->position;
            $this->work_status = $employee->workInfo->work_status;
            $this->hire_date = $employee->workInfo->hire_date;
        }

        // Bank Info
        if ($employee->bankInfo) {
            $this->bank_name = $employee->bankInfo->bank_name;
            $this->account_number = $employee->bankInfo->account_number;
            $this->account_type = $employee->bankInfo->account_type;
        }

        // Identification Info
        if ($employee->identificationInfo) {
            $this->sss_number = $employee->identificationInfo->sss_number;
            $this->pag_ibig_number = $employee->identificationInfo->pag_ibig_number;
            $this->philhealth_number = $employee->identificationInfo->philhealth_number;
            $this->tin_number = $employee->identificationInfo->tin_number;
        }

        // Loan Info
        if ($employee->loanInfo) {
            // For simplicity, assuming the employee has only one loan info for now.
            // You can modify this based on your specific needs.
            $loan = $employee->loanInfo->first();  // Assuming the employee has a single loan entry
            if ($loan) {
                $this->loan_type = $loan->loan_type;
                $this->loan_amount = $loan->loan_amount;
                $this->monthly_amortization = $loan->monthly_amortization;
            }
        }
    }


    public function save()
    {
        // Update the Employee
        $this->employee->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'suffix' => $this->suffix,
            'gender' => $this->gender,
            'birthdate' => $this->birthdate,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'marital_status' => $this->marital_status,
            'emergency_contact_number' => $this->emergency_contact_number,
            'role' => $this->role,
        ]);

        // Update Work Info if available
        if ($this->employee->workInfo) {
            $this->employee->workInfo->update([
                'department' => $this->department,
                'position' => $this->position,
                'work_status' => $this->work_status,
                'hire_date' => $this->hire_date,
            ]);
        } else {
            // Create new Work Info if none exists
            $this->employee->workInfo()->create([
                'department' => $this->department,
                'position' => $this->position,
                'work_status' => $this->work_status,
                'hire_date' => $this->hire_date,
            ]);
        }

        // Update Bank Info if available
        if ($this->employee->bankInfo) {
            $this->employee->bankInfo->update([
                'bank_name' => $this->bank_name,
                'account_number' => $this->account_number,
                'account_type' => $this->account_type,
            ]);
        } 

        $this->dispatch('employeeUpdated', $this->employee->id);
        $this->resetForm();
        $this->dispatch('close-modal');
        
        session()->flash('message', 'Employee information updated successfully!');

    }


    public function render()
    {
        return view('livewire.employee-modal');
    }
}
