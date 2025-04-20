<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmployeeRequest; // ← Important: import your model
use Illuminate\Support\Facades\Auth; // ← We'll use Auth for employee_id (assuming logged-in employee)

class EmployeeRequestForm extends Component
{
    public $request_type = 'overtime';
    public $overtime_reason = '';
    public $start_time;
    public $end_time;
    public $change_reason = '';

    public function submit()
    {
        if ($this->request_type === 'overtime') {
            // Validate overtime fields
            $validated = $this->validate([
                'overtime_reason' => 'required|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ]);

            EmployeeRequest::create([
                'employee_id' => Auth::id(), // Assuming employee is logged in
                'request_type' => 'overtime',
                'reason' => $this->overtime_reason,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'status' => 'pending',
            ]);

            session()->flash('success', 'Overtime Request Submitted Successfully!');
            $this->reset(); // clear form fields

        } elseif ($this->request_type === 'profile_change') {
            // Validate profile change fields
            $validated = $this->validate([
                'change_reason' => 'required|string',
            ]);

            EmployeeRequest::create([
                'employee_id' => Auth::id(),
                'request_type' => 'profile_change',
                'reason' => $this->change_reason,
                'start_time' => null,
                'end_time' => null,
                'status' => 'pending',
            ]);

            session()->flash('success', 'Profile Change Request Submitted Successfully!');
            $this->reset();
        } else {
            $this->addError('request_type', 'Please select a valid request type.');
        }
    }

    public function render()
    {
        return view('livewire.employee-request-form');
    }
}
