@if ($errors->get($attributes->get('name')))
    <div class="relative mt-1 rounded-md shadow-sm">
        <input
            {{ $attributes->merge(['class' => 'block w-full rounded-md border-red-300 pr-10 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 sm:text-sm']) }}
            aria-invalid="true">
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <i class="fa-solid fa-circle-exclamation text-red-500"></i>
        </div>
    </div>
    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $errors->get($attributes->get('name'))[0] }}</p>
@else
    <input
        {{ $attributes->merge(['class' => 'block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm mt-1']) }}>
@endif
