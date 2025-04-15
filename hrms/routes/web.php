<?php

use App\Http\Controllers\HRController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Livewire\ShowEmployeeModal;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/hr/dashboard', [HRController::class, 'dashboard'])->name('hr.dashboard');
Route::get('/hr/dashboard/create-employee', [HRController::class, 'create'])->name('hr.create-employee');
Route::get('/hr/dashboard/employees', [HRController::class, 'index'])->name('hr.show-employees');
Route::get('/hr/dashboard/payroll', [HRController::class, 'showPayroll'])->name('hr.show-payroll');



Route::post('/login', [SessionController::class, 'store'])->name('login');

Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');


