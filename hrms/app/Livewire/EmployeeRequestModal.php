<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmployeeRequest;

class EmployeeRequestModal extends Component
{
    public $request;

    // Request Details
    public $employeeName;
    public $requestType;
    public $reason;
    public $startTime;
    public $endTime;
    public $status;

    public function mount(EmployeeRequest $request)
    {
        $this->request = $request;

        // Populate the modal fields
        $this->employeeName = $request->employee->first_name . ' ' . $request->employee->last_name;
        $this->requestType = $request->request_type;
        $this->reason = $request->reason;
        $this->startTime = $request->start_time;
        $this->endTime = $request->end_time;
        $this->status = $request->status;
    }

    public function save()
    {
        $this->validate([
            'reason' => 'required|string|max:255',
            'startTime' => 'nullable|date',
            'endTime' => 'nullable|date|after:startTime',
            'status' => 'required|in:pending,approved,rejected,cancelled,auto_timed_out,completed',
        ]);

        // Update the request
        $this->request->update([
            'reason' => $this->reason,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'status' => $this->status,
        ]);

        $this->dispatch('employeeRequestUpdated', requestId: $this->request->id);
        $this->dispatch('close-modal');
  
    }

    public function render()
    {
        return view('livewire.employee-request-modal');
    }
}
