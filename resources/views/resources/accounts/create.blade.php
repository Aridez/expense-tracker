<x-layout.guest>
    <div class="flex min-h-full flex-col justify-center pt-6 sm:px-6 lg:px-8 pt-16">
        <x-body.title class="text-center">
            Register a new account
        </x-body.title>

        <x-body.card class="w-full mx-auto max-w-md mt-8">
            <form method="POST" action="{{ route('accounts.store') }}" class="space-y-6">
                <x-body.form.csrf />
                <div>
                    <x-body.form.label for="name">Name</x-body.form.label>
                    <x-body.form.input id="name" name="name" type="text" autocomplete="name" :value="old('name')"
                        required />
                </div>
                <div>
                    <x-body.form.label for="email">Email address</x-body.form.label>
                    <x-body.form.input id="email" name="email" type="email" autocomplete="email" :value="old('email')"
                        required />
                </div>
                <div>
                    <x-body.form.label for="password">Password</x-body.form.label>
                    <x-body.form.input id="password" name="password" type="password" required />
                </div>
                <div>
                    <x-body.form.label for="password_confirmation">Confirm password</x-body.form.label>
                    <x-body.form.input id="password_confirmation" name="password_confirmation" type="password"
                        required />
                </div>
                <x-body.form.button>
                    Register
                </x-body.form.button>
                <x-body.card.hr-text>
                    Already registered?
                    <x-body.card.link href="#">
                        Sign in
                    </x-body.card.link>
                </x-body.card.hr-text>
            </form>
        </x-body.card>
    </div>
</x-layout.guest>
