<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\EmployeeRequest;

class EmployeeAttendanceModal extends Component
{
    public $attendance;
    public $employee_id;
    public $date;
    public $time_in;
    public $time_out;
    public $status;
    public $ot_status;
    public $isNew = false;

    public function mount($attendance = null)
    {
        $this->attendance = $attendance;
        $this->employee_id = $attendance?->employee_id;
        $this->date = $attendance?->date ?? now()->toDateString();
        $this->time_in = $attendance && $attendance->time_in ? substr($attendance->time_in, 0, 5) : null;
        $this->time_out = $attendance && $attendance->time_out ? substr($attendance->time_out, 0, 5) : null;

        // Set the status directly from the attendance if it exists, otherwise default to 'completed'
        $this->status = $attendance ? $attendance->status : 'pending'; // Defaulting to 'pending'

        // Initialize overtime status to null
        $this->ot_status = null;

        // Load overtime status if attendance exists
        if ($attendance) {
            $otLog = $attendance->employee->overtimeLogs()->whereDate('ot_time_in', $attendance->date)->first();
            if ($otLog) {
                $this->ot_status = $otLog->status;
            }
        }

        // Check if this is a new attendance record
        $this->isNew = !$attendance;
    }

    public function save()
    {
        $this->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i|after:time_in',
            'status' => 'required|in:completed,auto_timed_out',
            'ot_status' => 'nullable|in:pending,completed,auto_timed_out',
        ]);

        $timeIn = $this->time_in ? $this->time_in . ':00' : null;
        $timeOut = $this->time_out ? $this->time_out . ':00' : null;
        $hours = null;

        if ($timeIn && $timeOut) {
            $in = \Carbon\Carbon::parse($this->date . ' ' . $timeIn);
            $out = \Carbon\Carbon::parse($this->date . ' ' . $timeOut);
            $hours = abs($out->floatDiffInHours($in));
        }

        if ($this->attendance) {
            $this->attendance->update([
                'employee_id' => $this->employee_id,
                'date' => $this->date,
                'time_in' => $timeIn,
                'time_out' => $timeOut,
                'total_hours' => $hours,
                'status' => $this->status, // Save status
            ]);
        } else {
            \App\Models\Attendance::create([
                'employee_id' => $this->employee_id,
                'date' => $this->date,
                'time_in' => $timeIn,
                'time_out' => $timeOut,
                'total_hours' => $hours,
                'status' => $this->status, // Save status
            ]);
        }

        // Update overtime status if available
        if ($this->ot_status && $this->attendance) {
            $otLog = $this->attendance->employee->overtimeLogs()
                ->whereDate('ot_time_in', $this->attendance->date)
                ->first();
            if ($otLog) {
                $otLog->update(['status' => $this->ot_status]);
            }
        }

        $this->dispatch('attendanceUpdated');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        $employees = Employee::orderBy('first_name')->get();
        return view('livewire.employee-attendance-modal', compact('employees'));
    }
}
