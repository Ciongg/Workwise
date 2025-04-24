<div class="max-w-lg mx-auto bg-white mt-12 p-6 rounded-lg shadow-lg">
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-4">
        <div>
            <label for="request_type" class="block text-sm font-medium text-gray-700">Request Type</label>
            <select id="request_type" wire:model.live="request_type" class="border-gray-300 rounded-md shadow-sm w-full mt-1">
                <option value="overtime">Overtime</option>
                <option value="employee_concern">Employee Concern</option>
                <option value="leave">Leave</option>
            </select>
            @error('request_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        @if ($request_type === 'overtime')
            <div>
                <label for="overtime_reason" class="block text-sm font-medium text-gray-700">Reason</label>
                <input type="text" id="overtime_reason" wire:model="overtime_reason" class="border-gray-300 rounded-md shadow-sm w-full mt-1">
                @error('overtime_reason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="datetime-local" id="start_time" wire:model.live="start_time" class="border-gray-300 rounded-md shadow-sm w-full mt-1">
                @error('start_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                <input
                    type="datetime-local"
                    id="end_time"
                    wire:model="end_time"
                    class="border-gray-300 rounded-md shadow-sm w-full mt-1"
                    min="{{ $start_time ? \Carbon\Carbon::parse($start_time)->addMinute()->format('Y-m-d\TH:i') : '' }}"
                    @if (!$start_time) disabled @endif
                >
                <small class="text-gray-500 block mt-1">
                    Must be after start time ({{ $start_time ? \Carbon\Carbon::parse($start_time)->format('F j, Y H:i') : 'N/A' }})
                </small>
                @error('end_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

        @elseif ($request_type === 'employee_concern')
            <div>
                <label for="change_reason" class="block text-sm font-medium text-gray-700">Reason</label>
                <input type="text" id="change_reason" wire:model="change_reason" class="border-gray-300 rounded-md shadow-sm w-full mt-1">
                @error('change_reason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

        @elseif ($request_type === 'leave')
            <div>
                <label for="leave_type" class="block text-sm font-medium text-gray-700">Leave Type</label>
                <select id="leave_type" wire:model="leave_type" class="border-gray-300 rounded-md shadow-sm w-full mt-1">
                    <option value="">Select Leave Type</option>
                    <option value="vacation">Vacation</option>
                    <option value="sick">Sick</option>
                    <option value="emergency">Emergency</option>
                    <option value="maternity">Maternity</option>
                    <option value="paternity">Paternity</option>
                    <option value="bereavement">Bereavement</option>
                    <option value="official_business">Official Business</option>
                    <option value="unpaid_leave">Unpaid Leave</option>
                </select>
                @error('leave_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="leave_reason" class="block text-sm font-medium text-gray-700">Reason for Leave</label>
                <input type="text" id="leave_reason" wire:model="leave_reason" class="border-gray-300 rounded-md shadow-sm w-full mt-1">
                @error('leave_reason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" id="start_time" wire:model.live="start_time" class="border-gray-300 rounded-md shadow-sm w-full mt-1">
                @error('start_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" id="end_time" wire:model="end_time" class="border-gray-300 rounded-md shadow-sm w-full mt-1">
                @error('end_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        @endif

        <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded-md shadow hover:bg-teal-600 transition">
            Submit
        </button>
    </form>
</div>
