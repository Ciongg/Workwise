<?php

use App\Http\Controllers\HRController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

use App\Livewire\EmployeeRequest;

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
Route::get('/hr/dashboard/request', [HRController::class, 'showRequests'])->name('hr.show-requests');
Route::get('/hr/dashboard/attendance', [HRController::class, 'showAttendance'])->name('hr.show-attendance');

// Authentication Routes
Route::post('/login', [SessionController::class, 'store'])->name('login');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');
Route::view('/about', 'about')->name('about');

// Employee Routes
Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
Route::get('/employee/requests', [EmployeeController::class, 'requests'])->name('employee.requests');
Route::get('/employee/request', [EmployeeController::class, 'showRequestLogs'])->name('employee.show-request-logs');


//for both hr and employee
Route::get('/employee/attendance', [EmployeeController::class, 'showAttendance'])->name('employee.attendance');
Route::get('/employee/profile', [EmployeeController::class, 'profile'])->name('employee.profile');
Route::get('/employee/payslips', [EmployeeController::class, 'payslips'])->name('employee.payslips');
