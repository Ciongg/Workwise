<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\OvertimeLog;

class AttendanceCreateModal extends Component
{
    public $employee_id;
    public $employee_name;
    public $date;
    public $time_in;
    public $time_out;
    public $ot_time_in;
    public $ot_time_out;
    public $ot_status = 'completed';
    public $request_id;

    protected $rules = [
        'employee_id' => 'required|exists:employees,id',
        'date' => 'required|date',
        'time_in' => 'nullable|date_format:H:i',
        'time_out' => 'nullable|date_format:H:i|after:time_in',
        'ot_time_in' => 'nullable|date_format:H:i',
        'ot_time_out' => 'nullable|date_format:H:i|after:ot_time_in',
    ];

    public function updatedEmployeeId()
    {
        $employee = Employee::find($this->employee_id);
        $this->employee_name = $employee ? $employee->first_name . ' ' . $employee->last_name : null;
    }

    public function updatedRequestId($value)
    {
        $request = \App\Models\EmployeeRequest::find($value);
        if ($request) {
            // Format as H:i for time input fields
            $this->ot_time_in = \Carbon\Carbon::parse($request->start_time)->format('H:i');
            $this->ot_time_out = \Carbon\Carbon::parse($request->end_time)->format('H:i');
        } else {
            $this->ot_time_in = null;
            $this->ot_time_out = null;
        }
    }

    public function save()
    {
        $this->validate();

        $timeIn = $this->time_in ? $this->time_in . ':00' : null;
        $timeOut = $this->time_out ? $this->time_out . ':00' : null;
        $otTimeIn = $this->ot_time_in ? $this->ot_time_in . ':00' : null;
        $otTimeOut = $this->ot_time_out ? $this->ot_time_out . ':00' : null;

        $hours = null;
        $otHours = null;

        if ($timeIn && $timeOut) {
            $in = \Carbon\Carbon::parse($this->date . ' ' . $timeIn);
            $out = \Carbon\Carbon::parse($this->date . ' ' . $timeOut);
            $hours = abs($out->floatDiffInHours($in));
        }

        if ($otTimeIn && $otTimeOut) {
            $otIn = \Carbon\Carbon::parse($this->date . ' ' . $otTimeIn);
            $otOut = \Carbon\Carbon::parse($this->date . ' ' . $otTimeOut);
            $otHours = abs($otOut->floatDiffInHours($otIn));
        }

        $attendance = \App\Models\Attendance::create([
            'employee_id' => $this->employee_id,
            'date' => $this->date,
            'time_in' => $timeIn,
            'time_out' => $timeOut,
            'total_hours' => $hours,
        ]);

        if ($otTimeIn || $otTimeOut) {
            \App\Models\OvertimeLog::create([
                'employee_id' => $this->employee_id,
                'request_id' => $this->request_id, // If linked to a request, set the request ID
                'ot_time_in' => $otTimeIn,
                'ot_time_out' => $otTimeOut,
                'total_hours' => $otHours,
                'status' => $this->ot_status,
            ]);
        }

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
