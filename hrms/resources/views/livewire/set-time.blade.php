<div class="p-6 bg-gray-100 rounded shadow-md">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Set Custom Time</h2>

    @if (session()->has('successTimeSet'))
        <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
            {{ session('successTimeSet') }}
        </div>
    @endif

    <form wire:submit.prevent="setTime" class="mb-4">
        <label for="custom_time" class="block text-sm font-medium text-gray-700">Custom Time:</label>
        <input type="datetime-local" id="custom_time" wire:model.live="custom_time" class="border rounded p-2 w-full mb-4">
        @error('custom_time') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

        <button type="submit" class="cursor-pointer bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">Set Time</button>
    </form>

    <button wire:click="resetTime" class="cursor-pointer bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mb-2">Reset to System Time</button>
    <button wire:click="simulateNewDay" class="cursor-pointer bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Simulate New Day for Attendance</button>
</div>
