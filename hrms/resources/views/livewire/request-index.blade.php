<div class="p-4">
    <h1 class="text-xl mb-4">Employee Requests</h1>

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




</div>

