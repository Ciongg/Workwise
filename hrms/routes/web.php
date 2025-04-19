<?php

use App\Http\Controllers\HRController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Livewire\Employee\EmployeeRequestForm;
use App\Livewire\Employee\EmployeeOvertimeLog;


Route::get('/', function () {
    return view('welcome');
});

// HR Routes
Route::get('/hr/dashboard', [HRController::class, 'dashboard'])->name('hr.dashboard');
Route::get('/hr/dashboard/create-employee', [HRController::class, 'create'])->name('hr.create-employee');
Route::get('/hr/dashboard/employees', [HRController::class, 'index'])->name('hr.show-employees');
Route::get('/hr/dashboard/payroll', [HRController::class, 'showPayroll'])->name('hr.show-payroll');
Route::get('/hr/dashboard/payroll/deductions', [HRController::class, 'showPayrollDeductions'])->name('hr.show-payroll-deductions');
Route::post('/hr/dashboard/payroll/deductions', [HRController::class, 'updatePayrollDeductions'])->name('hr.update-payroll-deductions');
Route::get('/hr/dashboard/payroll/archived', [HRController::class, 'showArchivedPayroll'])->name('hr.show-archived-payroll');

// Authentication Routes
Route::post('/login', [SessionController::class, 'store'])->name('login');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

// Employee Routes
Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
Route::get('/employee/profile', [EmployeeController::class, 'profile'])->name('employee.profile');
Route::get('/employee/payslips', [EmployeeController::class, 'payslips'])->name('employee.payslips');

// Livewire Components for Employee
Route::get('/employee/requests', EmployeeRequestForm::class)->name('employee.requests');
Route::get('/employee/overtime-log', EmployeeOvertimeLog::class)->name('employee.overtime-log');
