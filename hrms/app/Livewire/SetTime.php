<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TimeService;

class SetTime extends Component
{
    public $custom_time;

    public function setTime()
    {
        $this->validate([
            'custom_time' => 'required|date',
        ]);

        TimeService::setTime($this->custom_time);
        session()->flash('successTimeSet', 'Time has been set successfully!');
        $this->dispatch('timeUpdated'); // Emit an event to notify other components
    }

    public function resetTime()
    {
        TimeService::resetTime();
        session()->flash('successTimeSet', 'Time has been reset to the system time!');
        $this->dispatch('timeUpdated'); // Emit an event to notify other components
    }

    public function simulateNewDay()
    {
        $today = \App\Services\TimeService::now()->toDateString();
        \App\Models\Attendance::where('employee_id', auth()->id())
            ->where('date', $today)
            ->delete();

        session()->flash('successTimeSet', 'Simulated new day! You can Time In again.');
        $this->dispatch('timeUpdated');
    }

    public function render()
    {
        return view('livewire.set-time');
    }
}
