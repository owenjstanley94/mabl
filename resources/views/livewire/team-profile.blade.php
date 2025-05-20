<flux:container>
    <flux:card>
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <flux:heading size="xl">{{ $team->name }}</flux:heading>
                </div>
                <flux:badge size="lg" inset="top bottom">{{ $team->league->name }}</flux:badge>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:card>
                    <flux:heading size="lg" class="mb-4">Team Details</flux:heading>
                    <div class="space-y-4">
                        <div>
                            <flux:text size="sm">Court</flux:text>
                            <flux:text size="sm">{{ $team->court }}</flux:text>
                        </div>
                        <div>
                            <flux:text size="sm">Tip Day</flux:text>
                            <flux:text size="sm">{{ $team->tip_day }}</flux:text>
                        </div>
                        <div>
                            <flux:text size="sm">Tip Time</flux:text>
                            <flux:text size="sm">{{ $team->tip_time }}</flux:text>
                        </div>
                    </div>
                </flux:card>

                <flux:card>
                    <flux:heading size="lg" class="mb-4">Games</flux:heading>
                    <div class="space-y-4 mb-4">
                        <div class="flex gap-4">
                            <div class="flex-1 relative">
                                <flux:input wire:model.live="search" placeholder="Search opponent..." />
                            </div>
                            <div class="w-48">
                                <flux:select wire:model.live="venueFilter">
                                    <option value="">All Games</option>
                                    <option value="home">Home Games</option>
                                    <option value="away">Away Games</option>
                                </flux:select>
                            </div>
                        </div>
                        <div class="flex gap-4 items-end">
                            <!-- Date filtering UI removed -->
                        </div>
                    </div>
                    @if($games->isEmpty())
                        <flux:text size="sm">No games scheduled</flux:text>
                    @else
                        <flux:table>
                            <flux:table.columns>
                                <flux:table.column>Date</flux:table.column>
                                <flux:table.column>Tip Time</flux:table.column>
                                <flux:table.column>Opponent</flux:table.column>
                                <flux:table.column>League</flux:table.column>
                                <flux:table.column>Venue</flux:table.column>
                                <flux:table.column>Result</flux:table.column>
                                <flux:table.column>W/L</flux:table.column>
                            </flux:table.columns>

                            <flux:table.rows>
                                @foreach($games as $fixture)
                                    <flux:table.row :key="$fixture->id">
                                        <flux:table.cell>
                                            <flux:text size="sm">
                                                {{ $fixture->date ? $fixture->date->format('d-m-y') : 'No date set' }}
                                            </flux:text>
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            <flux:text size="sm">
                                                {{ $fixture->tip_time ?? 'No time set' }}
                                            </flux:text>
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            <flux:link href="{{ route('teams.show', $fixture->homeTeam->id === $team->id ? $fixture->awayTeam : $fixture->homeTeam) }}" class="no-underline">
                                                {{ $fixture->homeTeam->id === $team->id ? $fixture->awayTeam->name : $fixture->homeTeam->name }}
                                            </flux:link>
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            <flux:badge size="sm" inset="top bottom">{{ $fixture->league->name }}</flux:badge>
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            @if($fixture->homeTeam->id === $team->id)
                                                <flux:badge size="sm" color="green" inset="top bottom">Home</flux:badge>
                                            @else
                                                <flux:badge size="sm" color="blue" inset="top bottom">Away</flux:badge>
                                            @endif
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            @if(!is_null($fixture->home_team_score) && !is_null($fixture->away_team_score))
                                                @if($fixture->home_team_score > $fixture->away_team_score)
                                                    <strong>{{ $fixture->home_team_score }}</strong> - {{ $fixture->away_team_score }}
                                                @elseif($fixture->away_team_score > $fixture->home_team_score)
                                                    {{ $fixture->home_team_score }} - <strong>{{ $fixture->away_team_score }}</strong>
                                                @else
                                                    {{ $fixture->home_team_score }} - {{ $fixture->away_team_score }}
                                                @endif
                                            @endif
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            @if(!is_null($fixture->home_team_score) && !is_null($fixture->away_team_score))
                                                @php
                                                    $isHome = $fixture->homeTeam->id === $team->id;
                                                    $won = ($isHome && $fixture->home_team_score > $fixture->away_team_score) || (!$isHome && $fixture->away_team_score > $fixture->home_team_score);
                                                    $lost = ($isHome && $fixture->home_team_score < $fixture->away_team_score) || (!$isHome && $fixture->away_team_score < $fixture->home_team_score);
                                                @endphp
                                                @if($won)
                                                    <flux:badge size="sm" color="green" inset="top bottom">W</flux:badge>
                                                @elseif($lost)
                                                    <flux:badge size="sm" color="red" inset="top bottom">L</flux:badge>
                                                @endif
                                            @endif
                                        </flux:table.cell>
                                    </flux:table.row>
                                @endforeach
                            </flux:table.rows>
                        </flux:table>
                    @endif
                </flux:card>
            </div>
        </div>
    </flux:card>
</flux:container> 