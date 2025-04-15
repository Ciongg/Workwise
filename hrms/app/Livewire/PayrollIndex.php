<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Employee;
class PayrollIndex extends Component
{
   

    public function mount()
    {
       
    }

    public function edit($id)
    {
        // Redirect or emit event to open edit modal
    }

        


    public function render()
    {
        $employees = Employee::all();
        return view('livewire.payroll-index', compact('employees'));
    }
}
