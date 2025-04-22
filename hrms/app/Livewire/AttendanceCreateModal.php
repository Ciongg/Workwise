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
        'request_id' => 'nullable|exists:employee_requests,id',
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
            // Only set the time part for <input type="time">
            $this->ot_time_in = $request->start_time ? \Carbon\Carbon::parse($request->start_time)->format('H:i') : null;
            $this->ot_time_out = $request->end_time ? \Carbon\Carbon::parse($request->end_time)->format('H:i') : null;
        } else {
            $this->ot_time_in = null;
            $this->ot_time_out = null;
        }
    }

    public function save()
    {
        $this->validate();

        // Custom validation: request_id must belong to employee_id
        if ($this->request_id) {
            $request = \App\Models\EmployeeRequest::where('id', $this->request_id)
                ->where('employee_id', $this->employee_id)
                ->first();

            if (!$request) {
                $this->addError('request_id', 'The selected request does not belong to this employee.');
                return;
            }

            // Check if the request_id is already associated with an OvertimeLog
            $existingOvertimeLog = \App\Models\OvertimeLog::where('request_id', $this->request_id)->first();
            if ($existingOvertimeLog) {
                $this->addError('request_id', 'This Overtime Request ID is already associated with an overtime log.');
                return;
            }
        }

        $timeIn = $this->time_in ? $this->time_in . ':00' : null;
        $timeOut = $this->time_out ? $this->time_out . ':00' : null;

        // Combine date and time for overtime
        $otTimeIn = ($this->ot_time_in && $this->date)
            ? $this->date . ' ' . $this->ot_time_in . ':00'
            : null;
        $otTimeOut = ($this->ot_time_out && $this->date)
            ? $this->date . ' ' . $this->ot_time_out . ':00'
            : null;

        $hours = null;
        $otHours = null;

        if ($timeIn && $timeOut) {
            $in = \Carbon\Carbon::parse($this->date . ' ' . $timeIn);
            $out = \Carbon\Carbon::parse($this->date . ' ' . $timeOut);
            $hours = abs($out->floatDiffInHours($in));
        }

        if ($otTimeIn && $otTimeOut) {
            $otIn = \Carbon\Carbon::parse($otTimeIn);
            $otOut = \Carbon\Carbon::parse($otTimeOut);
            $otHours = abs($otOut->floatDiffInHours($otIn));
        }

        try {
            $attendance = \App\Models\Attendance::create([
                'employee_id' => $this->employee_id,
                'date' => $this->date,
                'time_in' => $timeIn,
                'time_out' => $timeOut,
                'total_hours' => $hours,
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create attendance: ' . $e->getMessage());
            return;
        }

        if ($otTimeIn || $otTimeOut) {
            try {
                \App\Models\OvertimeLog::create([
                    'employee_id' => $this->employee_id,
                    'request_id' => $this->request_id, // If linked to a request, set the request ID
                    'ot_time_in' => $otTimeIn,
                    'ot_time_out' => $otTimeOut,
                    'total_hours' => $otHours,
                    'status' => $this->ot_status,
                ]);
            } catch (\Exception $e) {
                session()->flash('error', 'Attendance created, but failed to create overtime log: ' . $e->getMessage());
                return;
            }
        }

        session()->flash('success', 'Attendance created successfully.');
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
