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
        $now = TimeService::now();

        $attendance = Attendance::where('employee_id', Auth::id())
            ->where('date', $now->toDateString())
            ->whereNull('time_out')
            ->latest()
            ->first();

        if (!$attendance) {
            session()->flash('error', 'Please Time In first!');
            return;
        }

        $attendance->update([
            'time_out' => $now->toTimeString(),
        ]);

        $this->time_out = $now->toTimeString();
        $this->can_time_in = true;
        $this->can_time_out = false;
        $this->status = 'Timed Out';
        session()->flash('successTimeRegister', 'Attendance logged successfully!');

        // Optionally reset for next day
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
        // Repeat the logic here for polling
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

        return view('livewire.time-in-out');
    }
}
