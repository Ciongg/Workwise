<div class="p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">My Request Logs</h2>

    <!-- Filters -->
    <div class="mb-4 flex gap-4">
        <div>
            <label for="searchType" class="block text-sm font-medium text-gray-700">Request Type</label>
            <select id="searchType" wire:model.live="searchType" class="border rounded p-2 w-full">
                <option value="">All Types</option>
                <option value="overtime">Overtime</option>
                <option value="profile_change">Profile Change</option>
            </select>
        </div>
        <div>
            <label for="searchStatus" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="searchStatus" wire:model.live="searchStatus" class="border rounded p-2 w-full">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
    </div>

    <!-- Request Logs Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600 text-center">
                <tr>
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('request_type')">
                        Request Type
                        <span class="{{ $sortField === 'request_type' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortDirection === 'asc' ? '▲' : '▼' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border">Reason</th>
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('start_time')">
                        Start Time
                        <span class="{{ $sortField === 'start_time' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortDirection === 'asc' ? '▲' : '▼' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('end_time')">
                        End Time
                        <span class="{{ $sortField === 'end_time' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortDirection === 'asc' ? '▲' : '▼' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('status')">
                        Status
                        <span class="{{ $sortField === 'status' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortDirection === 'asc' ? '▲' : '▼' }}
                        </span>
                    </th>
                    
                    <th class="px-4 py-3 border cursor-pointer">
                        Actions
        
                    </th>
                    
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $request)
                    <tr class="hover:bg-gray-100 transition-colors text-center">
                        <td class="px-4 py-2 border">{{ ucfirst($request->request_type) }}</td>
                        <td class="px-4 py-2 border">{{ $request->reason }}</td>
                        <td class="px-4 py-2 border">
                            {{ $request->start_time ? \Carbon\Carbon::parse($request->start_time)->format('Y, F g:i A') : 'N/A' }}
                        </td>
                        <td class="px-4 py-2 border">
                            {{ $request->end_time ? \Carbon\Carbon::parse($request->end_time)->format('Y, F g:i A') : 'N/A' }}
                        </td>
                        <td class="px-4 py-2 border">
                            <span class="px-2 py-1 rounded text-white 
                                {{ 
                                    $request->status === 'pending' ? 'bg-yellow-500' : 
                                    ($request->status === 'approved' ? 'bg-green-500' : 'bg-red-500')
                                }}">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>

                        <td class="px-4 py-2 border">
                            @if(
                                $request->request_type === 'overtime' && 
                                $request->status === 'approved'
                            )
                                <button  
                                    wire:click="openOvertimeLog({{ $request->id }})"
                                    x-data 
                                    x-on:click="$dispatch('open-modal', {name: 'overtime-log'})"
                                    class="cursor-pointer ml-2 bg-blue-500 text-white px-3 py-2 rounded text-xs hover:bg-blue-600"
                                >
                                    Overtime Time In/Out
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-600">No requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($showOvertimeLogModal)
    
    <x-modal name="overtime-log" title="Log Overtime" :modalKey="$modalKey" :request="$selectedOvertimeRequest" />
    @endif

    <!-- Pagination -->
    <div class="mt-4">
        {{ $requests->links() }}
    </div>
</div>
