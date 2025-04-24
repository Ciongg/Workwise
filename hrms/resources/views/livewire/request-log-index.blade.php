<div class="p-6 bg-white shadow-md rounded-lg flex flex-col min-h-[80vh]">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">My Request Logs</h2>

    <!-- Filters Section -->
    <div class="mb-4 flex flex-wrap gap-4">
        
        <!-- Employee ID Filter -->
        <div class="w-full sm:w-auto flex-1 min-w-[150px]">
            <label for="employeeIdFilter" class="block text-sm font-medium text-gray-700">Employee ID</label>
            <input type="text" id="employeeIdFilter" wire:model.live="employeeIdFilter" class="border rounded p-2 w-full" placeholder="Employee ID">
        </div>

        <!-- Request Type Filter -->
        <div class="w-full sm:w-auto flex-1 min-w-[150px]">
            <label for="searchType" class="block text-sm font-medium text-gray-700">Request Type</label>
            <select id="searchType" wire:model.live="searchType" class="border rounded p-2 w-full">
                <option value="">All Types</option>
                <option value="overtime">Overtime</option>
                <option value="employee_concern">Employee Concern</option>
                <option value="leave">Leave</option>
            </select>
        </div>

        <!-- Request Status Filter -->
        <div class="w-full sm:w-auto flex-1 min-w-[150px]">
            <label for="searchStatus" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="searchStatus" wire:model.live="searchStatus" class="border rounded p-2 w-full">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="completed">Completed</option>
                <option value="auto_timed_out">Auto Timed Out</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <!-- Start Period Filter -->
        <div class="w-full sm:w-auto flex-1 min-w-[150px]">
            <label for="startPeriod" class="block text-sm font-medium text-gray-700">Start Period</label>
            <input type="date" id="startPeriod" wire:model.live="startPeriod" class="border rounded p-2 w-full" />
        </div>
    </div>

    <!-- Request Logs Table -->
    <div class="overflow-x-auto flex-1">
        <div class="overflow-y-auto max-h-[400px] border border-gray-300 rounded">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase text-gray-600 text-center sticky top-0 z-10">
                <tr>
                    <!-- Employee ID Column -->
                    <th class="px-4 py-3 border cursor-pointer whitespace-nowrap" wire:click="sortBy('employee_id')">
                        Employee ID
                        <span class="{{ $sortField === 'employee_id' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'employee_id' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>

                    <!-- Employee Name Column -->
                    <th class="px-4 py-3 border cursor-pointer whitespace-nowrap" wire:click="sortBy('employee_name')">
                        Employee Name
                        <span class="{{ $sortField === 'employee_name' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'employee_name' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>

                    <!-- Request Type Column -->
                    <th class="px-4 py-3 border cursor-pointer whitespace-nowrap" wire:click="sortBy('request_type')">
                        Request Type
                        <span class="{{ $sortField === 'request_type' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'request_type' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>

                    <!-- Reason Column -->
                    <th class="px-4 py-3 border whitespace-nowrap">Reason</th>

                    <!-- Start Time Column -->
                    <th class="px-4 py-3 border cursor-pointer whitespace-nowrap" wire:click="sortBy('start_time')">
                        Start Time
                        <span class="{{ $sortField === 'start_time' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'start_time' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>

                    <!-- End Time Column -->
                    <th class="px-4 py-3 border cursor-pointer whitespace-nowrap" wire:click="sortBy('end_time')">
                        End Time
                        <span class="{{ $sortField === 'end_time' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'end_time' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>

                    <!-- Status Column -->
                    <th class="px-4 py-3 border cursor-pointer whitespace-nowrap" wire:click="sortBy('status')">
                        Status
                        <span class="{{ $sortField === 'status' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'status' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>

                    <!-- Actions Column -->
                    <th class="px-4 py-3 border whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $request)
                    <tr class="hover:bg-gray-100 transition-colors text-center">
                        <!-- Employee ID Row -->
                        <td class="px-4 py-2 border whitespace-nowrap">{{ $request->employee->id }}</td>

                        <!-- Employee Name Row -->
                        <td class="px-4 py-2 border whitespace-nowrap">{{ $request->employee->first_name }} {{ $request->employee->last_name }}</td>

            
                        <!-- Request Type Row -->
                        <td class="px-4 py-2 border whitespace-nowrap">
                            @if($request->request_type === 'leave')
                                {{ \Illuminate\Support\Str::title($request->request_type) }} - {{ \Illuminate\Support\Str::title($request->reason) }}
                            @else
                                {{ \Illuminate\Support\Str::title($request->request_type) }}
                            @endif
                        </td>


                        <!-- Reason Row -->
                        <td class="px-4 py-2 border max-w-xs text-left">
                            <div x-data="{ expanded: false }" class="inline">
                                @php
                                    $displayReason = $request->request_type === 'leave' ? $request->leave_reason : $request->reason;
                                @endphp
                        
                                @if(strlen($displayReason) > 50)
                                    <span>
                                        <span x-show="!expanded" x-cloak>
                                            {{ Str::limit($displayReason, 50) }}...
                                            <button 
                                                @click="expanded = true" 
                                                class="text-teal-600 text-xs font-medium ml-1 hover:underline focus:outline-none"
                                            >
                                                Show More
                                            </button>
                                        </span>
                                        <span x-show="expanded" x-cloak>
                                            {{ $displayReason }}
                                            <button 
                                                @click="expanded = false" 
                                                class="text-teal-600 text-xs font-medium ml-1 hover:underline focus:outline-none"
                                            >
                                                Show Less
                                            </button>
                                        </span>
                                    </span>
                                @else
                                    {{ $displayReason }}
                                @endif
                            </div>
                        </td>
                        
                        
                        <!-- Start Time Row -->
                        <td class="px-4 py-2 border whitespace-nowrap">
                            {{ $request->start_time ? \Carbon\Carbon::parse($request->start_time)->format('Y, F j, g:i A') : 'N/A' }}
                        </td>

                        <!-- End Time Row -->
                        <td class="px-4 py-2 border whitespace-nowrap">
                            {{ $request->end_time ? \Carbon\Carbon::parse($request->end_time)->format('Y, F j, g:i A') : 'N/A' }}
                        </td>

                        <!-- Status Row -->
                        <td class="px-4 py-2 border whitespace-nowrap">
                            <span class="px-2 py-1 rounded text-white whitespace-nowrap
                                @if($request->status === 'approved')
                                    bg-blue-500
                                @elseif($request->status === 'pending')
                                    bg-yellow-500
                                @elseif($request->status === 'completed')
                                    bg-green-500
                                @elseif($request->status === 'auto_timed_out')
                                    bg-red-500
                                @else
                                    bg-gray-400
                                @endif
                            ">
                                {{ $request->status === 'auto_timed_out' ? 'Auto Timed Out' : ucfirst($request->status) }}
                            </span>
                        </td>

                        <!-- Actions Row -->
                        <td class="px-4 py-2 border whitespace-nowrap">
                            @if(
                                $request->request_type === 'overtime' && 
                                $request->status === 'approved'
                            )
                                <button  
                                    wire:click="openOvertimeLog({{ $request->id }})"
                                    x-data 
                                    x-on:click="$dispatch('open-modal', {name: 'overtime-log'})"
                                    class="cursor-pointer ml-2 bg-blue-500 text-white px-3 py-2 rounded text-xs hover:bg-blue-600 whitespace-nowrap"
                                >
                                    Overtime Time In/Out
                                </button>
                            @endif

                            @if(in_array($request->status, ['rejected', 'cancelled', 'pending']))
                                <button
                                    wire:click="deleteRequest({{ $request->id }})"
                                    class="cursor-pointer ml-2 bg-red-500 text-white px-3 py-2 rounded text-xs hover:bg-red-600 whitespace-nowrap"
                                    onclick="return confirm('Are you sure you want to delete this request?')"
                                >
                                    Delete
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-2 text-center text-gray-600">No requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>

    <!-- Overtime Log Modal -->
    @if ($showOvertimeLogModal)
        <x-modal name="overtime-log" title="Log Overtime" :modalKey="$modalKey" :request="$selectedOvertimeRequest" />
    @endif

    <!-- Pagination Section -->
    <div class="mt-4">
        {{ $requests->links() }}
    </div>

    <div>
        <livewire:set-time />

    </div>

</div>
