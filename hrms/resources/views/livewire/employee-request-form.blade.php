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
                <option value="profile_change">Profile Change</option>
            </select>
        </div>

        @if ($request_type === 'overtime')
            <div>
                <label for="overtime_reason" class="block text-sm font-medium text-gray-700">Reason</label>
                <input type="text" id="overtime_reason" wire:model="overtime_reason" class="border-gray-300 rounded-md shadow-sm w-full mt-1">
            </div>

            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="datetime-local" id="start_time" wire:model.live="start_time" class="border-gray-300 rounded-md shadow-sm w-full mt-1">
            </div>

            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                <input
                    type="datetime-local"
                    id="end_time"
                    wire:model="end_time"
                    class="border-gray-300 rounded-md shadow-sm w-full mt-1"
                    min="{{ $start_time ? \Carbon\Carbon::parse($start_time)->addMinute()->format('Y-m-d\TH:i') : '' }}"
                    placeholder="End time will auto-fill"
                    @if (!$start_time) disabled @endif
                >
                <small class="text-gray-500 block mt-1">
                    Must be after start time ({{ $start_time ? \Carbon\Carbon::parse($start_time)->format('F Y') : 'N/A' }})
                </small>
            </div>
        @elseif ($request_type === 'profile_change')
            <div>
                <label for="change_reason" class="block text-sm font-medium text-gray-700">Reason</label>
                <input type="text" id="change_reason" wire:model="change_reason" class="border-gray-300 rounded-md shadow-sm w-full mt-1">
            </div>
        @endif

        <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded-md shadow hover:bg-teal-600 transition">
            Submit
        </button>
    </form>
</div>
