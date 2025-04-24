{{-- filepath: c:\Users\sharp\OneDrive\Desktop\Workwise\hrms\resources\views\livewire\attendance-index.blade.php --}}
<div class="p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Attendance Records</h2>

    <div class="flex flex-wrap gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Employee Name</label>
            <input type="text" wire:model.live="searchEmployeeName" placeholder="Search by name" class="border rounded p-2 w-full">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Employee ID</label>
            <input type="text" wire:model.live="searchEmployeeId" placeholder="Search by ID" class="border rounded p-2 w-full">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Date</label>
            <input type="date" wire:model.live="searchDate" class="border rounded p-2 w-full">
        </div>
    </div>

    <a 
        wire:click="openCreateAttendance"
        x-data
        x-on:click="$dispatch('open-modal', {name: 'create-attendance'})"
        class="text-teal-500 hover:underline font-bold cursor-pointer transition duration-200 ease-in-out">
        Create Attendance
    </a>

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
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('employee_id')">
                        Employee ID
                        <span class="{{ $sortField === 'employee_id' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'employee_id' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('employee_id')">
                        Employee Name
                        <span class="{{ $sortField === 'employee_id' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'employee_id' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('date')">
                        Date
                        <span class="{{ $sortField === 'date' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'date' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('time_in')">
                        Time In
                        <span class="{{ $sortField === 'time_in' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'time_in' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('time_out')">
                        Time Out
                        <span class="{{ $sortField === 'time_out' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'time_out' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border">Attendance Status</th>
                    <th class="px-4 py-3 border">Overtime In</th>
                    <th class="px-4 py-3 border">Overtime Out</th>
                    <th class="px-4 py-3 border">Overtime Status</th>
                    <th class="px-4 py-3 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    <tr class="hover:bg-gray-100 transition-colors text-center">
                        <td class="px-4 py-2 border">{{ $attendance->id }}</td>

                        <td class="px-4 py-2 border">{{ $attendance->employee_id }}</td>

                        <td class="px-4 py-2 border">
                            {{ $attendance->employee->first_name ?? '' }} {{ $attendance->employee->last_name ?? '' }}
                        </td>

                        <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($attendance->date)->format('F j, Y') }}</td>
                        <td class="px-4 py-2 border">
                            {{ $attendance->time_in ? \Carbon\Carbon::createFromFormat('H:i:s', $attendance->time_in)->format('h:i A') : '-' }}
                        </td>
                        <td class="px-4 py-2 border">
                            {{ $attendance->time_out ? \Carbon\Carbon::createFromFormat('H:i:s', $attendance->time_out)->format('h:i A') : '-' }}
                        </td>
                        <td class="px-4 py-2 border">
                            <span class="px-2 py-1 rounded text-white
                                @if($attendance->status === 'completed')
                                    bg-blue-500
                                @elseif($attendance->status === 'auto_timed_out')
                                    bg-red-500
                                @elseif($attendance->status === 'pending')
                                    bg-yellow-500
                                @endif
                            ">
                                {{ $attendance->status === 'auto_timed_out' ? 'Auto Timed Out' : ucfirst($attendance->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border">
                            @php
                                $otLog = $attendance->employee->overtimeLogs()
                                    ->whereDate('ot_time_in', $attendance->date)
                                    ->first();
                            @endphp
                            {{ $otLog && $otLog->ot_time_in ? \Carbon\Carbon::parse($otLog->ot_time_in)->format('h:i A') : '-' }}
                        </td>
                        <td class="px-4 py-2 border">
                            {{ $otLog && $otLog->ot_time_out ? \Carbon\Carbon::parse($otLog->ot_time_out)->format('h:i A') : '-' }}
                        </td>
                        <td class="px-4 py-2 border">
                            <span class="px-2 py-1 rounded 
                                @if($otLog && $otLog->status === 'completed')
                                    text-white bg-blue-500
                                @elseif($otLog && $otLog->status === 'pending')
                                    text-white bg-gray-400
                                @elseif($otLog && $otLog->status === 'auto_timed_out')
                                    text-white bg-red-500
                                @elseif(!$otLog || !$otLog->status)
                                    text-black bg-transparent
                                @endif
                            ">
                                {{ $otLog && $otLog->status ? ucfirst($otLog->status) : '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border">
                            <a 
                                wire:click="selectAttendance({{ $attendance->id }})"
                                class="text-teal-500 hover:underline font-bold cursor-pointer transition duration-200 ease-in-out"
                            >
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="py-3">
            {{ $attendances->links() }}
        </div>
    
        @if ($selectedAttendance)
            <x-modal :attendance="$selectedAttendance" name="view-attendance" title="Attendance View" :modalKey="$modalKey"/>
        @endif
    
        @if ($showCreateAttendance)
            <x-modal name="create-attendance" title="Create Attendance View" :modalKey="$createModalKey"/>
        @endif
    </div>
    
</div>
