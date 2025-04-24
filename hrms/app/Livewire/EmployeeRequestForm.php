<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmployeeRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EmployeeRequestForm extends Component
{
    public $request_type = 'overtime';
    public $overtime_reason = '';
    public $start_time;
    public $end_time;
    public $change_reason = '';
    public $leave_type = '';
    public $leave_reason = '';

    public function updatedStartTime($value)
    {
        if ($value) {
            $start = \Carbon\Carbon::parse($value);
            if (!$this->end_time || \Carbon\Carbon::parse($this->end_time)->lessThanOrEqualTo($start)) {
                $this->end_time = $start->copy()->addHour()->format('Y-m-d\TH:i');
            }
        }
    }

    public function submit()
    {
        if ($this->request_type === 'overtime') {
            $validated = $this->validate([
                'overtime_reason' => 'required|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ]);

            $existing = EmployeeRequest::where('employee_id', Auth::id())
                ->where('request_type', 'overtime')
                ->whereDate('start_time', Carbon::parse($this->start_time)->toDateString())
                ->exists();

            if ($existing) {
                session()->flash('error', 'You already have an overtime request for this date.');
                return;
            }

            EmployeeRequest::create([
                'employee_id' => Auth::id(),
                'request_type' => 'overtime',
                'reason' => $this->overtime_reason,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'status' => 'pending',
                'return_date' => null,
            ]);

            session()->flash('success', 'Overtime Request Submitted Successfully!');
            $this->reset();

        } elseif ($this->request_type === 'employee_concern') {
            $validated = $this->validate([
                'change_reason' => 'required|string',
            ]);

            EmployeeRequest::create([
                'employee_id' => Auth::id(),
                'request_type' => 'employee_concern',
                'reason' => $this->change_reason,
                'start_time' => null,
                'end_time' => null,
                'status' => 'pending',
                'return_date' => null,
            ]);

            session()->flash('success', 'Profile Change Request Submitted Successfully!');
            $this->reset();

        } elseif ($this->request_type === 'leave') {
            $validated = $this->validate([
                'leave_type' => 'required|string',
                'leave_reason' => 'required|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after_or_equal:start_time',
            ]);

            EmployeeRequest::create([
                'employee_id' => Auth::id(),
                'request_type' => 'leave',
                'reason' => $this->leave_type,
                'leave_reason' => $this->leave_reason,
                'start_time' => Carbon::parse($this->start_time)->startOfDay(),
                'end_time' => Carbon::parse($this->end_time)->endOfDay(),
                'status' => 'pending',
            ]);

            session()->flash('success', 'Leave Request Submitted Successfully!');
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
