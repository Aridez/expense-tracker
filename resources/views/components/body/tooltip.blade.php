<div {{ $attributes->merge(['class' => 'group relative inline-block z-10']) }}>
    <!-- For centering use -translate-x-1/2 -->
    <div
        class="invisible group-hover:visible opacity-0 group-hover:opacity-100 absolute w-64 text-center bottom-full transform -translate-x-2.5 transition transition-all bg-white border border-indigo-200 rounded-lg">
        <div class="flex items-center p-2">
            <div class="flex w-0 flex-1 justify-between">
                <p class="w-0 flex-1 text-sm font-medium text-indigo-600">{{ $slot }}</p>
            </div>
        </div>
    </div>
    <i class="fa-solid fa-circle-info"></i>
</div>
