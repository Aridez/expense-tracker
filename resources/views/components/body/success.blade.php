@if (session()->has('success'))
    <div
        class="w-full border-b text-center items-center justify-center flex py-2
        bg-cyan-100 dark:bg-cyan-700
        text-cyan-700 dark:text-cyan-100
        border-cyan-400 dark:border-cyan-300">
        <i class="fa-solid fa-circle-check pr-1"></i> {{ __(session()->get('success')) }}
    </div>
@endif
