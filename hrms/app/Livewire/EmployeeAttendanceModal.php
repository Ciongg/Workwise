<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use App\Models\Employee;

class EmployeeAttendanceModal extends Component
{
    public $attendance;
    public $employee_id;
    public $date;
    public $time_in;
    public $time_out;
    public $isNew = false;

    public function mount($attendance = null)
    {
        $this->attendance = $attendance;
        $this->employee_id = $attendance?->employee_id;
        $this->date = $attendance?->date ?? now()->toDateString();
        $this->time_in = $attendance && $attendance->time_in ? substr($attendance->time_in, 0, 5) : null;
        $this->time_out = $attendance && $attendance->time_out ? substr($attendance->time_out, 0, 5) : null;
        $this->isNew = !$attendance;
    }

    public function save()
    {
        $this->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i|after:time_in',
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
            ]);
        } else {
            \App\Models\Attendance::create([
                'employee_id' => $this->employee_id,
                'date' => $this->date,
                'time_in' => $timeIn,
                'time_out' => $timeOut,
                'total_hours' => $hours,
            ]);
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
