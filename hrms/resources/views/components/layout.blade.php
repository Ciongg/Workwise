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
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="flex justify-between items-center bg-teal-600 text-white px-8 py-4 shadow-md">
        <!-- Left side -->
        <div class="flex items-center gap-10">
            <div class="text-2xl font-bold">Workwise</div>

            @guest
                <div class="flex gap-6">
                    <a href="/" class="hover:underline">Home</a>
                    <a href="/about" class="hover:underline">About</a>
                    <a href="/contact" class="hover:underline">Contact</a>
                </div>
            @endguest

            @auth
                <a href="{{ auth()->user()->role === 'hr' ? route('hr.dashboard') : route('employee.dashboard') }}" class="hover:underline font-semibold">
                    Dashboard
                </a>
            @endauth
        </div>

        <!-- Right side -->
        <div class="flex items-center gap-6">
            @guest
                <a href="/" class="hover:underline font-semibold">Login</a>
            @endguest

            @auth
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="hover:underline font-semibold">
                        Logout
                    </button>
                </form>
            @endauth
        </div>
    </nav>

    <!-- Main content -->
    <main class="flex-grow p-6">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
