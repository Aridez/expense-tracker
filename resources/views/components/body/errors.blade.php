@if ($errors->any())
<div class="w-full border-b flex flex-col items-center justify-center px-16 py-2
                bg-red-100 dark:bg-rose-900
                text-red-700 dark:text-rose-100
                border-red-400 dark:border-rose-300">
    @foreach ($errors->all() as $error)
    <div>
        <i class="fas fa-exclamation-triangle pr-1"></i>
        {{ $error }}<br>
    </div>
    @endforeach
</div>
@endif
