<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AllAttendanceIndex extends Component
{
    use WithPagination;

    public $sortField = 'date';
    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $user = Auth::user();
        // dd($user); // Uncomment to see the authenticated employee

        $attendances = Attendance::with('employee')
            ->where('employee_id', $user->id) // Make sure this matches your attendance table
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.all-attendance-index', [
            'attendances' => $attendances,
        ]);
    }
}
