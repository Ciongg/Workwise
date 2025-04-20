<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\EmployeeWorkInfo;
use App\Models\EmployeeBankInfo;
use App\Services\PayrollService;
use App\Models\EmployeeIdentificationInfo;
use Illuminate\Support\Facades\Hash;

class EmployeeCreate extends Component
{
    public $first_name, $last_name, $middle_name, $suffix, $gender, $birthdate,
           $email, $phone_number, $marital_status, $address, $emergency_contact_number, $password, $role;

    public $work_status, $hire_date;

    public $bank_name, $account_number, $account_type;

    public $sss_number, $pag_ibig_number, $philhealth_number, $tin_number;

    public $work_start_time = '08:00:00';
    public $work_end_time = '17:00:00';
    public $break_start_time = '12:00:00';
    public $break_end_time = '13:00:00';

    public $departments = [
        'Engineering', 'Operations', 'Logistics', 'Procurement', 'Finance', 'HR', 'Sales/Marketing', 'Executive'
    ];
    
    public $positionsData = [
        ['Engineering', 'Electrical Engineer', 25000, 40000],
        ['Engineering', 'Project Engineer', 30000, 45000],
        ['Engineering', 'Technician', 15000, 25000],
        ['Engineering', 'Electrician', 14000, 22000],
        ['Operations', 'Project Manager', 35000, 50000],
        ['Operations', 'Site Supervisor', 28000, 40000],
        ['Operations', 'Foreman', 22000, 32000],
        ['Logistics', 'Driver', 14000, 20000],
        ['Logistics', 'Warehouse Staff', 13000, 18000],
        ['Logistics', 'Delivery Assistant', 12000, 16000],
        ['Procurement', 'Procurement Officer', 27000, 37000],
        ['Procurement', 'Inventory Clerk', 18000, 24000],
        ['Procurement', 'Supply Chain Assistant', 20000, 30000],
        ['Finance', 'Accountant', 30000, 45000],
        ['Finance', 'Bookkeeper', 20000, 30000],
        ['HR', 'HR Officer', 25000, 35000],
        ['HR', 'Admin Assistant', 18000, 25000],
        ['Sales/Marketing', 'Sales Engineer', 28000, 42000],
        ['Sales/Marketing', 'Marketing Officer', 26000, 38000],
        ['Sales/Marketing', 'Business Development', 30000, 45000],
        ['Executive', 'General Manager', 60000, 90000],
        ['Executive', 'Operations Manager', 50000, 80000],
    ];
    
    
    public $department;
    public $position;
    public $positions = [];
    public $min_salary;
    public $max_salary;
    public $salary;


    public function updatedPosition($value)
    {
        $selected = collect($this->positionsData)
            ->first(fn($item) => $item[0] === $this->department && $item[1] === $value);
    
        if ($selected) {
            $this->min_salary = $selected[2];
            $this->max_salary = $selected[3];
        } else {
            $this->min_salary = null;
            $this->max_salary = null;
        }
    }
    
    //watch department
    public function updatedDepartment($value)
    {
       

        $this->positions = collect($this->positionsData)
            ->filter(fn($item) => $item[0] === $value)
            ->pluck(1)
            ->values()
            ->toArray();
    
        $this->position = null;
    }

    public function submit()
    {
        $this->validate([
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|min:6',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string',
            'suffix' => 'nullable|string',
            'gender' => 'required|in:male,female',
            'birthdate' => 'required|date',
            'phone_number' => 'required|digits:11',
            'emergency_contact_number' => 'required|digits:11',
            'marital_status' => 'required',
            'address' => 'required',
            'role' => 'required|in:employee,hr,manager',
        
            // work info
            'department' => 'required',
            'position' => 'required',
            'salary' => 'required|numeric|min:' . $this->min_salary . '|max:' . $this->max_salary,
            'work_status' => 'required',
            'hire_date' => 'required|date',
            'work_start_time' => 'required|date_format:H:i',
            'work_end_time' => 'required|date_format:H:i|after:work_start_time',
            'break_start_time' => 'nullable|date_format:H:i',
            'break_end_time' => 'nullable|date_format:H:i|after:break_start_time',
        
            // bank info
            'bank_name' => 'required',
            'account_number' => 'required|digits_between:10,12|unique:employee_bank_infos,account_number',  // unique validation for account_number
            'account_type' => 'required|in:savings,checking',
        
            // ids
            'sss_number' => 'required|unique:employee_identification_infos,sss_number',  // unique validation for sss_number
            'pag_ibig_number' => 'required|unique:employee_identification_infos,pag_ibig_number',  // unique validation for pag_ibig_number
            'philhealth_number' => 'required|unique:employee_identification_infos,philhealth_number',  // unique validation for philhealth_number
            'tin_number' => 'required|unique:employee_identification_infos,tin_number',  // unique validation for tin_number
        
        ]);
        

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
            'salary' => $this->salary,
            'work_status' => $this->work_status,
            'hire_date' => $this->hire_date,
            'work_start_time' => $this->work_start_time,
            'work_end_time' => $this->work_end_time,
            'break_start_time' => $this->break_start_time,
            'break_end_time' => $this->break_end_time,
        ]);

        $employee->bankInfo()->create([
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'account_type' => $this->account_type,
        ]);


        $employee->identificationInfo()->create([
            'sss_number' => $this->sss_number,
            'pag_ibig_number' => $this->pag_ibig_number,
            'philhealth_number' => $this->philhealth_number,
            'tin_number' => $this->tin_number,
        ]);

        PayrollService::generatePayrollForEmployee($employee);

        session()->flash('success', 'Employee created successfully.');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.employee-create');
    }
}
