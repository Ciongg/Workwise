<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
class EmployeeIndex extends Component
{

    public $searchRole = '';
    public $searchName = '';
    public $sortField = 'id'; //default ascending in the index
    public $sortDirection = 'asc';
    public $modalKey;

    use WithPagination;
    
    public $selectedEmployee = null;
    //$refresh is not needed it just readability that thats what it does, even withotu it it refreshes the livewire when it hears a signal.
    protected $listeners = ['employeeUpdated' => '$refresh'];


    public function selectEmployee($id)
    {
        $this->selectedEmployee = Employee::find($id);
        $this->modalKey = uniqid(); // Generate a unique key for the modal
        $this->dispatch('open-modal', ['name' => 'view-employee']); // Ensure the name matches the modal's name
    }

 


    public function updatedSearchRole()
    {
        $this->resetPage();  // Reset to page 1 whenever the role filter changes
    }


    public function updatedSearchName()
    {
        $this->resetPage();  // Reset to page 1 whenever the name filter changes
    }


    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    public function confirmDelete($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            session()->flash('error', 'Employee not found.');
            return;
        }

        // Soft delete the employee
        $employee->delete();

        // Optionally, you can add logic to handle related data (e.g., payroll, requests, etc.)
        // Example: Archive payrolls or mark related data as inactive
        $employee->archivedPayrolls()->delete(); // Soft delete archived payrolls
        $employee->requests()->delete(); // Soft delete requests
        $employee->overtimeLogs()->delete(); // Soft delete overtime logs
        $employee->attendances()->delete(); // Soft delete attendances

        session()->flash('success', 'Employee deleted successfully.');
        $this->resetPage(); // Reset pagination to avoid issues with deleted records
    }
    
      public function render()
    {
 
        $query = Employee::with('workInfo');

        // Filter by role if a role is selected
        if (!empty($this->searchRole)) {
            $query->where('role', $this->searchRole);
        }

        // Filter by name if a search term is entered
        if (!empty($this->searchName)) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->searchName . '%')
                ->orWhere('last_name', 'like', '%' . $this->searchName . '%');
            });
        }
        
        $employees = $query
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate(10);
        

    return view('livewire.employee-index', [
        'employees' => $employees,
    ]);
    }


    
}


