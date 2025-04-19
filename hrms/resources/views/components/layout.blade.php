<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <title>Workwise</title>
</head>
<body>
    <nav class="flex justify-between items-center bg-gray-200 shadow-lg p-4 text-gray">
        <div class="flex items-center gap-12">
            <div>Workwise</div>
            @guest
                <div>
                    <a href="/">Home</a>
                    <a href="/about">About</a>
                    <a href="/contact">Contact</a>
                </div>
            @endguest

            @auth
                <a href="{{ auth()->user()->role === 'hr' ? route('hr.dashboard') : route('employee.dashboard') }}">
                    Dashboard
                </a>
            @endauth
        </div>
         
        <div class="flex items-center gap-12">
            @guest
                <a href="/">Login</a>
            @endguest

            @auth
                <form action="/logout" method="POST">
                    @csrf
                    <button class="cursor-pointer" type="submit">Logout</button>
                </form>
            @endauth
        </div>
    </nav>

    <div>
        {{$slot}}
    </div>
    
    @livewireScripts
</body>
</html>

