<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Models\PayrollDeductionSetting;
use App\Models\Payroll;
class HRController extends Controller
{
    use WithPagination;
    public function dashboard(){
        return view('hr.dashboard');
    }
    public function create(){
        return view('hr.create-employee');
    }

    public function showPayroll(){
        return view('hr.show-payroll');
    }

    public function showArchivedPayroll(){
        return view('hr.show-archived-payroll');
    }
    
    public function index(){
        
        return view('hr.index');
    }
    
    public function showRequests(){
        return view('hr.show-request');
    }

    public function showAttendance(){
        return view('hr.show-attendance');
    }


    public function showPayrollDeductions()
    {
        $settings = PayrollDeductionSetting::first();
        return view('hr.deductions.edit', compact('settings'));
    }

    public function updatePayrollDeductions(Request $request)
    {
        $validated = $request->validate([
            'sss_rate' => 'required|numeric|min:0',
            'philhealth_rate' => 'required|numeric|min:0',
            'pagibig_fixed' => 'required|numeric|min:0',
            'withholding_tax_rate' => 'required|numeric|min:0',
        ]);
    
        $settings = PayrollDeductionSetting::first(); // or create a fallback
    
        $settings->update([
            'sss_rate' => $validated['sss_rate'] / 100,
            'philhealth_rate' => $validated['philhealth_rate'] / 100,
            'pagibig_fixed' => $validated['pagibig_fixed'],
            'withholding_tax_rate' => $validated['withholding_tax_rate'] / 100,
        ]);

        
        Payroll::chunk(100, function ($payrolls) {
            foreach ($payrolls as $payroll) {
                $payroll->recalculateDeductions();
            }
        });
        
    
        return redirect()->back()->with('success', 'Payroll deductions updated successfully!');
    }

   

 
}
