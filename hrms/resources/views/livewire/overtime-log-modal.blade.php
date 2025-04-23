<div class="p-8 bg-white rounded-2xl shadow-xl w-full max-w-md mx-auto" wire:poll.1000ms="pollTime">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Overtime Logging</h2>

    @if($request->status === 'cancelled')
        <div class="bg-red-100 text-red-700 p-4 mb-6 rounded-lg text-sm text-center">
            Overtime request was cancelled because you did not time in within the allowed window.
        </div>
    @endif

    <div class="space-y-6 text-gray-700 text-sm">
        <div class="flex justify-between">
            <span class="font-semibold">Date:</span>
            <span>{{ \Carbon\Carbon::parse($request->start_time)->format('F j, Y g:i A') }}</span>
        </div>

        <div class="flex justify-between">
            <span class="font-semibold">Requested:</span>
            <div class="text-right">
                <div>{{ \Carbon\Carbon::parse($request->start_time)->format('F j, Y g:i A') }}</div>
                <div>-</div>
                <div>{{ \Carbon\Carbon::parse($request->end_time)->format('F j, Y g:i A') }}</div>
            </div>
        </div>

        <div class="flex justify-between">
            <span class="font-semibold">Current Time:</span>
            <span>{{ $current_time ? \Carbon\Carbon::parse($current_time)->format('F j, Y g:i:s A') : now()->format('F j, Y g:i:s A') }}</span>
        </div>
    </div>

    <div class="my-8 space-y-6">
        <div class="flex flex-col items-center space-y-2">
            <span class="text-lg font-semibold text-gray-700">Time In</span>
            <div class="text-gray-900 font-medium">
                {{ $time_in ? \Carbon\Carbon::parse($time_in)->format('F j, Y g:i A') : 'Not yet' }}
            </div>
            @if(!$time_in && $request->status !== 'cancelled')
                <button 
                    wire:click="timeIn"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-2 rounded-full transition"
                >
                    Time In Now
                </button>
            @endif
        </div>

        <div class="flex flex-col items-center space-y-2">
            <span class="text-lg font-semibold text-gray-700">Time Out</span>
            <div class="text-gray-900 font-medium">
                {{ $time_out ? \Carbon\Carbon::parse($time_out)->format('F j, Y g:i A') : 'Not yet' }}
            </div>
            @if($time_in && !$time_out && $request->status !== 'auto_timed_out' && $request->status !== 'cancelled')
                <button 
                    wire:click="timeOut"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold px-6 py-2 rounded-full transition"
                >
                    Time Out Now
                </button>
            @endif
        </div>
    </div>

    <div class="flex justify-center mt-8">
        <button type="button" wire:click="$dispatch('close-modal')" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold px-6 py-2 rounded-full transition">
            Close
        </button>
    </div>
</div>
