<x-layout.guest>
    <div class="flex min-h-full flex-col justify-center pt-6 sm:px-6 lg:px-8 pt-16">
        <x-body.title>
            Sign in
        </x-body.title>

        <x-body.card class="w-full mx-auto max-w-md mt-8">
            <form method="POST" action="{{ route('sessions.store') }}" class="space-y-6">
                <x-body.form.csrf />
                <div>
                    <x-body.form.label for="email">Email address</x-body.form.label>
                    <x-body.form.input id="email" name="email" type="email" autocomplete="email" :value="old('email')" required />
                </div>
                <div>
                    <x-body.form.label for="password">Password</x-body.form.label>
                    <x-body.form.input id="password" name="password" type="password" autocomplete="current-password" required />
                </div>
                <div>
                    <x-body.form.checkbox id="remember_me" name="remember" />
                    <x-body.form.label for="remember_me">Remember me</x-body.form.label>
                </div>
                <x-body.form.button>
                    Sign in
                </x-body.form.button>
                <x-body.card.hr-text>
                    <x-body.card.link :href="route('forgotten-password.create')">
                        Forgot password?
                    </x-body.card.link>
                </x-body.card.hr-text>
            </form>
        </x-body.card>
    </div>
</x-layout.guest>