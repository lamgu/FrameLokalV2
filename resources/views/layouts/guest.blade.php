<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FrameLokal') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'DM Sans', sans-serif; }
        </style>
    </head>
    <body class="text-gray-100 antialiased bg-[#0a0a0a] min-h-screen flex flex-col items-center justify-center relative">
        <!-- Logo -->
        <div class="absolute top-8 left-8 flex items-center gap-3">
            <div class="w-10 h-10 bg-[#f5c518] rounded-xl flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-movie text-black" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                    <path d="M8 4l0 16" />
                    <path d="M16 4l0 16" />
                    <path d="M4 8l4 0" />
                    <path d="M4 16l4 0" />
                    <path d="M4 12l16 0" />
                    <path d="M16 8l4 0" />
                    <path d="M16 16l4 0" />
                </svg>
            </div>
            <div>
                <div class="font-bold text-2xl tracking-widest text-[#f5c518]" style="font-family: 'Bebas Neue', sans-serif;">Frame-Lokal</div>
            </div>
        </div>

        <!-- Content -->
        <div class="w-full sm:max-w-md bg-[#111111] border border-white/[0.07] sm:p-10 p-8 rounded-2xl shadow-xl z-10 mt-20 sm:mt-0">
            {{ $slot }}
        </div>
    </body>
</html>
