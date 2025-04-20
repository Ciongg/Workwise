<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmployeeRequest;

class RequestIndex extends Component
{
    public $selectedRequest = null;
    public $modalKey;

    protected $listeners = ['employeeRequestUpdated' => '$refresh'];


   
    public function selectRequest($id)
    {
        $this->selectedRequest = EmployeeRequest::with('employee')->find($id);

        $this->modalKey = uniqid(); // Use the request ID as the modal key
        $this->dispatch('open-modal', name: 'view-employee-request');
    }



   
    public function render()
    {
        $requests = EmployeeRequest::with('employee')->get();

        return view('livewire.request-index', compact('requests'));
    }
}
