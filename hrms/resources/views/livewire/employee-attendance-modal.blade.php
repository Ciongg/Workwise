<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold mb-4">
        {{ $attendance ? 'Edit Attendance' : 'Create Attendance' }}
    </h2>
    <form wire:submit.prevent="save">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Employee</label>
            <select wire:model.defer="employee_id" class="border rounded p-2 w-full">
                <option value="">Select Employee</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->first_name }} {{ $emp->last_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Date</label>
            <input type="date" wire:model.defer="date" class="border rounded p-2 w-full">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Time In</label>
            <input type="time" wire:model.defer="time_in" class="border rounded p-2 w-full">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Time Out</label>
            <input type="time" wire:model.defer="time_out" class="border rounded p-2 w-full">
        </div>

        @php
            $otLog = null;
            $otRequest = null;
            if(isset($attendance) && $attendance->employee) {
                $otLog = $attendance->employee->overtimeLogs()
                    ->whereDate('ot_time_in', $attendance->date)
                    ->first();
                if($otLog && $otLog->request_id) {
                    $otRequest = \App\Models\EmployeeRequest::find($otLog->request_id);
                }
            }
        @endphp

        @if($otLog)
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Overtime Time In</label>
                <input type="datetime-local"
                       wire:model.defer="ot_time_in"
                       value="{{ old('ot_time_in', $otRequest ? \Carbon\Carbon::parse($otRequest->start_time)->format('Y-m-d\TH:i') : ($otLog->ot_time_in ? \Carbon\Carbon::parse($otLog->ot_time_in)->format('Y-m-d\TH:i') : '')) }}"
                       class="border rounded p-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Overtime Time Out</label>
                <input type="datetime-local"
                       wire:model.defer="ot_time_out"
                       value="{{ old('ot_time_out', $otRequest ? \Carbon\Carbon::parse($otRequest->end_time)->format('Y-m-d\TH:i') : ($otLog->ot_time_out ? \Carbon\Carbon::parse($otLog->ot_time_out)->format('Y-m-d\TH:i') : '')) }}"
                       class="border rounded p-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Overtime Status</label>
                <select wire:model.defer="ot_status" class="border rounded p-2 w-full">
                    <option value="pending" @if($otLog->status === 'pending') selected @endif>Pending</option>
                    <option value="completed" @if($otLog->status === 'completed') selected @endif>Completed</option>
                    <option value="auto_timed_out" @if($otLog->status === 'auto_timed_out') selected @endif>Auto Timed Out</option>
                </select>
            </div>
        @endif

        <div class="mt-6 flex gap-2">
            <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">
                {{ $attendance ? 'Save Changes' : 'Create Attendance' }}
            </button>
            <button type="button" wire:click="$dispatch('close-modal')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
        </div>
    </form>
</div>
