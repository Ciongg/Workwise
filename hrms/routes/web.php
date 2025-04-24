<?php

use App\Http\Controllers\HRController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

use App\Livewire\EmployeeRequest;
use Illuminate\Support\Facades\Auth;



Route::get('/', function () {
    return view('welcome');
});

// HR Routes - only HRs
Route::middleware(['auth', 'can:is-hr'])->controller(HRController::class)->group(function () {
    Route::get('/hr/dashboard', 'dashboard')->name('hr.dashboard');
    Route::get('/hr/dashboard/create-employee', 'create')->name('hr.create-employee');
    Route::get('/hr/dashboard/employees', 'index')->name('hr.show-employees');
    Route::get('/hr/dashboard/payroll', 'showPayroll')->name('hr.show-payroll');
    Route::get('/hr/dashboard/payroll/deductions', 'showPayrollDeductions')->name('hr.show-payroll-deductions');
    Route::post('/hr/dashboard/payroll/deductions', 'updatePayrollDeductions')->name('hr.update-payroll-deductions');
    Route::get('/hr/dashboard/payroll/archived', 'showArchivedPayroll')->name('hr.show-archived-payroll');
    Route::get('/hr/dashboard/request', 'showRequests')->name('hr.show-requests');
    Route::get('/hr/dashboard/attendance', 'showAttendance')->name('hr.show-attendance');
});

// Authentication Routes

Route::get('/login', [SessionController::class, 'showLogin'])->name('show.login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->name('login');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

Route::view('/about', 'about')->name('about');


Route::middleware(['auth', 'can:is-employee'])->group(function (){

    // Employee Routes
    Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    Route::get('/employee/requests', [EmployeeController::class, 'requests'])->name('employee.requests');
    Route::get('/employee/request', [EmployeeController::class, 'showRequestLogs'])->name('employee.show-request-logs');
    
});


Route::get('/employee/attendance', [EmployeeController::class, 'showAttendance'])->name('employee.attendance');
Route::get('/employee/profile', [EmployeeController::class, 'profile'])->name('employee.profile');
Route::get('/employee/payslips', [EmployeeController::class, 'payslips'])->name('employee.payslips');

