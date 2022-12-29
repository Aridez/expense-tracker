<div  {{$attributes->merge(['class' => 'group relative inline-flex items-center hover:border-indigo-500 px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-900'])}}>
    <button class="hover:bg-cyan-100 dark:hover:bg-gray-700  dark:hover:text-cyan-200 p-2 rounded-md text-sm font-medium">
        {{$slot}}
    </button>
    <div class="absolute right-0 w-36 scale-0 group-hover:scale-100">
        <div class="bg-white dark:bg-gray-900 border border-gray-300 dark:border-cyan-300 rounded-md opacity-0 group-hover:opacity-100 group-hover:translate-y-12 transition duration-300">
            {{$items}}
        </div>
    </div>
</div>