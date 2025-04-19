<div>
    <form wire:submit.prevent="submit">

        
        
        <div class="mb-4">
            <label for="request_type" class="block mb-2">Request Type</label>
            <select id="request_type" wire:model.live="request_type" class="border p-2 w-full">
                <option value="overtime">Overtime</option>
                <option value="profile_change">Profile Change</option>
            </select>
        </div>

        @if ($request_type === 'overtime')

            <div class="mb-4">
                <label for="overtime_reason" class="block mb-2">Reason</label>
                <input type="text" id="overtime_reason" wire:model="overtime_reason" class="border p-2 w-full">
            </div>
    
            <div class="mb-4">
                <label for="start_time" class="block mb-2">Start Time</label>
                <input type="datetime-local" id="start_time" wire:model="start_time" class="border p-2 w-full">
            </div>
    
            <div class="mb-4">
                <label for="end_time" class="block mb-2">End Time</label>
                <input type="datetime-local" id="end_time" wire:model="end_time" class="border p-2 w-full">
            </div>
        @elseif ($request_type === 'profile_change')
            <div class="mb-4">
                <label for="change_reason" class="block mb-2">Reason</label>
                <input type="text" id="change_reason" wire:model="change_reason" class="border p-2 w-full">
            </div>
        

        @endif

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            Submit
        </button>
    </form>
</div>
