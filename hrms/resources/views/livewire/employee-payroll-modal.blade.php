<div class="flex justify-center mb-6 space-x-4">
    @if(session('success'))
    <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
        
        <div class="flex justify-center mb-6 space-x-4">
            <button 
                wire:click="$set('activeTab', 'payroll')" 
                class="w-40 px-4 py-2 rounded-lg font-medium text-white {{ $activeTab === 'payroll' ? 'bg-teal-600' : 'bg-gray-400' }}">
                Payroll
            </button>
            <button 
                wire:click="$set('activeTab', 'overtime')" 
                class="w-40 px-4 py-2 rounded-lg font-medium text-white {{ $activeTab === 'overtime' ? 'bg-teal-600' : 'bg-gray-400' }}">
                Overtime
            </button>
            <button 
                wire:click="$set('activeTab', 'info')" 
                class="w-40 px-4 py-2 rounded-lg font-medium text-white {{ $activeTab === 'info' ? 'bg-teal-600' : 'bg-gray-400' }}">
                Information
            </button>
        </div>

    @if ($activeTab === 'payroll')
    <h3 class="text-lg font-semibold text-teal-500 mb-4">Payroll Information</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
        <div>
            <label for="pay_period_start" class="block text-sm font-medium text-gray-700">Pay Period Start:</label>
            <input disabled type="date" id="pay_period_start" wire:model.defer="pay_period_start" class=" cursor-not-allowed mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="pay_period_end" class="block text-sm font-medium text-gray-700">Pay Period End:</label>
            <input disabled type="date" id="pay_period_end" wire:model.defer="pay_period_end" class="cursor-not-allowed mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="salary" class="block text-sm font-medium text-gray-700">Basic Salary:</label>
            <input type="number" id="salary" wire:model.defer="salary" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="allowance" class="block text-sm font-medium text-gray-700">Allowance:</label>
            <input type="number" id="allowance" wire:model.defer="allowance" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="overtime_pay" class="block text-sm font-medium text-gray-700">Overtime Pay:</label>
            <input type="number" id="overtime_pay" wire:model.defer="overtime_pay" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="gross_pay" class="block text-sm font-medium text-gray-700">Gross Pay:</label>
            <input type="number" id="gross_pay" wire:model.defer="gross_pay" disabled class="cursor-not-allowed mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
            <label for="gross_pay" class="block text-[0.8rem] font-medium text-gray-700">(Basic Salary + Allowance + Overtime Pay):</label>
        </div>
        <div>
            <label for="deductions" class="block text-sm font-medium text-gray-700">Deductions:</label>
            <input type="number" id="deductions" wire:model.defer="deductions" disabled class="cursor-not-allowed mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
            <label for="deductions" class="block text-[0.8rem] font-medium text-gray-700">(Mandated SSS + PhilHealth + PagIBIG + Withholding Tax + Extra Deductions):</label>
        </div>

        <div>
            <label for="additional_deductions" class="block text-sm font-medium text-gray-700">Additional Deductions:</label>
            <input type="number" id="additional_deductions" wire:model.defer="additional_deductions" class=" mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="net_pay" class="block text-sm font-medium text-gray-700">Net Pay:</label>
            <input type="number" id="net_pay" wire:model.defer="net_pay" disabled class="cursor-not-allowed mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
            <select id="status" wire:model.defer="status" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
            </select>
        </div>
    </div>

    <div class="mt-6">
        <button wire:click="save" class="w-full sm:w-auto py-2 px-6 bg-teal-500 text-white font-semibold rounded-md shadow-md hover:bg-teal-600 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50">
            Save Changes
        </button>

        
    </div>
@endif


@if ($activeTab === 'info')

