<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use App\Models\Employee;

class AttendanceCreateModal extends Component
{
    public $employee_id;
    public $employee_name;
    public $date;
    public $time_in;
    public $time_out;
    

    protected $rules = [
        'employee_id' => 'required|exists:employees,id',
        'date' => 'required|date',
        'time_in' => 'nullable|date_format:H:i',
        'time_out' => 'nullable|date_format:H:i|after:time_in',
    ];

    public function updatedEmployeeId()
    {
        $employee = Employee::find($this->employee_id);
        $this->employee_name = $employee ? $employee->first_name . ' ' . $employee->last_name : null;
    }

    public function save()
    {
        $this->validate();

        $timeIn = $this->time_in ? $this->time_in . ':00' : null;
        $timeOut = $this->time_out ? $this->time_out . ':00' : null;
        $hours = null;

        if ($timeIn && $timeOut) {
            $in = \Carbon\Carbon::parse($this->date . ' ' . $timeIn);
            $out = \Carbon\Carbon::parse($this->date . ' ' . $timeOut);
            $hours = abs($out->floatDiffInHours($in));
        }

        \App\Models\Attendance::create([
            'employee_id' => $this->employee_id,
            'date' => $this->date,
            'time_in' => $timeIn,
            'time_out' => $timeOut,
            'total_hours' => $hours,
        ]);

        $this->dispatch('attendanceUpdated');
        $this->dispatch('closeCreateAttendance');
        $this->dispatch('close-modal');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.attendance-create-modal');
    }
}
