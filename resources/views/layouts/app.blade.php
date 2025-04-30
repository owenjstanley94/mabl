<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MABL') - Manchester Area Basketball League</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @fluxAppearance
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
    @include('components.nav')
    
    <flux:main container>
            <div class="flex-1 max-md:pt-6 self-stretch">
                @yield('content')
            </div>
        </div>
    </flux:main>
    @fluxScripts
</body>
</html> 