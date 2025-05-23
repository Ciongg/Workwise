<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\OvertimeLog;
use App\Models\EmployeeRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\PayrollService;
use App\Services\TimeService;

class OvertimeLogModal extends Component
{
    public $request;
    public $time_in;
    public $time_out;
    public $current_time; // Add this property

    public function mount($request)
    {
        $this->request = $request;
        $this->current_time = TimeService::now(); // Use TimeService
    }

    public function timeIn()
    {
        if ($this->request->overtimeLog) return;

        $current_time = TimeService::now();
        $start = \Carbon\Carbon::parse($this->request->start_time);
        $end = \Carbon\Carbon::parse($this->request->end_time);

        // Only allow time in if current time is >= (start - 10 min) and <= end
        if ($current_time->lessThan($start->copy()->subMinutes(10)) || $current_time->greaterThan($end)) {
            session()->flash('error', 'You cannot time in outside the allowed time window.');
            return;
        }

        session()->flash('sucess', 'Timed in successfully!.');
        OvertimeLog::create([
            'employee_id' => $this->request->employee_id,
            'request_id' => $this->request->id,
            'ot_time_in' => $current_time,
            'ot_time_out' => null,
            'total_hours' => 0,
            'status' => 'pending',
        ]);

        $this->time_in = $current_time->format('Y-m-d H:i:s');
        $this->dispatch('employeeRequestUpdated');
    }

    public function timeOut()
    {
        $log = $this->request->overtimeLog;
        if (!$log || $log->ot_time_out) return;

        // Use the current time from TimeService for time-out
        $current_time = TimeService::now();

        $start = \Carbon\Carbon::parse($log->ot_time_in);
        $hours = abs($current_time->floatDiffInHours($start));

        $log->update([
            'ot_time_out' => $current_time,
            'total_hours' => $hours,
            'status' => 'completed', // Set to completed
        ]);

        $request = $log->request;
        if ($request && $request->status !== 'completed') {
            $request->update(['status' => 'completed']);
        }

        $employee = $log->employee;
        if ($employee) {
            $payroll = PayrollService::generatePayrollForEmployee($employee);
            $employee->refresh();
            $employee->load('payrollInfo');
            
        }
        session()->flash('sucess', 'Timed out successfully!.');
        $this->dispatch('overtimeCompleted');
        $this->dispatch('employeeRequestUpdated');
        $this->dispatch('close-modal');
    }

    public function pollTime()
    {
        $this->current_time = TimeService::now();

        $log = $this->request->overtimeLog;
        $now = $this->current_time;
        $start = \Carbon\Carbon::parse($this->request->start_time);
        $end = \Carbon\Carbon::parse($this->request->end_time);

        // 1. Auto-cancel if user missed time-in window 10 minutes
        if (!$log && $now->greaterThan($start->copy()->addMinutes(5))) {
            OvertimeLog::create([
                'employee_id' => $this->request->employee_id,
                'request_id' => $this->request->id,
                'ot_time_in' => null,
                'ot_time_out' => null,
                'total_hours' => 0,
                'status' => 'cancelled',
            ]);

            
          
            $this->request->update(['status' => 'cancelled']);
            $this->dispatch('overtimeCompleted');
            $this->dispatch('employeeRequestUpdated');
            $this->dispatch('close-modal');
            return;
        }

        // 2. Auto time out if user timed in but didn't time out
        if ($log && $log->ot_time_in && !$log->ot_time_out && $now->greaterThanOrEqualTo($end->copy()->addMinute())) {
            $start = \Carbon\Carbon::parse($log->ot_time_in);
            $hours = abs($now->floatDiffInHours($start));
            $log->update([
                'ot_time_out' => $now,
                'total_hours' => $hours,
                'status' => 'auto_timed_out',
            ]);
            $this->request->update(['status' => 'auto_timed_out']);

            $employee = $log->employee;
            if ($employee) {
                $payroll = PayrollService::generatePayrollForEmployee($employee);
                $employee->refresh();
                $employee->load('payrollInfo');
                
            }


            $this->dispatch('overtimeCompleted');
            $this->dispatch('employeeRequestUpdated');
            $this->dispatch('close-modal');
            return;
        }
    }

    public function getCanTimeInProperty()
    {
        $now = TimeService::now();
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
