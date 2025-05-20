<div class="p-6">
    <div class="mb-4 flex gap-4">
        <div class="flex-1">
            <flux:input wire:model.live="search" placeholder="Search teams..." />
        </div>
        <div class="w-48">
            <flux:select wire:model.live="leagueFilter">
                <option value="">All Leagues</option>
                @foreach($leagues as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </flux:select>
        </div>
    </div>

    @if($this->teams->isEmpty())
        <div class="flex flex-col items-center justify-center py-12">
            <flux:icon name="x-mark" class="h-12 w-12 text-gray-400" />
            <p class="mt-4 text-sm text-gray-500">No teams found matching your search criteria</p>
        </div>
    @else
        <flux:table>
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Name</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'league_id'" :direction="$sortDirection" wire:click="sort('league_id')">League</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'court'" :direction="$sortDirection" wire:click="sort('court')">Court</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'tip_day'" :direction="$sortDirection" wire:click="sort('tip_day')">Tip Day</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'tip_time'" :direction="$sortDirection" wire:click="sort('tip_time')">Tip Time</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach($this->teams as $team)
                    <flux:table.row :key="$team->id">
                        <flux:table.cell variant="strong">
                            <flux:link href="{{ route('teams.show', $team) }}" class="no-underline">
                                {{ $team->name }}
                            </flux:link>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm" inset="top bottom">{{ $team->league->name }}</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>{{ $team->court }}</flux:table.cell>
                        <flux:table.cell>{{ $team->tip_day }}</flux:table.cell>
                        <flux:table.cell>{{ $team->tip_time }}</flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>

        <div class="mt-4">
            {{ $this->teams->links() }}
        </div>
    @endif
</div>