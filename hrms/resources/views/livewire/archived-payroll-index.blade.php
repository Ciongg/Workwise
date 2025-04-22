<div class="p-6 bg-white shadow-md rounded-lg">

    <div class="flex justify-between gap-8 items-center mb-4 mt-4">
        <h2 class="text-2xl font-semibold text-gray-800">Archived Payroll List</h2>
        <a href="{{ route('hr.show-payroll') }}" class="cursor-pointer py-2 px-6 bg-teal-500 hover:bg-teal-600 text-white font-bold rounded shadow">Back</a>

    </div>

    <!-- Filters -->
    <div class="mb-4 flex gap-4">
        <div>
            <label for="selectedMonth" class="block text-sm font-medium text-gray-700">Month</label>
            <select id="selectedMonth" wire:model.live="selectedMonth" class="border rounded p-2 w-full">
                <option value="">All Months</option>
                @foreach ($months as $key => $month)
                    <option value="{{ $key }}">{{ $month }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="selectedYear" class="block text-sm font-medium text-gray-700">Year</label>
            <select id="selectedYear" wire:model.live="selectedYear" class="border rounded p-2 w-full">
                <option value="">All Years</option>
                @foreach ($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="searchName" class="block text-sm font-medium text-gray-700">Search Name</label>
            <input type="text" id="searchName" wire:model.live="searchName" placeholder="Search by name" class="border rounded p-2 w-full">
        </div>
        <div>
            <label for="statusFilter" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="statusFilter" wire:model.live="statusFilter" class="border rounded p-2 w-full">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600 text-center">
                <tr>
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('id')">
                        ID
                        <span class="{{ $sortField === 'id' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'id' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('employee_name')">
                        Name
                        <span class="{{ $sortField === 'employee_name' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'employee_name' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('department')">
                        Department
                        <span class="{{ $sortField === 'department' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'department' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('position')">
                        Position
                        <span class="{{ $sortField === 'position' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'position' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('salary')">
                        Salary
                        <span class="{{ $sortField === 'salary' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'salary' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border">Allowance</th>
                    <th class="px-4 py-3 border">Overtime Pay</th>
                    <th class="px-4 py-3 border">Gross Pay</th>
                    <th class="px-4 py-3 border">Deductions</th>
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('net_pay')">
                        Net Pay
                        <span class="{{ $sortField === 'net_pay' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'net_pay' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border">Pay Period</th>
                    <th class="px-4 py-3 border">Status</th>
                    <th class="px-4 py-3 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr class="hover:bg-gray-100 transition-colors text-center">
                        <td class="px-4 py-2 border">{{ $employee->id }}</td>
                        <td class="px-4 py-2 border">{{ $employee->employee->first_name }} {{ $employee->employee->last_name }}</td>
                        <td class="px-4 py-2 border">{{ $employee->employee->workInfo->department }}</td>
                        <td class="px-4 py-2 border">{{ $employee->employee->workInfo->position }}</td>
                        <td class="px-4 py-2 border font-bold">₱{{ number_format($employee->employee->workInfo->salary, 2) }}</td>
                        <td class="px-4 py-2 border">₱{{ number_format($employee->allowance, 2) }}</td>
                        <td class="px-4 py-2 border">₱{{ number_format($employee->overtime_pay, 2) }}</td>
                        <td class="px-4 py-2 border font-bold">₱{{ number_format($employee->gross_pay, 2) }}</td>
                        <td class="px-4 py-2 border">₱{{ number_format($employee->deductions, 2) }}</td>
                        <td class="px-4 py-2 border font-bold">₱{{ number_format($employee->net_pay, 2) }}</td>
                        <td class="px-4 py-2 border">
                            {{ \Carbon\Carbon::parse($employee->pay_period_start)->format('F j, Y') }} - 
                            {{ \Carbon\Carbon::parse($employee->pay_period_end)->format('F j, Y') }}
                        </td>
                        <td class="px-4 py-2 border">
                            <span class="inline-block px-2 py-1 rounded text-sm font-medium 
                                {{ $employee->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                    ($employee->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border">
                            <a 
                                    wire:click="selectArchivedPayroll({{ $employee->id }})"
                                    
                                    class="text-teal-500 hover:underline font-bold cursor-pointer transition duration-200 ease-in-out">
                                    View/Edit
                                </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination -->
        <div class="mt-4">
            {{ $employees->links() }}
        </div>
    </div>

    @if ($selectedArchivedPayroll)
    
    <x-modal :archivedPayroll="$selectedArchivedPayroll" name="view-employee-archived-payroll" title="Employee Archived Payroll View" :modalKey="$modalKey" />
    @endif
</div>
