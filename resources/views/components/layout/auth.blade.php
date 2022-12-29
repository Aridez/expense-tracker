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
            <x-nav.button :href="route('dashboard')">
                Dashboard
            </x-nav.button>
            <x-nav.button>
                Transactions
            </x-nav.button>
            <x-nav.button>
                Budgets
            </x-nav.button>
            <x-nav.button>
                Tags
            </x-nav.button>
        </x-slot:left>
        <x-slot:right>
            <x-nav.dropdown>
                <i class="fa-solid fa-user"></i> {{ auth()->user()->name }} <i class="fa-solid fa-caret-down"></i>
                <x-slot:items>
                    <x-nav.dropdown.item :href="route('accounts.edit')">
                        <i class="fa-solid fa-gear"></i> Settings
                    </x-nav.dropdown.item>
                    <form method="POST" action="{{ route('sessions.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <x-nav.dropdown.item :href="route('sessions.destroy')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fa-solid fa-right-from-bracket"></i> {{ __('Log out') }}
                        </x-nav.dropdown.item>
                    </form>
                </x-slot:items>
            </x-nav.dropdown>
        </x-slot:right>
    </x-nav>

    <x-body {{ $attributes->merge(['class' => 'pt-16']) }}>
        <x-body.errors />
        <x-body.success />
        {{ $slot }}
    </x-body>
</body>

</html>
