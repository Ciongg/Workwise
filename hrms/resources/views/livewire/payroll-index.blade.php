<div class="p-6 bg-white shadow-md rounded-2xl">
  

    <h2 class="text-3xl font-bold mb-6 text-gray-800">Payroll List</h2>

    <!-- Current Date and Payroll Period -->
    <div class="mb-6 text-gray-700">
        <p class="text-lg">
            <strong>Today's Date:</strong> {{ \App\Services\TimeService::now()->format('F j, Y') }}
        </p>
        <p class="text-lg">
            <strong>Current Payroll Period:</strong> 
            {{ \App\Services\TimeService::now()->startOfMonth()->format('F j') }} - 
            {{ \App\Services\TimeService::now()->endOfMonth()->format('j, Y') }}
        </p>
    </div>

    <div class="flex flex-wrap gap-4 mb-6">
        <a href="{{route('hr.show-payroll-deductions')}}"
            class="bg-teal-500 text-white font-bold px-4 py-2 rounded hover:bg-yellow-600 transition">
            View Deductions
        </a>
    
        <a href="{{ route('hr.show-archived-payroll') }}"
            class="bg-gray-500 text-white font-bold px-4 py-2 rounded hover:bg-gray-600 transition">
            View Archived Payroll
        </a>
    </div>

    <div class="overflow-x-auto shadow-sm">
        <table class="min-w-full text-sm text-center text-gray-900 border border-gray-300 border-collapse overflow-hidden">
            <thead class="bg-gray-200 text-gray-900 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 border border-gray-300">ID</th>
                    <th class="px-4 py-3 border border-gray-300">Name</th>
                    <th class="px-4 py-3 border border-gray-300">Department</th>
                    <th class="px-4 py-3 border border-gray-300">Position</th>
                    <th class="px-4 py-3 border border-gray-300">Salary</th>
                    <th class="px-4 py-3 border border-gray-300">Allowance</th>
                    <th class="px-4 py-3 border border-gray-300">Overtime Pay</th>
                    <th class="px-4 py-3 border border-gray-300">Gross Pay</th>
                    <th class="px-4 py-3 border border-gray-300">Deductions</th>
                    <th class="px-4 py-3 border border-gray-300">Extra Deductions</th>
                    <th class="px-4 py-3 border border-gray-300">Net Pay</th>
                    <th class="px-4 py-3 border border-gray-300">Status</th>
                    <th class="px-4 py-3 border border-gray-300">Date</th>
                    <th class="px-4 py-3 border border-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr class="hover:bg-gray-100 text-gray-800">
                        <td class="px-4 py-3 border border-gray-300">{{ $employee->id }}</td>
                        <td class="px-4 py-3 border border-gray-300">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                        <td class="px-4 py-3 border border-gray-300">{{ $employee->workInfo->department }}</td>
                        <td class="px-4 py-3 border border-gray-300">{{ $employee->workInfo->position }}</td>
                        <td class="px-4 py-3 border border-gray-300 font-bold">₱{{ number_format($employee->workInfo->salary, 2) }}</td>
                        <td class="px-4 py-3 border border-gray-300">₱{{ number_format($employee->payrollInfo->allowance, 2) }}</td>
                        <td class="px-4 py-3 border border-gray-300">₱{{ number_format($employee->payrollInfo->overtime_pay, 2) }}</td>
                        <td class="px-4 py-3 border border-gray-300 font-bold">₱{{ number_format($employee->payrollInfo->gross_pay, 2) }}</td>
                        <td class="px-4 py-3 border border-gray-300">₱{{ number_format($employee->payrollInfo->deductions, 2) }}</td>
                        <td class="px-4 py-3 border border-gray-300">₱{{ number_format($employee->payrollInfo->additional_deductions, 2) }}</td>
                        <td class="px-4 py-3 border border-gray-300 font-bold">₱{{ number_format($employee->payrollInfo->net_pay, 2) }}</td>
                        <td class="px-4 py-3 border border-gray-300">
                            <span class="inline-block px-2 py-1 rounded text-xs font-medium 
                                {{ $employee->payrollInfo->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                    ($employee->payrollInfo->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($employee->payrollInfo->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 border border-gray-300">
                            <div class="text-center">
                                <span class="font-bold">{{ \Carbon\Carbon::parse($employee->payrollInfo->pay_period_start)->format('F') }}</span>
                                <br>
                                <span class="text-sm">{{ \Carbon\Carbon::parse($employee->payrollInfo->pay_period_start)->format('j') }} - {{ \Carbon\Carbon::parse($employee->payrollInfo->pay_period_end)->format('j, Y') }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 border border-gray-300">
                            <div class="flex justify-center">
                                <a wire:click="selectPayroll({{ $employee->id }})"
                                   class="text-teal-600 hover:underline font-bold cursor-pointer transition duration-200">
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
            <x-modal :employee="$selectedPayroll" name="view-employee-payroll" title="Employee Payroll View" :modalKey="$modalKey"/>
        @endif
    </div>

    <div class="mt-8">
        
        <livewire:set-time />

        <button wire:click="recalculateAllPayrolls"
        class="ml-6 mt-16 bg-teal-500 text-white font-bold px-4 py-2 rounded hover:bg-yellow-600 transition">
        Recalculate Payrolls
        </button>

        <button wire:click="generatePayslips"
            class="bg-teal-500 text-white font-bold px-4 py-2 rounded hover:bg-yellow-600 transition">
            Generate Payslips
        </button>

    </div>
</div>
