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
      public $work_start_time, $work_end_time, $break_start_time, $break_end_time;
    
      // Bank Info
      public $bank_name, $account_number, $account_type;
      
      // Identification Info
      public $sss_number, $pag_ibig_number, $philhealth_number, $tin_number;








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
            $this->work_start_time = $employee->workInfo->work_start_time ?? '08:00:00';
            $this->work_end_time = $employee->workInfo->work_end_time ?? '17:00:00';
            $this->break_start_time = $employee->workInfo->break_start_time ?? '12:00:00';
            $this->break_end_time = $employee->workInfo->break_end_time ?? '13:00:00';
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

 
    }


    public function save()
    {
        $this->validate([
            'work_start_time' => 'required|date_format:H:i',
            'work_end_time' => 'required|date_format:H:i|after:work_start_time',
            'break_start_time' => 'nullable|date_format:H:i',
            'break_end_time' => 'nullable|date_format:H:i|after:break_start_time',
        ]);

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
                'work_start_time' => $this->work_start_time,
                'work_end_time' => $this->work_end_time,
                'break_start_time' => $this->break_start_time,
                'break_end_time' => $this->break_end_time,
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

        $this->dispatch('employeeUpdated', employeeId: $this->employee->id);
        $this->dispatch('close-modal');
        
        session()->flash('message', 'Employee information updated successfully!');
        session()->flash('message', 'Work schedule updated successfully!');

    }


    public function render()
    {
        return view('livewire.employee-modal');
    }
}
