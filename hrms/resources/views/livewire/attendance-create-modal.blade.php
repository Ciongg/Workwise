<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold mb-4">Create Attendance</h2>

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

    <form wire:submit.prevent="save">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Employee ID</label>
            <input type="number" wire:model.live="employee_id" class="border rounded p-2 w-full">
            @error('employee_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Employee Name</label>
            <input type="text" value="{{ $employee_name }}" class="border rounded p-2 w-full bg-gray-100" disabled>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Date</label>
            <input type="date" wire:model.defer="date" class="border rounded p-2 w-full">
            @error('date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Time In</label>
            <input type="time" wire:model.defer="time_in" class="border rounded p-2 w-full">
            @error('time_in') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Time Out</label>
            <input type="time" wire:model.defer="time_out" class="border rounded p-2 w-full">
            @error('time_out') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Overtime Fields --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Overtime Request ID</label>
            <input type="number" wire:model.live="request_id" class="border rounded p-2 w-full">
            @error('request_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Overtime Time In</label>
            <input type="time"
                   wire:model.defer="ot_time_in"
                   value="{{ $ot_time_in ? \Carbon\Carbon::parse($ot_time_in)->format('H:i') : '' }}"
                   class="border rounded p-2 w-full"
                   @if($request_id) readonly @endif>
            @error('ot_time_in') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Overtime Time Out</label>
            <input type="time"
                   wire:model.defer="ot_time_out"
                   value="{{ $ot_time_out ? \Carbon\Carbon::parse($ot_time_out)->format('H:i') : '' }}"
                   class="border rounded p-2 w-full"
                   @if($request_id) readonly @endif>
            @error('ot_time_out') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Overtime Status</label>
            <select wire:model.defer="ot_status" class="border rounded p-2 w-full">
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="auto_timed_out">Auto Timed Out</option>
            </select>
            @error('ot_status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mt-6 flex gap-2">
            <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">
                Create Attendance
            </button>
            <button type="button" wire:click="$dispatch('close-modal')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
        </div>
    </form>
</div>
