<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
class EmployeeController extends Controller
{
    public function dashboard(){
        return view('employee.dashboard');
    }

    public function profile()
    {
        $employee = Auth::user();
        if ($employee instanceof \App\Models\User) {
            $employee->load(['workInfo', 'bankInfo', 'identificationInfo']);
        }
        return view('employee.profile', compact('employee'));
    }

    
    public function payslips()
{   //error due to employee being the autehnticatable user. as stated in config/auth.php
    /** @var \App\Models\Employee $employee */
    $employee = Auth::user();
    $payslips = $employee->archivedPayrolls()->orderBy('pay_period_start', 'desc')->get();
    
    return view('livewire.employee-payslip', compact('payslips'));
}
    
    public function requests(){
        return view('employee.request');
    }

    public function showRequestLogs(){
        return  view('employee.request-logs');
    }
    
    public function showAttendance(){
        return  view('employee.attendance');
    }
}
