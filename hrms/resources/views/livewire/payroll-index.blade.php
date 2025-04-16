<div class="p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Payroll List</h2>
    <a href="{{route('hr.show-payroll-deductions')}} " class="color-teal-500 font-bold hover:underline">Deductions</a>
    <div class="mb-4">
        <button wire:click="recalculateAllPayrolls"
            class="bg-teal-500 cursor-pointer text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
            Recalculate Payrolls
        </button>
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
                    <th class="px-4 py-3 border ">Allowance</th>
                    <th class="px-4 py-3 border ">Overtime Pay</th>
                    <th class="px-4 py-3 border ">Gross Pay</th>
                    <th class="px-4 py-3 border ">Deductions</th>
                    <th class="px-4 py-3 border ">Extra Deductions</th>
                    <th class="px-4 py-3 border ">Net Pay</th>
                    <th class="px-4 py-3 border ">Status</th>
                    <th class="px-4 py-3 border ">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr class="hover:bg-gray-100 transition-colors text-center">
                        <td class="px-4 py-2 border">{{$employee->id}}</td>
                        <td class="px-4 py-2 border">{{$employee->first_name}} {{$employee->last_name}}</td>
                        <td class="px-4 py-2 border">{{$employee->workInfo->department}}</td>
                        <td class="px-4 py-2 border">{{$employee->workInfo->position}}</td>
                        <td class="px-4 py-2 border font-bold">₱{{ number_format($employee->workInfo->salary, 2) }}</td>
                        <td class="px-4 py-2 border ">₱{{ number_format($employee->payrollInfo->allowance, 2) }}</td>
                        <td class="px-4 py-2 border ">₱{{ number_format($employee->payrollInfo->overtime_pay, 2) }}</td>
                        <td class="px-4 py-2 border font-bold">₱{{ number_format($employee->payrollInfo->gross_pay, 2) }}</td>
                        <td class="px-4 py-2 border ">₱{{ number_format($employee->payrollInfo->deductions, 2) }}</td>
                        <td class="px-4 py-2 border ">₱{{ number_format($employee->payrollInfo->additional_deductions, 2) }}</td>
                        <td class="px-4 py-2 border  font-bold">₱{{ number_format($employee->payrollInfo->net_pay, 2) }}</td>
                        <td class="px-4 py-2 border ">
                            <span class="inline-block px-2 py-1 rounded text-sm font-medium 
                                {{ $employee->payrollInfo->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                    ($employee->payrollInfo->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($employee->payrollInfo->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border">
                            {{-- <button wire:click="selectPayroll({{ $employee->id }})"
                                class="p-2 px-3 bg-teal-500 text-white rounded cursor-pointer hover:bg-teal-600 transition duration-200 ease-in-out">
                            View/Edit
                        </button> --}}

                        <a 
                            wire:click="selectPayroll({{ $employee->id }})"
                            x-data 
                            x-on:click="$dispatch('open-modal', {name: 'view-employee-payroll'})"
                            class="text-teal-500 hover:underline font-bold cursor-pointer transition duration-200 ease-in-out">
                            View/Edit
                        </a>


                        {{-- <button 
                        wire:click="selectPayroll({{ $employee->id }})" 
                        x-data 
                        x-on:click="$dispatch('open-modal', {name: 'view-employee-payroll'})"
                        class="p-2 max-w-fit bg-teal-500 text-white rounded cursor-pointer hover:bg-teal-600 transition duration-200 ease-in-out">
                        View/Edit
                    </button> --}}

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
