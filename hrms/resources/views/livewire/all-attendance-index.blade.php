<div class="p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">My Attendance Records</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600 text-center">
                <tr>
                    <th class="px-4 py-3 border cursor-pointer" wire:click="sortBy('date')">
                        Date
                        <span class="{{ $sortField === 'date' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'date' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="px-4 py-3 border">Time In</th>
                    <th class="px-4 py-3 border">Time Out</th>
                    <th class="px-4 py-3 border">Attendance Status</th>
                    <th class="px-4 py-3 border">Overtime In</th>
                    <th class="px-4 py-3 border">Overtime Out</th>
                    <th class="px-4 py-3 border">Overtime Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                
                    @php
                        $otLog = $attendance->employee
                            ? $attendance->employee->overtimeLogs()->whereDate('ot_time_in', $attendance->date)->first()
                            : null;
                    @endphp
                    <tr class="hover:bg-gray-100 transition-colors text-center">
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
                            {{ $otLog && $otLog->ot_time_in ? \Carbon\Carbon::parse($otLog->ot_time_in)->format('h:i A') : '-' }}
                        </td>
                        <td class="px-4 py-2 border">
                            {{ $otLog && $otLog->ot_time_out ? \Carbon\Carbon::parse($otLog->ot_time_out)->format('h:i A') : '-' }}
                        </td>

                        <td class="px-4 py-2 border">
                            @if($otLog)
                                <span class="px-2 py-1 rounded text-white
                                    @if($otLog->status === 'completed')
                                        bg-blue-500
                                    @elseif($otLog->status === 'auto_timed_out')
                                        bg-red-500
                                    @elseif($otLog->status === 'pending')
                                        bg-yellow-500
                                    @else
                                        bg-gray-400
                                    @endif
                                ">
                                    {{ $otLog->status === 'auto_timed_out' ? 'Auto Timed Out' : ucfirst($otLog->status) }}
                                </span>
                            @else
                                <span class="px-2 py-1 rounded bg-gray-300 text-gray-700">No Overtime</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="py-3">
            {{ $attendances->links() }}
        </div>
    </div>
</div>
