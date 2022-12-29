<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">


    <x-nav>
        <x-slot:left>
            <x-nav.button :href="route('home')">
                Home
            </x-nav.button>
            <x-nav.button :href="route('accounts.create')">
                Register
            </x-nav.button>
            <x-nav.button :href="route('sessions.create')">
                Log in
            </x-nav.button>
        </x-slot:left>
    </x-nav>

    <x-body class="pt-16">
        <x-body.errors />
        <x-body.success />
        {{ $slot }}
    </x-body>
</body>

</html>
