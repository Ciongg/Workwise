<div class="p-6 bg-white shadow-md rounded-lg">
    <div class="mt-8">
        <livewire:set-time />
    </div>

    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Payroll List</h2>

    <!-- Current Date and Payroll Period -->
    <div class="mb-4 text-gray-700">
        <p class="text-lg">
            <strong>Today's Date:</strong> {{ \App\Services\TimeService::now()->format('F j, Y') }}
        </p>
        <p class="text-lg">
            <strong>Current Payroll Period:</strong> 
            {{ \App\Services\TimeService::now()->startOfMonth()->format('F j') }} - 
            {{ \App\Services\TimeService::now()->endOfMonth()->format('j, Y') }}
        </p>
    </div>

    <a href="{{route('hr.show-payroll-deductions')}}" class="text-teal-500 font-bold hover:underline mb-4 inline-block">Deductions</a>
    <div class="mb-4">
        <button wire:click="recalculateAllPayrolls"
            class="bg-teal-500 cursor-pointer text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
            Recalculate Payrolls
        </button>
    </div>

    <div class="mb-4 flex justify-between">
        <button wire:click="generatePayslips"
            class="bg-teal-500 cursor-pointer text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
            Generate Payslips
        </button>
        <a href="{{ route('hr.show-archived-payroll') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
            View Archived Payroll
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600 text-center">
                <tr>
                    <th class="px-4 py-3 border">ID</th>
                    <th class="px-4 py-3 border">Name</th>
                    <th class="px-4 py-3 border">Department</th>
                    <th class="px-4 py-3 border">Position</th>
                    <th class="px-4 py-3 border">Salary</th>
                    <th class="px-4 py-3 border">Allowance</th>
                    <th class="px-4 py-3 border">Overtime Pay</th>
                    <th class="px-4 py-3 border">Gross Pay</th>
                    <th class="px-4 py-3 border">Deductions</th>
                    <th class="px-4 py-3 border">Extra Deductions</th>
                    <th class="px-4 py-3 border">Net Pay</th>
                    <th class="px-4 py-3 border">Status</th>
                    <th class="px-6 py-3 border">Date</th>
                    <th class="px-4 py-3 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr class="hover:bg-gray-100 transition-colors text-center">
                        <td class="px-4 py-3 border">{{ $employee->id }}</td>
                        <td class="px-4 py-3 border">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                        <td class="px-4 py-3 border">{{ $employee->workInfo->department }}</td>
                        <td class="px-4 py-3 border">{{ $employee->workInfo->position }}</td>
                        <td class="px-4 py-3 border font-bold">₱{{ number_format($employee->workInfo->salary, 2) }}</td>
                        <td class="px-4 py-3 border">₱{{ number_format($employee->payrollInfo->allowance, 2) }}</td>
                        <td class="px-4 py-3 border">₱{{ number_format($employee->payrollInfo->overtime_pay, 2) }}</td>
                        <td class="px-4 py-3 border font-bold">₱{{ number_format($employee->payrollInfo->gross_pay, 2) }}</td>
                        <td class="px-4 py-3 border">₱{{ number_format($employee->payrollInfo->deductions, 2) }}</td>
                        <td class="px-4 py-3 border">₱{{ number_format($employee->payrollInfo->additional_deductions, 2) }}</td>
                        <td class="px-4 py-3 border font-bold">₱{{ number_format($employee->payrollInfo->net_pay, 2) }}</td>
                        <td class="px-4 py-3 border">
                            <span class="inline-block px-2 py-1 rounded text-sm font-medium 
                                {{ $employee->payrollInfo->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                    ($employee->payrollInfo->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($employee->payrollInfo->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 border">
                            <div class="text-center">
                                <span class="font-bold">{{ \Carbon\Carbon::parse($employee->payrollInfo->pay_period_start)->format('F') }}</span>
                                <span class="text-sm">{{ \Carbon\Carbon::parse($employee->payrollInfo->pay_period_start)->format('j') }} - {{ \Carbon\Carbon::parse($employee->payrollInfo->pay_period_end)->format('j, Y') }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 border">
                            <div class="flex flex-col gap-2 justify-center">
                                <a 
                                    wire:click="selectPayroll({{ $employee->id }})"
                                  
                                    class="text-teal-500 hover:underline font-bold cursor-pointer transition duration-200 ease-in-out">
                                    View/Edit
                                </a>
                                
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="py-3">
            {{ $employees->links() }}
        </div>

        @if ($selectedPayroll)
        
        <x-modal :employee="$selectedPayroll" name="view-employee-payroll" title="Employee Payroll View"  :modalKey="$modalKey"/>
        @endif
    </div>
</div>


