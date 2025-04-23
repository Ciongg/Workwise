<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold mb-4">Request Details</h2>

    <form wire:submit.prevent="save">
        <!-- Employee Name -->
        <div class="mb-4">
            <label for="employeeName" class="block text-sm font-medium text-gray-700">Employee Name</label>
            <input type="text" id="employeeName" value="{{ $request->employee->first_name }} {{ $request->employee->last_name }}" class="border rounded p-2 w-full bg-gray-100" disabled>
        </div>

        <!-- Request Type -->
        <div class="mb-4">
            <label for="requestType" class="block text-sm font-medium text-gray-700">Request Type</label>
            <input type="text" id="requestType" value="{{ ucfirst($request->request_type) }}" class="border rounded p-2 w-full bg-gray-100" disabled>
        </div>

        <!-- Reason -->
        <div class="mb-4">
            <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
            <textarea id="reason" wire:model="reason" class="border rounded p-2 w-full bg-gray-100" disabled></textarea>
            @error('reason') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Start Time -->
        @if ($request->request_type === 'overtime')
            <div class="mb-4">
                <label for="startTime" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="datetime-local" id="startTime" wire:model="startTime" class="border rounded p-2 w-full">
                @error('startTime') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- End Time -->
            <div class="mb-4">
                <label for="endTime" class="block text-sm font-medium text-gray-700">End Time</label>
                <input type="datetime-local" id="endTime" wire:model="endTime" class="border rounded p-2 w-full">
                @error('endTime') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        @endif

        <!-- Status -->
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="status" wire:model="status" class="border rounded p-2 w-full">
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="completed">Completed</option>
                <option value="auto_timed_out">Auto Timed Out</option>
                <option value="cancelled">Cancelled</option>
            </select>
            @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Save Button -->
        <div class="mt-6">
            <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">Save</button>
            <button type="button" wire:click="$dispatch('close-modal')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
        </div>
    </form>
</div>