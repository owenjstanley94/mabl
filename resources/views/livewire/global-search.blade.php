<div>
    <flux:button
        variant="ghost"
        class="ml-auto"
        wire:click="toggle"
    >
        <flux:icon name="magnifying-glass" class="h-5 w-5" />
        <span class="ml-2 hidden lg:inline">Search...</span>
        <span class="ml-2 hidden lg:inline text-zinc-400">⌘K</span>
    </flux:button>

    <flux:command
        wire:model="search"
        :open="$isOpen"
        @close="close"
        class="z-50"
    >
        <flux:command.input placeholder="Search teams and officials..." />

        <div class="mt-2">
            @if(empty($search))
                <div class="flex flex-col items-center justify-center py-6 text-center">
                    <flux:icon name="magnifying-glass" class="h-6 w-6 text-zinc-400" />
                    <p class="mt-2 text-sm text-zinc-500">Search for teams and officials...</p>
                </div>
            @elseif($this->results->isEmpty())
                <div class="flex flex-col items-center justify-center py-6 text-center">
                    <flux:icon name="x-mark" class="h-6 w-6 text-zinc-400" />
                    <p class="mt-2 text-sm text-zinc-500">No results found for "{{ $search }}"</p>
                </div>
            @else
                <div class="max-h-[300px] overflow-y-auto">
                    @foreach($this->results as $result)
                        <a
                            href="{{ $result['url'] }}"
                            wire:key="{{ $result['type'] }}-{{ $result['id'] }}"
                            class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800"
                        >
                            <flux:icon :name="$result['icon']" class="h-5 w-5 text-zinc-400" />
                            <span>{{ $result['name'] }}</span>
                            <span class="ml-2 text-sm text-zinc-400">{{ ucfirst($result['type']) }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </flux:command>
</div> 