<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\OvertimeLog;
use App\Models\EmployeeRequest;
use Illuminate\Support\Facades\Auth;

class OvertimeLogModal extends Component
{
    public $request;
    public $time_in;
    public $time_out;

    public function mount($request)
    {
        $this->request = $request;
    }

    public function timeIn()
    {
        if ($this->request->overtimeLog) return;

        $now = now();
        OvertimeLog::create([
            'employee_id' => $this->request->employee_id,
            'request_id' => $this->request->id,
            'ot_time_in' => $now,
            'ot_time_out' => null,
            'total_hours' => 0,
            'status' => 'pending',
        ]);
        $this->time_in = $now->format('Y-m-d H:i:s');
        $this->dispatch('employeeRequestUpdated');
    }

    public function timeOut()
    {
        $log = $this->request->overtimeLog;
        if (!$log || $log->ot_time_out) return;

        $now = now();
        $start = \Carbon\Carbon::parse($log->ot_time_in);
        $end = $now;

        // Always positive, even if user logs out before in (shouldn't happen, but safe)
        $hours = abs($end->floatDiffInHours($start));

        $log->update([
            'ot_time_out' => $now,
            'total_hours' => $hours,
            'status' => 'completed',
        ]);
        $this->time_out = $now->format('Y-m-d H:i:s');
        $this->dispatch('employeeRequestUpdated');
        $this->dispatch('close-modal');
    }

    public function getCanTimeInProperty()
    {
        $now = now();
        $start = \Carbon\Carbon::parse($this->request->start_time);
        return $now->greaterThanOrEqualTo($start->copy()->subMinutes(5)) && $now->lessThanOrEqualTo($start->copy()->addMinutes(10));
    }

    public function render()
    {
        // Always get the latest overtime log for this request
        $overtimeLog = $this->request->overtimeLog()->first();
        $this->time_in = $overtimeLog ? $overtimeLog->ot_time_in : null;
        $this->time_out = $overtimeLog ? $overtimeLog->ot_time_out : null;

        return view('livewire.overtime-log-modal');
    }
}
