<div class="p-6">
    <div class="mb-4 flex gap-4">
        <div class="flex-1">
            <flux:input wire:model.live="search" placeholder="Search officials..." />
        </div>
        <div class="w-48">
            <flux:select wire:model.live="roleFilter">
                <option value="">All Roles</option>
                <option value="Referee">Referee</option>
                <option value="Table">Table</option>
            </flux:select>
        </div>
    </div>

    @if($this->officials->isEmpty())
        <div class="flex flex-col items-center justify-center py-12">
            <flux:icon name="x-mark" class="h-12 w-12 text-gray-400" />
            <p class="mt-4 text-sm text-gray-500">No officials found matching your search criteria</p>
        </div>
    @else
        <flux:table>
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Name</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'role'" :direction="$sortDirection" wire:click="sort('role')">Role</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'email'" :direction="$sortDirection" wire:click="sort('email')">Email</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'licence_number'" :direction="$sortDirection" wire:click="sort('licence_number')">License</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach($this->officials as $official)
                    <flux:table.row :key="$official->id">
                        <flux:table.cell variant="strong">
                            <flux:link href="{{ route('officials.show', $official) }}" class="no-underline">
                                {{ $official->name }}
                            </flux:link>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm" inset="top bottom">{{ $official->role }}</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>{{ $official->email }}</flux:table.cell>
                        <flux:table.cell>
                            @if($official->licence_number)
                                <flux:badge size="sm" inset="top bottom">{{ $official->licence_number }}</flux:badge>
                            @endif
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>

        <div class="mt-4">
            {{ $this->officials->links() }}
        </div>
    @endif
</div>