<!-- Contact Info -->
    <h2 class="text-2xl font-semibold mb-4">Contact Information</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
            <input type="email" id="email" wire:model.defer="email" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number:</label>
            <input type="text" id="phone_number" wire:model.defer="phone_number" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
    </div>

    <!-- Work Info -->
    <h3 class="text-lg font-semibold text-teal-500 mt-8 mb-2">Work Information</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
        <div>
            <label for="department" class="block text-sm font-medium text-gray-700">Department:</label>
            <input type="text" id="department" wire:model.defer="department" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="position" class="block text-sm font-medium text-gray-700">Position:</label>
            <input type="text" id="position" wire:model.defer="position" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100  border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="salary" class="block text-sm font-medium text-gray-700">Salary:</label>
            <input type="number" id="salary" wire:model.defer="salary" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="work_status" class="block text-sm font-medium text-gray-700">Work Status:</label>
            <select id="work_status" wire:model.defer="work_status" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                <option value="full_time">Full-Time</option>
                <option value="part_time">Part-Time</option>
                <option value="contract">Contract</option>
            </select>
        </div>
        <div>
            <label for="hire_date" class="block text-sm font-medium text-gray-700">Hire Date:</label>
            <input type="date" id="hire_date" wire:model.defer="hire_date" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
    </div>

    <!-- Bank Info -->
    <h3 class="text-lg font-semibold text-teal-500 mt-8 mb-2">Bank Information</h3>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
        <div>
            <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name:</label>
            <input type="text" id="bank_name" wire:model.defer="bank_name" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="account_number" class="block text-sm font-medium text-gray-700">Account Number:</label>
            <input type="text" id="account_number" wire:model.defer="account_number" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="account_type" class="block text-sm font-medium text-gray-700">Account Type:</label>
            <select id="account_type" wire:model.defer="account_type" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                <option value="savings">Savings</option>
                <option value="checking">Checking</option>
            </select>
        </div>
    </div>

    <!-- Identification Info -->
    <h3 class="text-lg font-semibold text-teal-500 mt-8 mb-2">Identification Numbers</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
            <label for="sss_number" class="block text-sm font-medium text-gray-700">SSS Number:</label>
            <input type="text" id="sss_number" wire:model.defer="sss_number" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="pag_ibig_number" class="block text-sm font-medium text-gray-700">Pag-IBIG Number:</label>
            <input type="text" id="pag_ibig_number" wire:model.defer="pag_ibig_number" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="philhealth_number" class="block text-sm font-medium text-gray-700">PhilHealth Number:</label>
            <input type="text" id="philhealth_number" wire:model.defer="philhealth_number" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="tin_number" class="block text-sm font-medium text-gray-700">TIN Number:</label>
            <input type="text" id="tin_number" wire:model.defer="tin_number" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100 border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
    </div>
@endif

@if ($activeTab === 'overtime')
    <h3 class="text-lg font-semibold text-teal-500 mb-4">Overtime Logs</h3>
    <div class="mb-4">
        <strong>Total Overtime Hours:</strong> {{ number_format($totalOvertimeHours, 2) }} hrs<br>
        <strong>Total Overtime Pay:</strong> ₱{{ number_format($totalOvertimePay, 2) }}<br>
        <strong>Total Normal Hours:</strong> {{ number_format($totalNormalHours, 2) }} hrs
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600 text-center">
                <tr>
                    <th class="px-4 py-3 border">Date</th>
                    <th class="px-4 py-3 border">Time In</th>
                    <th class="px-4 py-3 border">Time Out</th>
                    <th class="px-4 py-3 border">Hours</th>
                    <th class="px-4 py-3 border">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($overtimeLogs as $log)
                    <tr>
                        <td class="px-4 py-2 border">{{ $log->ot_time_in ? \Carbon\Carbon::parse($log->ot_time_in)->format('F j, Y') : '-' }}</td>
                        <td class="px-4 py-2 border">{{ $log->ot_time_in ? \Carbon\Carbon::parse($log->ot_time_in)->format('g:i A') : '-' }}</td>
                        <td class="px-4 py-2 border">{{ $log->ot_time_out ? \Carbon\Carbon::parse($log->ot_time_out)->format('g:i A') : '-' }}</td>
                        <td class="px-4 py-2 border">{{ number_format($log->total_hours, 2) }}</td>
                        <td class="px-4 py-2 border">{{ ucfirst($log->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500">No overtime logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endif

</div>
