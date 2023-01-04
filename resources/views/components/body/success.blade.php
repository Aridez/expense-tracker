@if (session()->has('success'))
    <div id="success" class="rounded-md bg-green-50 p-4">
        <div class="flex justify-center">
            <div class="flex-shrink-0">
                <i class="fa-solid fa-circle-check h-5 w-5 text-green-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800"> {{ __(session()->get('success')) }}</p>
            </div>
        </div>
    </div>
@endif
