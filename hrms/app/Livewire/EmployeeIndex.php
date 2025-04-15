<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
class EmployeeIndex extends Component
{
    public $employees;
    //$refresh is not needed it just readability that thats what it does, even withotu it it refreshes the livewire when it hears a signal.
    protected $listeners = ['employeeUpdated' => '$refresh'];



    public function render()
    {
        return view('livewire.employee-index');
    }


    
}


