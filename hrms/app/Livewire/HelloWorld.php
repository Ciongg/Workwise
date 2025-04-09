<?php

namespace App\Livewire;
use LivewireUI\Modal\ModalComponent;
use Livewire\Component;
use App\Models\Employee;
class HelloWorld extends ModalComponent
{
    public Employee $employee;
    
    public function render()
    {
        return view('livewire.hello-world');
    }
}
