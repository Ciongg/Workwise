<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;

class EmployeeModal extends Component
{
    public $employee;
    public $first_name, $last_name, $middle_name, $suffix, $gender, $birthdate;
    public $email, $phone_number, $address, $marital_status, $emergency_contact_number, $role;

    // Work Info
    public $department, $position, $salary, $work_status, $hire_date;
    public $work_start_time, $work_end_time, $break_start_time, $break_end_time;

    // Bank Info
    public $bank_name, $account_number, $account_type;

    // Identification Info
    public $sss_number, $pag_ibig_number, $philhealth_number, $tin_number;

    // Departments and Positions
    public $departments = [
        'Engineering', 'Operations', 'Logistics', 'Procurement',
        'Finance', 'HR', 'Sales/Marketing', 'Executive'
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

    public $positions = [];
    public $min_salary, $max_salary;

    public function mount($employee)
    {
        $this->employee = $employee;

        $this->first_name = $employee->first_name;
        $this->last_name = $employee->last_name;
        $this->middle_name = $employee->middle_name;
        $this->suffix = $employee->suffix;
        $this->gender = $employee->gender; // Ensure gender is set here
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
            $this->salary = $employee->workInfo->salary;
            $this->work_status = $employee->workInfo->work_status;
            $this->hire_date = $employee->workInfo->hire_date;
            $this->work_start_time = $employee->workInfo->work_start_time ?? '08:00';
            $this->work_end_time = $employee->workInfo->work_end_time ?? '17:00';
            $this->break_start_time = $employee->workInfo->break_start_time ?? '12:00';
            $this->break_end_time = $employee->workInfo->break_end_time ?? '13:00';
        }

        if ($employee->bankInfo) {
            $this->bank_name = $employee->bankInfo->bank_name;
            $this->account_number = $employee->bankInfo->account_number;
            $this->account_type = $employee->bankInfo->account_type;
        }

        if ($employee->identificationInfo) {
            $this->sss_number = $employee->identificationInfo->sss_number;
            $this->pag_ibig_number = $employee->identificationInfo->pag_ibig_number;
            $this->philhealth_number = $employee->identificationInfo->philhealth_number;
            $this->tin_number = $employee->identificationInfo->tin_number;
        }

        $this->positions = collect($this->positionsData)
            ->where(0, $this->department)
            ->pluck(1)
            ->values()
            ->toArray();

        $selectedPosition = collect($this->positionsData)
            ->first(fn($item) => $item[0] === $this->department && $item[1] === $this->position);

        if ($selectedPosition) {
            $this->min_salary = $selectedPosition[2];
            $this->max_salary = $selectedPosition[3];
        }
    }

    public function updatedDepartment($value)
    {
        $this->positions = collect($this->positionsData)
            ->where(0, $value)
            ->pluck(1)
            ->values()
            ->toArray();

        $this->position = null; // Reset position when department changes
        $this->salary = null;   // Reset salary when department changes
        $this->min_salary = null;
        $this->max_salary = null;
    }

    public function updatedPosition($value)
    {
        $selected = collect($this->positionsData)
            ->first(fn($item) => $item[0] === $this->department && $item[1] === $value);

        if ($selected) {
            $this->min_salary = $selected[2];
            $this->max_salary = $selected[3];
            $this->salary = $selected[2]; // Set salary to the minimum salary for the position
        } else {
            $this->min_salary = $this->max_salary = $this->salary = null;
        }
    }

    public function save()
    {
        // Validate the input fields
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'gender' => 'required|in:male,female',
            'birthdate' => 'required|date',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:11',
            'address' => 'required|string|max:255',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'emergency_contact_number' => 'required|string|max:11',
            'role' => 'required|in:employee,hr',
            'department' => 'required|string',
            'position' => 'required|string',
            'salary' => 'required|numeric|min:' . $this->min_salary . '|max:' . $this->max_salary,
            'work_status' => 'required|in:full_time,part_time,contract',
            'hire_date' => 'required|date',
            'work_start_time' => 'required|date_format:H:i',
            'work_end_time' => 'required|date_format:H:i|after:work_start_time',
            'break_start_time' => 'nullable|date_format:H:i',
            'break_end_time' => 'nullable|date_format:H:i|after:break_start_time',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:13',
            'account_type' => 'nullable|in:checking,savings',
            'sss_number' => 'nullable|string|max:12',
            'pag_ibig_number' => 'nullable|string|max:14',
            'philhealth_number' => 'nullable|string|max:13',
            'tin_number' => 'nullable|string|max:15',
        ]);

        // Update the employee's personal information
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

        // Update the employee's work information
        $this->employee->workInfo()->updateOrCreate([], [
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

        // Update the employee's bank information
        $this->employee->bankInfo()->updateOrCreate([], [
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'account_type' => $this->account_type,
        ]);

        // Update the employee's identification information
        $this->employee->identificationInfo()->updateOrCreate([], [
            'sss_number' => $this->sss_number,
            'pag_ibig_number' => $this->pag_ibig_number,
            'philhealth_number' => $this->philhealth_number,
            'tin_number' => $this->tin_number,
        ]);

        // Emit an event to notify the parent component or close the modal
        $this->dispatch('employeeUpdated');

        // Flash success message
        session()->flash('message', 'Employee information updated successfully.');
    }

    public function confirmDelete($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            session()->flash('error', 'Employee not found.');
            return;
        }

        // Soft delete the employee
        $employee->delete();

        // Optionally, you can add logic to handle related data (e.g., payroll, requests, etc.)
        // Example: Archive payrolls or mark related data as inactive
        $employee->archivedPayrolls()->delete(); // Soft delete archived payrolls
        $employee->requests()->delete(); // Soft delete requests
        $employee->overtimeLogs()->delete(); // Soft delete overtime logs
        $employee->attendances()->delete(); // Soft delete attendances

        session()->flash('success', 'Employee deleted successfully.');
        $this->dispatch('employeeUpdated'); 
        $this->dispatch('close-modal');
    }
    

    public function render()
    {
        return view('livewire.employee-modal', [
            'departments' => $this->departments,
            'positions' => $this->positions,
        ]);
    }
}
