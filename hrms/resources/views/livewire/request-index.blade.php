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
                <option value="profile_change">Profile Change</option>
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
        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th class="border p-2">Request ID</th>
                    <th class="border p-2">Employee ID</th>
                    <th class="border p-2">Employee Name</th>
                    <th class="border p-2">Type</th>
                    <th class="border p-2">Reason</th>
                    <th class="border p-2">Start Time</th>
                    <th class="border p-2">End Time</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Created At</th>
                    <th class="border p-2">Actions</th>
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
                        <td class="border p-2">{{ ucfirst($request->request_type) }}</td>

                        <!-- Reason -->
                        <td class="border p-2">{{ $request->reason }}</td>

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

