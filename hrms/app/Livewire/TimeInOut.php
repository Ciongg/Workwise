<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use App\Services\TimeService;

class TimeInOut extends Component
{
    public $time_in;
    public $time_out;
    public $can_time_in = true;
    public $can_time_out = false;
    public $status = null;

    protected $listeners = ['timeUpdated' => '$refresh'];

    public function mount()
    {
        $today = TimeService::now()->toDateString();

        $attendance = Attendance::where('employee_id', Auth::id())
            ->where('date', $today)
            ->latest()
            ->first();

        if ($attendance) {
            $this->time_in = $attendance->time_in;
            $this->time_out = $attendance->time_out;
            $this->can_time_in = $attendance->time_in === null;
            $this->can_time_out = $attendance->time_in !== null && $attendance->time_out === null;
        } else {
            $this->time_in = null;
            $this->time_out = null;
            $this->can_time_in = true;
            $this->can_time_out = false;
        }
    }

    public function timeIn()
    {
        $now = TimeService::now();

        // Get employee's work end time
        $employee = \App\Models\Employee::find(Auth::id());
        $workInfo = $employee ? $employee->workInfo : null;

        if ($workInfo) {
            $workEnd = \Carbon\Carbon::parse($now->toDateString() . ' ' . $workInfo->work_end_time);
            if ($now->greaterThanOrEqualTo($workEnd)) {
                session()->flash('error', 'You cannot time in after your scheduled work end time.');
                return;
            }
        }

        // Prevent multiple time-ins for the same day without time-out
        $existing = Attendance::where('employee_id', Auth::id())
            ->where('date', $now->toDateString())
            ->whereNull('time_out')
            ->first();

        if ($existing) {
            session()->flash('error', 'You have already timed in and not yet timed out.');
            return;
        }

        Attendance::create([
            'employee_id' => Auth::id(),
            'date' => $now->toDateString(),
            'time_in' => $now->toTimeString(),
            'time_out' => null,
        ]);

        $this->time_in = $now->toTimeString();
        $this->time_out = null;
        $this->can_time_in = false;
        $this->can_time_out = true;
        $this->status = 'Timed In';
        session()->flash('successTimeRegister', 'Time In recorded! Please Time Out to log your attendance.');
    }

    public function timeOut()
    {
        $now = \App\Services\TimeService::now();

        $attendance = \App\Models\Attendance::where('employee_id', \Illuminate\Support\Facades\Auth::id())
            ->where('date', $now->toDateString())
            ->whereNull('time_out')
            ->latest()
            ->first();

        if (!$attendance) {
            session()->flash('error', 'Please Time In first!');
            return;
        }

        $timeIn = $attendance->time_in;
        $timeOut = $now->toTimeString();
        $hours = null;
        if ($timeIn && $timeOut) {
            $in = \Carbon\Carbon::parse($attendance->date . ' ' . $timeIn);
            $out = \Carbon\Carbon::parse($attendance->date . ' ' . $timeOut);
            $hours = abs($out->floatDiffInHours($in));
        }

        $attendance->update([
            'time_out' => $timeOut,
            'total_hours' => $hours,
            'status' => 'completed',
        ]);

        $this->time_out = $timeOut;
        $this->can_time_in = true;
        $this->can_time_out = false;
        $this->status = 'Timed Out';
        session()->flash('successTimeRegister', 'Attendance logged successfully!');

        $this->time_in = null;
        $this->time_out = null;
    }

    public function simulateNewDay()
    {
        $today = \App\Services\TimeService::now()->toDateString();
        \App\Models\Attendance::where('employee_id', Auth::id())
            ->where('date', $today)
            ->delete();

        $this->time_in = null;
        $this->time_out = null;
        $this->can_time_in = true;
        $this->can_time_out = false;
        session()->flash('successTimeRegister', 'Simulated new day! You can Time In again.');
    }

    public function render()
    {
        $today = \App\Services\TimeService::now()->toDateString();
        $attendance = \App\Models\Attendance::where('employee_id', \Illuminate\Support\Facades\Auth::id())
            ->where('date', $today)
            ->whereNull('time_out')
            ->latest()
            ->first();

        // Auto time out logic
        if ($attendance) {
            $employee = $attendance->employee;
            $workInfo = $employee->workInfo;
            if ($workInfo && $attendance->time_in) {
                $workEnd = \Carbon\Carbon::parse($attendance->date . ' ' . $workInfo->work_end_time);
                $now = \App\Services\TimeService::now();
                if ($now->greaterThanOrEqualTo($workEnd->copy()->addMinute())) { // <-- changed to addMinute()
                    // Auto time out
                    $in = \Carbon\Carbon::parse($attendance->date . ' ' . $attendance->time_in);
                    $hours = abs($workEnd->copy()->addMinute()->floatDiffInHours($in));
                    $attendance->update([
                        'time_out' => $workEnd->copy()->addMinute()->format('H:i:s'),
                        'total_hours' => $hours,
                        'status' => 'auto_timed_out',
                    ]);
                    // Refresh state
                    $this->time_in = null;
                    $this->time_out = null;
                    $this->can_time_in = true;
                    $this->can_time_out = false;
                    $this->status = 'Auto Timed Out';
                    session()->flash('successTimeRegister', 'You were automatically timed out.');
                }
            }
        }

        // Repeat the logic here for polling
        $attendance = Attendance::where('employee_id', Auth::id())
            ->where('date', $today)
            ->latest()
            ->first();

        if ($attendance) {
            $this->time_in = $attendance->time_in;
            $this->time_out = $attendance->time_out;
            $this->can_time_in = $attendance->time_in === null;
            $this->can_time_out = $attendance->time_in !== null && $attendance->time_out === null;
        } else {
            $this->time_in = null;
            $this->time_out = null;
            $this->can_time_in = true;
            $this->can_time_out = false;
        }

        return view('livewire.time-in-out');
    }
}
