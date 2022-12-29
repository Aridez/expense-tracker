<nav class="h-16 flex">
  <div class="bg-white w-full border-b flex justify-around">
    <div class="flex">
      <div class="sm:ml-6 sm:flex sm:space-x-8">
        {{ $left ?? '' }}
      </div>
    </div>
    <div class="sm:ml-6 sm:flex sm:space-x-8">
      {{ $right ?? '' }}
    </div>
  </div>
</nav>