<div wire:poll.1000ms>

    @if(session('custom_time'))
    <div class="bg-yellow-100 text-yellow-800 p-2 mb-4 rounded">
        <strong>Custom Time Active:</strong>
        {{ \Carbon\Carbon::parse(session('custom_time'))->format('F j, Y h:i:s A') }}
        <br>
        <span class="text-xs">Click "Reset to System Time" to return to the real time.</span>
    </div>
    @endif

    <div class="p-6 bg-gray-100 rounded shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Time In/Out</h2>

        @if ($status)
            <div class="bg-blue-100 text-blue-800 p-2 mb-4 rounded">
                {{ $status }}
            </div>
        @endif

        @if (session()->has('successTimeRegister'))
            <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
                {{ session('successTimeRegister') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <p class="text-lg text-gray-700">
            <strong>Current Date:</strong> {{ \App\Services\TimeService::now()->format('F j, Y') }}
        </p>
        <p class="text-lg text-gray-700">
            <strong>Current Time:</strong> {{ \App\Services\TimeService::now()->format('h:i:s A') }}
        </p>

        <div class="mt-4 flex gap-2">
            <button 
                wire:click="timeIn" 
                class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600"
                @if(!$can_time_in) disabled style="opacity:0.5;cursor:not-allowed;" @endif
            >
                Time In
            </button>
            <button 
                wire:click="timeOut" 
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                @if(!$can_time_out) disabled style="opacity:0.5;cursor:not-allowed;" @endif
            >
                Time Out
            </button>
          
        </div>

        <div class="mt-4">
            <p>
                <strong>Time In:</strong>
                {{ $time_in ? \Carbon\Carbon::createFromFormat('H:i:s', $time_in)->format('h:i A') : 'Not yet recorded' }}
            </p>
            <p>
                <strong>Time Out:</strong>
                {{ $time_out ? \Carbon\Carbon::createFromFormat('H:i:s', $time_out)->format('h:i A') : 'Not yet recorded' }}
            </p>
        </div>
    </div>
</div>
