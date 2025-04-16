<div class="p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Payroll List</h2>
    <a href="{{route('hr.show-payroll-deductions')}} " class="color-blue font-bold hover:underline">Deductions</a>
    <div class="mb-4">
        <button wire:click="recalculateAllPayrolls"
            class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
            Recalculate Payrolls
        </button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                <tr>
                    <th class="px-4 py-3 border">ID</th>
                    <th class="px-4 py-3 border">Name</th>
                    <th class="px-4 py-3 border">Department</th>
                    <th class="px-4 py-3 border">Position</th>
                    <th class="px-4 py-3 border text-right">Allowance</th>
                    <th class="px-4 py-3 border text-right">Overtime Pay</th>
                    <th class="px-4 py-3 border text-right">Gross Pay</th>
                    <th class="px-4 py-3 border text-right">Deductions</th>
                    <th class="px-4 py-3 border text-right">Net Pay</th>
                    <th class="px-4 py-3 border text-center">Status</th>
                    <th class="px-4 py-3 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-2 border">{{$employee->id}}</td>
                        <td class="px-4 py-2 border">{{$employee->first_name}} {{$employee->last_name}}</td>
                        <td class="px-4 py-2 border">{{$employee->workInfo->department}}</td>
                        <td class="px-4 py-2 border">{{$employee->workInfo->position}}</td>
                        <td class="px-4 py-2 border text-right">₱{{ number_format($employee->payrollInfo->allowance, 2) }}</td>
                        <td class="px-4 py-2 border text-right">₱{{ number_format($employee->payrollInfo->overtime_pay, 2) }}</td>
                        <td class="px-4 py-2 border text-right font-semibold">₱{{ number_format($employee->payrollInfo->gross_pay, 2) }}</td>
                        <td class="px-4 py-2 border text-right">₱{{ number_format($employee->payrollInfo->deductions, 2) }}</td>
                        <td class="px-4 py-2 border text-right font-semibold">₱{{ number_format($employee->payrollInfo->net_pay, 2) }}</td>
                        <td class="px-4 py-2 border text-center">
                            <span class="inline-block px-2 py-1 rounded text-xs font-medium 
                                {{ $employee->payrollInfo->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                    ($employee->payrollInfo->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($employee->payrollInfo->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border text-center">
                            <button class="text-blue-600 hover:underline text-sm">View</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="py-3">
        {{ $employees->links() }}
    </div>
</div>
