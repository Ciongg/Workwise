<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet"> --}}
    @livewireStyles
    
    
    <title>Workwise</title>
</head>
<body>
    <nav class="flex justify-between items-center bg-gray-200 shadow-lg p-4 text-gray">
        <div class="flex items-center gap-12">
            <div>Workwise</div>
            @guest
                
            <div>
                <a href="/">home</a>
                <a href="/about">about</a>
                <a href="/contact">contact</a>
            </div>
            @endguest

            @auth

            <a href="/hr/dashboard">Dashboard</a>
            @endauth
        </div>
         
            <div class="flex items-center gap-12">
                <a href="/">login</a>

                @auth
                
                    <form action="/logout" method="POST">
                    @csrf
                        <button class="cursor-pointer" type="submit">logout</button>
                    </form>    

                
                @endauth
            </div>
    </nav>

    <div>
        {{$slot}}

    </div>

    {{-- @livewire('wire-elements-modal') --}}
    
    
    @livewireScripts
</body>
</html>

<script>
    
</script>