{{-- <div class="p-4" wire:poll.1000ms="pollTime">
    <h2 class="text-lg font-bold mb-2">Log Overtime</h2>
    @if($request->status === 'cancelled')
        <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">
            Overtime request was cancelled because you did not time in within the allowed window.
        </div>
    @endif
    <div class="mb-2">
        <strong>Date:</strong>
        {{ \Carbon\Carbon::parse($request->start_time)->format('F j, Y g:i A') }}
        <br>
        <strong>Requested:</strong>
        {{ \Carbon\Carbon::parse($request->start_time)->format('F j, Y g:i A') }}
        -
        {{ \Carbon\Carbon::parse($request->end_time)->format('F j, Y g:i A') }}
    </div>
    <div class="mb-2">
        <strong>Current Time:</strong>
        {{ $current_time ? \Carbon\Carbon::parse($current_time)->format('F j, Y g:i:s A') : now()->format('F j, Y g:i:s A') }}
    </div>
    <div class="mb-2">
        <strong>Time In:</strong>
        {{ $time_in ? \Carbon\Carbon::parse($time_in)->format('F j, Y g:i A') : 'Not yet' }}
        @if(!$time_in && $request->status !== 'cancelled')
            <button 
                wire:click="timeIn" 
                class="ml-2 bg-teal-500 text-white px-2 py-1 rounded"
                @if(!$this->canTimeIn) disabled style="opacity:0.5;cursor:not-allowed;" @endif
            >
                Time In
            </button>
            @if(!$this->canTimeIn)
                <span class="text-xs text-gray-500 ml-2">You can only time in within 5 minutes before or 10 minutes after the scheduled start.</span>
            @endif
        @endif
    </div>
    <div class="mb-2">
        <strong>Time Out:</strong>
        {{ $time_out ? \Carbon\Carbon::parse($time_out)->format('F j, Y g:i A') : 'Not yet' }}
        @if($time_in && !$time_out && $request->status !== 'auto_timed_out' && $request->status !== 'cancelled')
            <button wire:click="timeOut" class="ml-2 bg-gray-500 text-white px-2 py-1 rounded">Time Out</button>
        @endif
    </div>
    <button type="button" wire:click="$dispatch('close-modal')" class="mt-4 bg-gray-400 text-white px-4 py-2 rounded">Close</button>
</div> --}}


<div class="p-4" wire:poll.1000ms="pollTime">
    <h2 class="text-lg font-bold mb-2">Log Overtime</h2>

    @if($request->status === 'cancelled')
        <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">
            Overtime request was cancelled because you did not time in within the allowed window.
        </div>
    @endif

    <div class="mb-2">
        <strong>Date:</strong>
        {{ \Carbon\Carbon::parse($request->start_time)->format('F j, Y g:i A') }}
        <br>
        <strong>Requested:</strong>
        {{ \Carbon\Carbon::parse($request->start_time)->format('F j, Y g:i A') }}
        -
        {{ \Carbon\Carbon::parse($request->end_time)->format('F j, Y g:i A') }}
    </div>

    <div class="mb-2">
        <strong>Current Time:</strong>
        {{ $current_time ? \Carbon\Carbon::parse($current_time)->format('F j, Y g:i:s A') : now()->format('F j, Y g:i:s A') }}
    </div>

    <div class="mb-2">
        <strong>Time In:</strong>
        {{ $time_in ? \Carbon\Carbon::parse($time_in)->format('F j, Y g:i A') : 'Not yet' }}
        @if(!$time_in && $request->status !== 'cancelled')
            <button 
                wire:click="timeIn" 
                class="ml-2 bg-teal-500 text-white px-2 py-1 rounded"
            >
                Time In
            </button>
        @endif
    </div>

    <div class="mb-2">
        <strong>Time Out:</strong>
        {{ $time_out ? \Carbon\Carbon::parse($time_out)->format('F j, Y g:i A') : 'Not yet' }}
        @if($time_in && !$time_out && $request->status !== 'auto_timed_out' && $request->status !== 'cancelled')
            <button 
                wire:click="timeOut" 
                class="ml-2 bg-gray-500 text-white px-2 py-1 rounded"
            >
                Time Out
            </button>
        @endif
    </div>

    <button type="button" wire:click="$dispatch('close-modal')" class="mt-4 bg-gray-400 text-white px-4 py-2 rounded">
        Close
    </button>
</div>
