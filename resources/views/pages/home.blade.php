@extends('layouts.app')

@section('title', '/')

@section('content')

    @php
        // Fetch all leagues with their teams, excluding 'Cup'
        $leagues = \App\Models\League::with('teams')->where('name', '!=', 'Cup')->get();
    @endphp

    <flux:tab.group>
        <div class="flex justify-center mb-4">
            <flux:tabs variant="segmented">
                @foreach($leagues as $league)
                    <flux:tab name="league-{{ $league->id }}">{{ $league->name }}</flux:tab>
                @endforeach
            </flux:tabs>
        </div>
        @foreach($leagues as $league)
            <flux:tab.panel name="league-{{ $league->id }}">
                <div class="overflow-x-auto mt-4">
                    <flux:card>
                        <flux:heading size="md" class="mb-4">League Standings</flux:heading>
                        <flux:table>
                            <flux:table.columns>
                                <flux:table.column>Team</flux:table.column>
                                <flux:table.column>Played</flux:table.column>
                                <flux:table.column>Won</flux:table.column>
                                <flux:table.column>Lost</flux:table.column>
                                <flux:table.column>Home Won</flux:table.column>
                                <flux:table.column>Home Lost</flux:table.column>
                                <flux:table.column>Away Won</flux:table.column>
                                <flux:table.column>Away Lost</flux:table.column>
                                <flux:table.column>DF</flux:table.column>
                                <flux:table.column>Points</flux:table.column>
                            </flux:table.columns>
                            <flux:table.rows>
                                @php
                                    $sortedTeams = $league->teams->sortByDesc(function($team) {
                                        return $team->getLeagueStats()['points'];
                                    });
                                @endphp
                                @foreach($sortedTeams as $team)
                                    <flux:table.row :key="$team->id">
                                        <flux:table.cell variant="strong">
                                            <flux:link href="{{ route('teams.show', $team) }}">
                                                {{ $team->name }}
                                            </flux:link>
                                        </flux:table.cell>
                                        @php
                                            $stats = $team->getLeagueStats();
                                        @endphp
                                        <flux:table.cell>{{ $stats['played'] }}</flux:table.cell>
                                        <flux:table.cell>{{ $stats['won'] }}</flux:table.cell>
                                        <flux:table.cell>{{ $stats['lost'] }}</flux:table.cell>
                                        <flux:table.cell>{{ $stats['home_won'] }}</flux:table.cell>
                                        <flux:table.cell>{{ $stats['home_lost'] }}</flux:table.cell>
                                        <flux:table.cell>{{ $stats['away_won'] }}</flux:table.cell>
                                        <flux:table.cell>{{ $stats['away_lost'] }}</flux:table.cell>
                                        <flux:table.cell>0</flux:table.cell>
                                        <flux:table.cell>{{ $stats['points'] }}</flux:table.cell>
                                    </flux:table.row>
                                @endforeach
                            </flux:table.rows>
                        </flux:table>
                    </flux:card>
                </div>
                <div class="overflow-x-auto mt-4">
                    <flux:card>
                        <flux:heading size="md" class="mb-4">This Week's Games</flux:heading>
                        @php
                            $thisWeekFixtures = \App\Models\Fixture::with(['homeTeam', 'awayTeam'])
                                ->where('league_id', $league->id)
                                ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
                                ->orderBy('date')
                                ->get();
                        @endphp
                        @if($thisWeekFixtures->isEmpty())
                            <div class="flex flex-col items-center justify-center py-12">
                                <flux:icon name="x-mark" class="h-12 w-12 text-gray-400" />
                                <p class="mt-4 text-sm text-gray-500">No games scheduled for this week</p>
                            </div>
                        @else
                            <flux:table>
                                <flux:table.columns>
                                    <flux:table.column>Date</flux:table.column>
                                    <flux:table.column>Tip Time</flux:table.column>
                                    <flux:table.column>Home Team</flux:table.column>
                                    <flux:table.column>Away Team</flux:table.column>
                                    <flux:table.column>Venue</flux:table.column>
                                    <flux:table.column>Status</flux:table.column>
                                </flux:table.columns>
                                <flux:table.rows>
                                    @foreach($thisWeekFixtures as $fixture)
                                        <flux:table.row :key="$fixture->id">
                                            <flux:table.cell>{{ $fixture->date ? $fixture->date->format('d-m-y') : '' }}</flux:table.cell>
                                            <flux:table.cell>{{ $fixture->tip_time }}</flux:table.cell>
                                            <flux:table.cell>
                                                <flux:link href="{{ route('teams.show', $fixture->homeTeam) }}" class="no-underline">
                                                    {{ $fixture->homeTeam->name }}
                                                </flux:link>
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <flux:link href="{{ route('teams.show', $fixture->awayTeam) }}" class="no-underline">
                                                    {{ $fixture->awayTeam->name }}
                                                </flux:link>
                                            </flux:table.cell>
                                            <flux:table.cell>{{ $fixture->homeTeam->court ?? '' }}</flux:table.cell>
                                            <flux:table.cell>
                                                <flux:badge size="sm" color="{{
                                                    match($fixture->status) {
                                                        'planned' => 'gray',
                                                        'confirmed' => 'blue',
                                                        'completed' => 'green',
                                                        'forfeited' => 'red',
                                                        'contested' => 'orange',
                                                        default => 'gray',
                                                    }
                                                }}" inset="top bottom">
                                                    {{ ucfirst($fixture->status) }}
                                                </flux:badge>
                                            </flux:table.cell>
                                        </flux:table.row>
                                    @endforeach
                                </flux:table.rows>
                            </flux:table>
                        @endif
                    </flux:card>
                </div>
            </flux:tab.panel>
        @endforeach
    </flux:tab.group>
@endsection 