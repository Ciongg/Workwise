<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Livewire\WithPagination;

class EmployeeIndex extends Component
{

    use WithPagination;

    //$refresh is not needed it just readability that thats what it does, even withotu it it refreshes the livewire when it hears a signal.
    protected $listeners = ['employeeUpdated' => '$refresh'];

    public $selectedEmployee = null;

    public function selectEmployee($id)
    {
        $this->selectedEmployee = Employee::find($id);
        $this->dispatch('open-modal', name: 'view-employee');
    }

    

      public function render()
    {
 
        return view('livewire.employee-index', [
            'employees' => Employee::query()->paginate(10)
        ]);
    }


    
}


