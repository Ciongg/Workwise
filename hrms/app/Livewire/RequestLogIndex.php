<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmployeeRequest;
use Illuminate\Support\Facades\Auth;

class RequestLogIndex extends Component
{
    use WithPagination;





    public $showOvertimeLogModal = false;
    public $selectedOvertimeRequest;
    public $modalKey;



    public function openOvertimeLog($requestId)
    {
    $this->selectedOvertimeRequest = EmployeeRequest::find($requestId);
    $this->showOvertimeLogModal = true;
    $this->modalKey = uniqid();
    $this->dispatch('open-modal', ['name' => 'overtime-log']);
    }


    public $searchType = '';    
    public $searchStatus = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public function updatedSearchType()
    {
        $this->resetPage(); // Reset pagination when the type filter changes
    }

    public function updatedSearchStatus()
    {
        $this->resetPage(); // Reset pagination when the status filter changes
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

    public function render()
    {
        $query = EmployeeRequest::where('employee_id', Auth::id());

        // Filter by request type
        if (!empty($this->searchType)) {
            $query->where('request_type', $this->searchType);
        }

        // Filter by status
        if (!empty($this->searchStatus)) {
            $query->where('status', $this->searchStatus);
        }

        $requests = $query
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.request-log-index', [
            'requests' => $requests,
        ]);
    }
}
