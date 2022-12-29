<x-layout.auth class="px-8 pt-24">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <x-body.subtitle> Personal information </x-body.subtitle>
            <x-body.description> Update your personal information and platform preferences </x-body.description>
        </div>
        <div class="mt-5 md:col-span-2 md:mt-0">
            <x-body.card>
                <form class="space-y-6" action="{{ route('accounts.update') }}" method="POST" >
                    <x-body.form.csrf />
                    @method('PUT')
                    <div>
                        <x-body.form.label for="name"> Name </x-body.form.label>
                        <x-body.form.input id="name" name="name" type="text" autocomplete="name" :value="$user->name" />
                    </div>
                    <x-body.form.button> Save </x-body.form.button>

                </form>
            </x-body.card>
        </div>
    </div>
</x-layout.auth>