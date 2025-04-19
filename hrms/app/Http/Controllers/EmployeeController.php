<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class EmployeeController extends Controller
{
    public function dashboard(){
        return view('employee.dashboard');
    }

    public function profile()
    {
        $employee = Auth::user()->load(['workInfo', 'bankInfo', 'identificationInfo']);
        return view('employee.profile', compact('employee'));
    }

    public function payslips()
    {
        $employee = Auth::user();
        $payslips = $employee->archivedPayrolls()->orderBy('pay_period_start', 'desc')->get();

        return view('livewire.employee-payslip', compact('payslips'));
    }

    public function requests(){
        return view('employee.request');
    }
}
