<div class="p-6">
        <div class="mb-4 flex gap-4">
            <div class="flex-1">
                <flux:input wire:model.live="search" placeholder="Search fixtures..." />
            </div>
            <div class="w-48">
                <flux:select wire:model.live="leagueFilter">
                    <option value="">All Leagues</option>
                    @foreach($leagues as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </flux:select>
            </div>
            <div class="w-48">
                <flux:select wire:model.live="teamFilter">
                    <option value="">All Teams</option>
                    @foreach($this->filteredTeams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                </flux:select>
            </div>
            <div>
                <flux:button
                    wire:click="toggleThisWeek"
                    :variant="$thisWeekOnly ? 'primary' : 'outline'"
                >
                    This Week Only
                </flux:button>
            </div>
        </div>

        @if($this->fixtures->isEmpty())
            <div class="flex flex-col items-center justify-center py-12">
                <flux:icon name="x-mark" class="h-12 w-12 text-gray-400" />
                <p class="mt-4 text-sm text-gray-500">No fixtures found matching your search criteria</p>
            </div>
        @else
            <flux:table>
                <flux:table.columns>
                    <flux:table.column sortable :sorted="$sortBy === 'date'" :direction="$sortDirection" wire:click="sort('date')">Date</flux:table.column>
                    <flux:table.column>Tip Time</flux:table.column>
                    <flux:table.column sortable :sorted="$sortBy === 'league_id'" :direction="$sortDirection" wire:click="sort('league_id')">League</flux:table.column>
                    <flux:table.column sortable :sorted="$sortBy === 'home_team_id'" :direction="$sortDirection" wire:click="sort('home_team_id')">Home Team</flux:table.column>
                    <flux:table.column sortable :sorted="$sortBy === 'away_team_id'" :direction="$sortDirection" wire:click="sort('away_team_id')">Away Team</flux:table.column>
                    <flux:table.column>Crew Chief</flux:table.column>
                    <flux:table.column>Referee 1</flux:table.column>
                    <flux:table.column>Referee 2</flux:table.column>
                    <flux:table.column>Home Score</flux:table.column>
                    <flux:table.column>Away Score</flux:table.column>
                    <flux:table.column>Status</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach($this->fixtures as $fixture)
                        <flux:table.row :key="$fixture->id">
                            <flux:table.cell>{{ $fixture->date->format('d-m-y') }}</flux:table.cell>
                            <flux:table.cell>{{ $fixture->tip_time }}</flux:table.cell>
                            <flux:table.cell>
                                <flux:badge size="sm" inset="top bottom">{{ $fixture->league->name }}</flux:badge>
                            </flux:table.cell>
                            <flux:table.cell variant="strong">
                                @if($fixture->status === 'completed' && !is_null($fixture->home_team_score) && !is_null($fixture->away_team_score) && $fixture->home_team_score > $fixture->away_team_score)
                                    <span class="font-bold">{{ $fixture->homeTeam->name }}</span>
                                @else
                                    {{ $fixture->homeTeam->name }}
                                @endif
                            </flux:table.cell>
                            <flux:table.cell variant="strong">
                                @if($fixture->status === 'completed' && !is_null($fixture->home_team_score) && !is_null($fixture->away_team_score) && $fixture->away_team_score > $fixture->home_team_score)
                                    <span class="font-bold">{{ $fixture->awayTeam->name }}</span>
                                @else
                                    {{ $fixture->awayTeam->name }}
                                @endif
                            </flux:table.cell>
                            <flux:table.cell>{{ $fixture->crewChief?->name }}</flux:table.cell>
                            <flux:table.cell>{{ $fixture->referee1?->name }}</flux:table.cell>
                            <flux:table.cell>{{ $fixture->referee2?->name }}</flux:table.cell>
                            <flux:table.cell>
                                @if(!is_null($fixture->home_team_score))
                                    @if($fixture->status === 'completed' && $fixture->home_team_score > $fixture->away_team_score)
                                        <span class="font-bold">{{ $fixture->home_team_score }}</span>
                                    @else
                                        {{ $fixture->home_team_score }}
                                    @endif
                                @endif
                            </flux:table.cell>
                            <flux:table.cell>
                                @if(!is_null($fixture->away_team_score))
                                    @if($fixture->status === 'completed' && $fixture->away_team_score > $fixture->home_team_score)
                                        <span class="font-bold">{{ $fixture->away_team_score }}</span>
                                    @else
                                        {{ $fixture->away_team_score }}
                                    @endif
                                @endif
                            </flux:table.cell>
                            <flux:table.cell>
                                @php
                                    $statusColor = match($fixture->status) {
                                        'planned' => 'gray',
                                        'confirmed' => 'blue',
                                        'completed' => 'green',
                                        'forfeited' => 'red',
                                        'contested' => 'orange',
                                        default => 'gray',
                                    };
                                @endphp
                                <flux:badge size="sm" color="{{ $statusColor }}" inset="top bottom">
                                    {{ ucfirst($fixture->status) }}
                                </flux:badge>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>

            <div class="mt-4">
                {{ $this->fixtures->links() }}
            </div>
        @endif
</div> 