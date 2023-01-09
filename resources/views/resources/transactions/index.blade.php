<x-layout.auth>

    <div class="p-10">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <x-body.title>Transactions</x-body.title>
                <x-body.description>View, create and manage your transactions</x-body.description>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <x-body.button :href="route('transactions.create')">Add transaction</x-body.button>
            </div>
        </div>

        <x-table class="mt-8">
            <x-table.head>
                <x-table.row>
                    <x-table.head.cell>
                        Description
                    </x-table.head.cell>
                    <x-table.head.cell>
                        Date
                    </x-table.head.cell>
                    <x-table.head.cell colspan="3">
                        Amount
                    </x-table.head.cell>
                </x-table.row>
            </x-table.head>
            <x-table.body>
                <x-table.header-row class="bg-gray-50">
                    <x-table.body.header-cell colspan="5">
                        Latest transactions
                    </x-table.body.header-cell>
                </x-table.header-row>
                @foreach ($transactions as $transaction)
                    <x-table.row>
                        <x-table.body.cell>
                            {{ $transaction->description }}
                        </x-table.body.cell>
                        <x-table.body.cell>
                            {{ $transaction->date }}
                        </x-table.body.cell>
                        <x-table.body.cell colspan="3">
                            {{ $transaction->amount }} €
                        </x-table.body.cell>
                    </x-table.row>
                @endforeach
                <x-table.header-row>
                    <x-table.body.header-cell colspan="3">
                        Coming up
                    </x-table.body.header-cell>
                    <x-table.body.header-cell>
                        Periodicity
                    </x-table.body.header-cell>
                    <x-table.body.header-cell>
                        Repeats until
                    </x-table.body.header-cell>
                </x-table.header-row>
                @foreach ($upcomingTransactions as $upcomingTransaction)
                    <x-table.row>
                        <x-table.body.cell>
                            {{ $upcomingTransaction->description }}
                        </x-table.body.cell>
                        <x-table.body.cell>
                            {{ $upcomingTransaction->date }}
                        </x-table.body.cell>
                        <x-table.body.cell>
                            {{ $upcomingTransaction->amount }} €
                        </x-table.body.cell>
                        <x-table.body.cell>
                            {{ $upcomingTransaction->periodicity?->name }}
                        </x-table.body.cell>
                        <x-table.body.cell>
                            {{ $upcomingTransaction->repeat_until ? 'until' . $upcomingTransaction->repeat_until : 'indefinitely' }}
                        </x-table.body.cell>
                    </x-table.row>
                @endforeach
            </x-table.body>
        </x-table>

        <x-body.pagination>
            <x-body.description>
                Showing results {{ ($page - 1) * $limit }} - {{ ($page - 1) * $limit + $limit }}
            </x-body.description>
            <x-body.pagination.group>
                <x-body.pagination.group.button :href="route('transactions.index', array_merge(request()->input(), ['page' => max(1, $page - 1)]))">
                    <i class="fa-solid fa-caret-left"></i>
                </x-body.pagination.group.button>
                <x-body.pagination.group.button disabled>
                    1
                </x-body.pagination.group.button>
                <x-body.pagination.group.button :href="route(
                    'transactions.index',
                    array_merge(request()->input(), [
                        'page' => $transactions->count() > $limit ? $page + 1 : $page,
                    ]),
                )">
                    <i class="fa-solid fa-caret-right"></i>
                </x-body.pagination.group.button>
            </x-body.pagination.group>
        </x-body.pagination>

    </div>
</x-layout.auth>
