<x-layout.guest>

    <div class="flex min-h-full flex-col justify-center pt-6 sm:px-6 lg:px-8 pt-16">
        <x-body.card class="w-full mx-auto max-w-md mt-8 space-y-6">
            <form class="space-y-6" action="{{route('forgotten-password.update')}}" method="POST">
                @method('PUT')
                <x-body.form.csrf/>
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->token }}" hidden>
                <div>
                    <x-body.form.label for="email">Email address</x-body.form.label>
                    <x-body.form.input id="email" name="email" type="email" autocomplete="email" :value="old('email')" required />
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
                    Reset password
                </x-body.form.button>
            </form>
        </x-body.card>
    </div>
</x-layout.guest>
