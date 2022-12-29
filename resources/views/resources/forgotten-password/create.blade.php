<x-layout.guest>

    <div class="flex min-h-full flex-col justify-center pt-6 sm:px-6 lg:px-8 pt-16">

        <x-body.card class="w-full mx-auto max-w-md mt-8 space-y-6">
            <x-body.description>
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </x-body.description>
            <form method="POST" action="{{ route('forgotten-password.store') }}" class="space-y-6">
                <x-body.form.csrf />
                <div>
                    <x-body.form.label for="email">Email address</x-body.form.label>
                    <x-body.form.input id="email" name="email" type="email" autocomplete="email" :value="old('email')" required />
                </div>
                <x-body.form.button>
                    Email reset link
                </x-body.form.button>
            </form>
        </x-body.card>
    </div>
</x-layout.guest>