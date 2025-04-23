<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmployeeRequest;

class RequestIndex extends Component
{
    use WithPagination;

    public $selectedRequest = null;
    public $modalKey;
    public $filter_created_at = '';
    public $filter_request_type = '';
    public $filter_status = '';

    protected $listeners = ['employeeRequestUpdated' => '$refresh'];

    public function selectRequest($id)
    {
        $this->selectedRequest = EmployeeRequest::with('employee')->find($id);

        $this->modalKey = uniqid(); // Use the request ID as the modal key
        $this->dispatch('open-modal', name: 'view-employee-request');
    }

    public function render()
    {
        $query = EmployeeRequest::query();

        if ($this->filter_created_at) {
            $query->whereDate('created_at', $this->filter_created_at);
        }
        if ($this->filter_request_type) {
            $query->where('request_type', $this->filter_request_type);
        }
        if ($this->filter_status) {
            $query->where('status', $this->filter_status);
        }

        $requests = $query->with('employee')->paginate(10); // Use paginate here

        return view('livewire.request-index', compact('requests'));
    }
}
