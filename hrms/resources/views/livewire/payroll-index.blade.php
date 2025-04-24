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

    <div class="flex flex-wrap gap-4 mb-4">
        <div>
            <label class="block text-xs font-semibold text-gray-600">Status</label>
            <select wire:model.live="searchStatus" class="border rounded px-2 py-1">
                <option value="">All</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="paid">Paid</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600">Department</label>
            <input type="text" wire:model.live="searchDepartment" class="border rounded px-2 py-1" placeholder="Department">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600">Name</label>
            <input type="text" wire:model.live="searchName" class="border rounded px-2 py-1" placeholder="Name">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600">Position</label>
            <input type="text" wire:model.live="searchPosition" class="border rounded px-2 py-1" placeholder="Position">
        </div>
    </div>

    <div class="flex flex-wrap gap-4 mb-6">
        <a href="{{ route('hr.show-payroll-deductions') }}"
            class="bg-teal-500 text-white font-bold px-4 py-2 rounded hover:bg-yellow-600 transition">
            View Deductions
        </a>
    
        <button wire:click="recalculateAllPayrolls"
            class="cursor-pointer bg-teal-500 text-white font-bold px-4 py-2 rounded hover:bg-yellow-600 transition">
            Recalculate Payrolls
        </button>

        <a href="{{ route('hr.show-archived-payroll') }}"
            class="bg-gray-500 text-white font-bold px-4 py-2 rounded hover:bg-gray-600 transition">
            View Archived Payroll
        </a>
    
    </div>

    <!-- Make table container scrollable on small screens -->
    <div class="overflow-x-auto">
        <table class="min-w-[1000px] text-sm text-center text-gray-900 border border-gray-300 border-collapse">
            <thead class="bg-gray-200 text-gray-900 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('id')">
                        ID
                        <span class="{{ $sortField === 'id' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'id' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border border-gray-800 cursor-pointer" wire:click="sortBy('name')">
                        Name
                        <span class="{{ $sortField === 'name' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'name' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border border-gray-800 cursor-pointer" wire:click="sortBy('department')">
                        Department
                        <span class="{{ $sortField === 'department' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'department' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border border-gray-800 cursor-pointer" wire:click="sortBy('position')">
                        Position
                        <span class="{{ $sortField === 'position' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'position' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border border-gray-800 cursor-pointer" wire:click="sortBy('salary')">
                        Salary
                        <span class="{{ $sortField === 'salary' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'salary' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border border-gray-800 cursor-pointer" wire:click="sortBy('allowance')">
                        Allowance
                        <span class="{{ $sortField === 'allowance' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'allowance' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border border-gray-800 cursor-pointer" wire:click="sortBy('overtime_pay')">
                        Overtime Pay
                        <span class="{{ $sortField === 'overtime_pay' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'overtime_pay' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border border-gray-800 cursor-pointer" wire:click="sortBy('gross_pay')">
                        Gross Pay
                        <span class="{{ $sortField === 'gross_pay' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'gross_pay' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border border-gray-800 cursor-pointer" wire:click="sortBy('deductions')">
                        Deductions
                        <span class="{{ $sortField === 'deductions' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'deductions' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border border-gray-800 cursor-pointer" wire:click="sortBy('additional_deductions')">
                        Extra Deductions
                        <span class="{{ $sortField === 'additional_deductions' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'additional_deductions' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border border-gray-800 cursor-pointer" wire:click="sortBy('net_pay')">
                        Net Pay
                        <span class="{{ $sortField === 'net_pay' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'net_pay' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border border-gray-800">Status</th>
                    <th class="px-4 py-3 border border-gray-800">Date</th>
                    <th class="px-4 py-3 border border-gray-800">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr class="hover:bg-gray-100 text-gray-800">
                        <td class="px-4 py-3 border border-gray-800">{{ $employee->id }}</td>
                        <td class="px-4 py-3 border border-gray-800">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                        <td class="px-4 py-3 border border-gray-800">{{ $employee->workInfo->department }}</td>
                        <td class="px-4 py-3 border border-gray-800">{{ $employee->workInfo->position }}</td>
                        <td class="px-4 py-3 border border-gray-800 font-bold">₱{{ number_format($employee->workInfo->salary, 2) }}</td>
                        <td class="px-4 py-3 border border-gray-800">₱{{ number_format($employee->payrollInfo->allowance, 2) }}</td>
                        <td class="px-4 py-3 border border-gray-800">₱{{ number_format($employee->payrollInfo->overtime_pay, 2) }}</td>
                        <td class="px-4 py-3 border border-gray-800 font-bold">₱{{ number_format($employee->payrollInfo->gross_pay, 2) }}</td>
                        <td class="px-4 py-3 border border-gray-800">₱{{ number_format($employee->payrollInfo->deductions, 2) }}</td>
                        <td class="px-4 py-3 border border-gray-800">₱{{ number_format($employee->payrollInfo->additional_deductions, 2) }}</td>
                        <td class="px-4 py-3 border border-gray-800 font-bold">₱{{ number_format($employee->payrollInfo->net_pay, 2) }}</td>
                        <td class="px-4 py-3 border border-gray-800">
                            <span class="inline-block px-2 py-1 rounded text-xs font-medium 
                                {{ $employee->payrollInfo->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                    ($employee->payrollInfo->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($employee->payrollInfo->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 border border-gray-800">
                            <div class="text-center">
                                <span class="font-bold">{{ \Carbon\Carbon::parse($employee->payrollInfo->pay_period_start)->format('F') }}</span>
                                <br>
                                <span class="text-sm">{{ \Carbon\Carbon::parse($employee->payrollInfo->pay_period_start)->format('j') }} - {{ \Carbon\Carbon::parse($employee->payrollInfo->pay_period_end)->format('j, Y') }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 border border-gray-800">
                            <div class="flex justify-center">
                                <a wire:click="selectPayroll({{ $employee->id }})"
                                   class="text-teal-500 hover:underline font-bold cursor-pointer transition duration-200">
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

        <div class="mt-8">
            <livewire:set-time />
          
            <button wire:click="generatePayslips"
                class="cursor-pointer ml-6 mt-6 bg-teal-500 text-white font-bold px-4 py-2 rounded hover:bg-yellow-600 transition">
                Generate Payslips Manually
            </button>
        </div>

        @if ($selectedPayroll)
            <x-modal :employee="$selectedPayroll" name="view-employee-payroll" title="Employee Payroll View" :modalKey="$modalKey"/>
        @endif
    </div>
</div>
