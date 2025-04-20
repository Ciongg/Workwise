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
        <div class="mt-6 flex gap-2">
            <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">
                {{ $attendance ? 'Save Changes' : 'Create Attendance' }}
            </button>
            <button type="button" wire:click="$dispatch('close-modal')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
        </div>
    </form>
</div>
