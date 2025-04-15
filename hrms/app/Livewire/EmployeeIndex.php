<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
class EmployeeIndex extends Component
{
    protected $listeners = ['employeeUpdated' => 'updateEmployee'];

    public $employees;

    public function updateEmployee($employeeId){

        
        $this->dispatch('refreshEmployee', $employeeId)->to('employee-modal');
    }

    public function render()
    {
        return view('livewire.employee-index');
    }


    
}


