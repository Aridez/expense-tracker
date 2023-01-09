<x-layout.auth>

    <div class="p-10">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <x-body.title>Add transaction</x-body.title>
                <x-body.description>Create a new transaction</x-body.description>
            </div>
        </div>

        <x-body.card class="mt-8">
            <form action="{{ route('transactions.store') }}" method="POST">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <x-body.card.title>
                            Basic information
                        </x-body.card.title>
                        <x-body.card.description>
                            Fill all these fields in order to register a new transaction
                        </x-body.card.description>
                    </div>

                    <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                        <x-body.form.csrf />
                        <div>
                            <x-body.form.label for="description">
                                Description
                            </x-body.form.label>
                            <x-body.form.input id="description" name="description" type="text"
                                placeholder="Briefly state the concept of this transaction" :value="old('description')" />
                        </div>
                        <div>
                            <x-body.form.label for="date">
                                Date
                            </x-body.form.label>
                            <x-body.form.input id="date" name="date" type="date"
                                value="{{ old('date') ?? \Carbon\Carbon::now()->format('Y-m-d') }}" />
                        </div>
                        <div>
                            <x-body.form.label for="amount">
                                Amount
                            </x-body.form.label>
                            <x-body.form.input-leading id="amount" name="amount" type="number" step="0.01"
                                placeholder="0.00" leading="€" :value="old('amount')" />
                        </div>

                        <div>
                            <x-body.form.label for="type">
                                Transaction type
                            </x-body.form.label>
                            <x-body.form.select id="type" name="type">
                                <x-body.form.select.option value="spending">
                                    Spending
                                </x-body.form.select.option>
                                <x-body.form.select.option value="earning">
                                    Earning
                                </x-body.form.select.option>
                            </x-body.form.select>
                        </div>
                    </div>
                    <x-body.card.hr-text />
                    <x-body.card.hr-text class="col-span-2">
                        Optional fields
                    </x-body.card.hr-text>

                    <div class="md:col-span-1">
                        <x-body.card.title>
                            Recurring transaction
                        </x-body.card.title>
                        <x-body.card.description>
                            Fill these optional fields to make the transaction recurring
                        </x-body.card.description>
                    </div>
                    <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                        <div>
                            <x-body.form.label for="periodicity_id">
                                Periodicity
                            </x-body.form.label>
                            <x-body.form.select id="periodicity_id" name="periodicity_id">
                                @foreach ($periodicities as $periodicity)
                                    <x-body.form.select.option :value="$periodicity->id">
                                        {{ $periodicity->name }}
                                    </x-body.form.select.option>
                                @endforeach
                            </x-body.form.select>
                        </div>
                        <div>
                            <x-body.form.label for="repeat_until">
                                Repeat until <x-body.card.description class="italic">(leave blank to repeat forever)
                                </x-body.card.description>
                            </x-body.form.label>
                            <x-body.form.input id="repeat_until" name="repeat_until" type="date" />
                        </div>
                        <x-body.form.button>
                            Save
                        </x-body.form.button>
                    </div>

                </div>
            </form>
        </x-body.card>

    </div>

</x-layout.auth>
