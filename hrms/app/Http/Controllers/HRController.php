<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class HRController extends Controller
{
    public function dashboard(){
        return view('hr.dashboard');
    }
    public function create(){
        return view('hr.create-employee');
    }

    public function index(Employee $employee){
        $employees = Employee::all();
        return view('hr.index', compact('employees'));
    }

   

 
}
