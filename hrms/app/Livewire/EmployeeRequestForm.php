<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmployeeRequest; // ← Important: import your model
use Illuminate\Support\Facades\Auth; // ← We'll use Auth for employee_id (assuming logged-in employee)
use Carbon\Carbon; // ← Import Carbon for date handling

class EmployeeRequestForm extends Component
{
    public $request_type = 'overtime';
    public $overtime_reason = '';
    public $start_time;
    public $end_time;
    public $change_reason = '';

    public function updatedStartTime($value)
    {
        if ($value) {
            $start = \Carbon\Carbon::parse($value);
            // Auto-fill end time if it's empty or invalid
            if (!$this->end_time || \Carbon\Carbon::parse($this->end_time)->lessThanOrEqualTo($start)) {
                $this->end_time = $start->copy()->addHour()->format('Y-m-d\TH:i');
            }
        }
    }

    public function submit()
    {
        if ($this->request_type === 'overtime') {
            // Validate overtime fields
            $validated = $this->validate([
                'overtime_reason' => 'required|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ]);

            // Check for existing overtime request on the same day for this user
            $existing = EmployeeRequest::where('employee_id', Auth::id())
                ->where('request_type', 'overtime')
                ->whereDate('start_time', Carbon::parse($this->start_time)->toDateString())
                ->exists();

            if ($existing) {
                session()->flash('error', 'You already have an overtime request for this date.');
                return;
            }

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
