<div class="p-4">
    <h1 class="text-xl mb-4">Employee Requests</h1>

    <div class="flex flex-wrap gap-4 mb-4">
        <!-- Created At Filter -->
        <div>
            <label class="block text-xs font-semibold text-gray-600">Created At</label>
            <input type="date" wire:model.live="filter_created_at" class="border rounded px-2 py-1">
        </div>
        <!-- Request Type Filter -->
        <div>
            <label class="block text-xs font-semibold text-gray-600">Request Type</label>
            <select wire:model.live="filter_request_type" class="border rounded px-2 py-1">
                <option value="">All</option>
                <option value="overtime">Overtime</option>
                <option value="employee_concern">Employee Concern</option>
                <option value="leave">Leave</option>
                <!-- Add more types as needed -->
            </select>
        </div>
        <!-- Status Filter -->
        <div>
            <label class="block text-xs font-semibold text-gray-600">Status</label>
            <select wire:model.live="filter_status" class="border rounded px-2 py-1">
                <option value="">All</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="completed">Completed</option>
                <option value="auto_timed_out">Auto Timed Out</option>
            </select>
        </div>
    </div>

    @if ($requests->isEmpty())
        <p>No requests yet.</p>
    @else
    <table class="w-full table-auto text-center">
        <thead class="bg-gray-100">
            <tr>
                <th class="whitespace-nowrap py-3 px-6 text-center border cursor-pointer" wire:click="sortBy('id')">
                    Request ID
                    <span class="{{ $sortField === 'id' ? 'text-black' : 'text-gray-400' }}">
                        {{ $sortField === 'id' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                    </span>
                </th>
                <th class="whitespace-nowrap py-3 px-6 text-center border cursor-pointer" wire:click="sortBy('employee_id')">
                    Employee ID
                    <span class="{{ $sortField === 'employee_id' ? 'text-black' : 'text-gray-400' }}">
                        {{ $sortField === 'employee_id' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                    </span>
                </th>
                <th class="whitespace-nowrap py-3 px-6 text-center border cursor-pointer" wire:click="sortBy('employee_name')">
                    Employee Name
                    <span class="{{ $sortField === 'employee_name' ? 'text-black' : 'text-gray-400' }}">
                        {{ $sortField === 'employee_name' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                    </span>
                </th>
                <th class="whitespace-nowrap py-3 px-6 text-center border">Request Type</th>
                <th class="whitespace-nowrap py-3 px-6 text-center border">Reason</th>
                <th class="whitespace-nowrap py-3 px-6 text-center border cursor-pointer" wire:click="sortBy('start_time')">
                    Start Time
                    <span class="{{ $sortField === 'start_time' ? 'text-black' : 'text-gray-400' }}">
                        {{ $sortField === 'start_time' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                    </span>
                </th>
                <th class="whitespace-nowrap py-3 px-6 text-center border cursor-pointer" wire:click="sortBy('end_time')">
                    End Time
                    <span class="{{ $sortField === 'end_time' ? 'text-black' : 'text-gray-400' }}">
                        {{ $sortField === 'end_time' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                    </span>
                </th>
                <th class="whitespace-nowrap py-3 px-6 text-center border cursor-pointer" wire:click="sortBy('status')">
                    Status
                    <span class="{{ $sortField === 'status' ? 'text-black' : 'text-gray-400' }}">
                        {{ $sortField === 'status' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                    </span>
                </th>
                <th class="whitespace-nowrap py-3 px-6 text-center border cursor-pointer" wire:click="sortBy('created_at')">
                    Created At
                    <span class="{{ $sortField === 'created_at' ? 'text-black' : 'text-gray-400' }}">
                        {{ $sortField === 'created_at' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                    </span>
                </th>
                <th class="whitespace-nowrap py-3 px-6 text-center border">Actions</th>
            </tr>
        </thead>
    
            <tbody>
                @foreach ($requests as $request)
                    <tr>
                        <!-- Employee ID -->
                        <td class="border p-2">{{ $request->id}}</td>
                        
                        <td class="border p-2">{{ $request->employee->id}}</td>
                        <!-- Employee Name -->
                        <td class="border p-2">{{ $request->employee->first_name }} {{ $request->employee->last_name }}</td>

                        <!-- Request Type -->
                        <td class="border p-2">
                            @if($request->request_type === 'leave')
                            {{ \Illuminate\Support\Str::title($request->request_type) }} - {{ \Illuminate\Support\Str::title($request->reason) }}
                        @else
                            {{ \Illuminate\Support\Str::title($request->request_type) }}
                        @endif
                        </td>

                        <!-- Reason -->
                        <td class="border p-2">
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


                        <!-- Start Time -->
                        <td class="border p-2">
                            {{ \Carbon\Carbon::parse($request->start_time)->format('Y, F g:i A') }}
                        </td>

                        <!-- End Time -->
                        <td class="border p-2">
                            {{ \Carbon\Carbon::parse($request->end_time)->format('Y, F g:i A') }}
                        </td>

                        <!-- Status -->
                        <td class="border p-2">
                            <span class="px-2 py-1 rounded text-white 
                                {{ 
                                    $request->status === 'pending' ? 'bg-yellow-500' : 
                                    ($request->status === 'approved' ? 'bg-blue-500' : 
                                    ($request->status === 'completed' ? 'bg-green-500' : 
                                    ($request->status === 'auto_timed_out' ? 'bg-red-500' : 'bg-gray-400')))
                                }}">
                                {{ $request->status === 'auto_timed_out' ? 'Auto Timed Out' : ucfirst($request->status) }}
                            </span>
                        </td>   

                        <!-- Created At -->
                        <td class="border p-2">
                            {{ \Carbon\Carbon::parse($request->created_at)->format('Y, F j, g:i A') }}
                        </td>

                        <!-- Actions -->
                        <td class="border p-2">
                            <a 
                                wire:click="selectRequest({{ $request->id }})"
                                class="text-teal-500 hover:underline font-bold cursor-pointer transition duration-200 ease-in-out">
                                View/Edit
                            </a>
                           
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ($selectedRequest)
        <x-modal name="view-employee-request" :request="$selectedRequest" title="Employee Request View" :modalKey="$modalKey" />
    @endif

    {{ $requests->links() }}


</div>

