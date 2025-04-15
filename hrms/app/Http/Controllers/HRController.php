<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class HRController extends Controller
{
    use WithPagination;
    public function dashboard(){
        return view('hr.dashboard');
    }
    public function create(){
        return view('hr.create-employee');
    }

    public function index(){
       
        return view('hr.index');
    }

   

 
}
