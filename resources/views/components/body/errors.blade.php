@if ($errors->any())
    <div class="rounded-md bg-red-50 p-4">
        <div class="flex justify-center">
            <div class="flex-shrink-0">
                <i class="fa-solid fa-circle-xmark text-red-400"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">The request could not be completed:</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul role="list" class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
