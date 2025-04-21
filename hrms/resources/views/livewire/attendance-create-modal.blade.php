<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold mb-4">Create Attendance</h2>
    <form wire:submit.prevent="save">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Employee ID</label>
            <input type="number" wire:model.live="employee_id" class="border rounded p-2 w-full">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Employee Name</label>
            <input type="text" value="{{ $employee_name }}" class="border rounded p-2 w-full bg-gray-100" disabled>
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

        {{-- Overtime Fields --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Overtime Request ID</label>
            <input type="number" wire:model.live="request_id" class="border rounded p-2 w-full">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Overtime Time In</label>
            <input type="datetime-local" wire:model.defer="ot_time_in" class="border rounded p-2 w-full" @if($request_id) readonly @endif>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Overtime Time Out</label>
            <input type="datetime-local" wire:model.defer="ot_time_out" class="border rounded p-2 w-full" @if($request_id) readonly @endif>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Overtime Status</label>
            <select wire:model.defer="ot_status" class="border rounded p-2 w-full">
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="auto_timed_out">Auto Timed Out</option>
            </select>
        </div>

        <div class="mt-6 flex gap-2">
            <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">
                Create Attendance
            </button>
            <button type="button" wire:click="$dispatch('close-modal')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
        </div>
    </form>
</div>
