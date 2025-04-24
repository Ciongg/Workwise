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
    <nav x-data="{ open: false }" class="bg-teal-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="text-2xl font-bold">Workwise</div>
                    @auth
                    <a href="{{ route('employee.profile') }}" class="hover:underline font-semibold flex items-center gap-1" title="View Profile">
                        <!-- User Icon -->
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A7.5 7.5 0 0112 15.75a7.5 7.5 0 016.879 2.054M15 11.25a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Profile
                        
                    </a>
                    @endauth
                </div>
                

                <!-- Hamburger Button -->
                <div class="sm:hidden">
                    <button @click="open = !open" class="focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path x-show="!open" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="open" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden sm:flex items-center gap-6">
                    @guest
                    <a href="/" class="cursor-pointer hover:underline">Home</a>
                    <a href="{{ route('about') }}" class="cursor-pointer hover:underline">About</a>
                    <a href="{{route('show.login')}}" class="cursor-pointer hover:bg-white hover:text-black border px-6 py-2 transition">Login</a>
                    @endguest

                    @auth
                        <a href="{{ auth()->user()->role === 'hr' ? route('hr.dashboard') : route('employee.dashboard') }}" class="hover:underline font-semibold flex items-center gap-1">
                            <!-- Home Icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 4l9 5.75V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9.75z" />
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('employee.attendance') }}" class="text-blue-200 hover:text-blue-300 hover:underline font-semibold flex items-center gap-1 transition-colors">
                            <!-- Clock Icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0z"/>
                            </svg>
                            View Own Attendance
                        </a>

                       <a href="{{ route('employee.payslips') }}" class="text-blue-200 hover:text-blue-300 hover:underline font-semibold flex items-center gap-1 transition-colors">
                            <!-- Money Icon -->
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3m0-6v12m0 0H7m5 0h5M4 6h16M4 6v12m16-12v12"/>
                            </svg>
                            <span class="leading-none">View Payslips</span>
                        </a>


                        <form action="/logout" method="POST" onsubmit="return confirm('Are you sure you want to logout?')">
                            @csrf
                            <button type="submit" class="hover:underline font-semibold flex items-center gap-1 text-red-200 hover:text-red-300 cursor-pointer">
                                <!-- Logout Icon -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" class="sm:hidden flex flex-col gap-4 pb-4">
                @guest
                    <a href="/" class="hover:underline">Home</a>
                    <a href="{{ route('about') }}" class="hover:underline">About</a>
                    <a href="/" class="hover:underline font-semibold">Login</a>
                @endguest

                @auth
                    <a href="{{ auth()->user()->role === 'hr' ? route('hr.dashboard') : route('employee.dashboard') }}"
                    class="hover:underline font-semibold flex items-center gap-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 9.75L12 4l9 5.75V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9.75z"/>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('employee.attendance') }}"
                    class="text-white hover:text-blue-700 font-semibold flex items-center gap-1 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0z"/>
                        </svg>
                        View Own Attendance
                    </a>

                    <a href="{{ route('employee.payslips') }}" class="text-blue-200 hover:text-blue-300 hover:underline font-semibold flex items-center gap-1 transition-colors">
                        <!-- Money Icon -->
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3m0-6v12m0 0H7m5 0h5M4 6h16M4 6v12m16-12v12"/>
                        </svg>
                        <span class="leading-none">View Payslips</span>
                    </a>
                    
                    


                    <a
                        href="#"
                        onclick="event.preventDefault(); if (confirm('Are you sure you want to logout?')) document.getElementById('logout-form').submit();"
                        class="text-red-800 hover:text-red-900 font-semibold cursor-pointer transition-colors flex items-center gap-1"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                        </svg>
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                @endauth

            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="flex-grow p-6">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
