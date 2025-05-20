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
                            @foreach($league->teams as $team)
                                <flux:table.row :key="$team->id">
                                    <flux:table.cell variant="strong">{{ $team->name }}</flux:table.cell>
                                    <flux:table.cell>16</flux:table.cell>
                                    <flux:table.cell>10</flux:table.cell>
                                    <flux:table.cell>6</flux:table.cell>
                                    <flux:table.cell>5</flux:table.cell>
                                    <flux:table.cell>3</flux:table.cell>
                                    <flux:table.cell>5</flux:table.cell>
                                    <flux:table.cell>3</flux:table.cell>
                                    <flux:table.cell>0</flux:table.cell>
                                    <flux:table.cell>25</flux:table.cell>
                                </flux:table.row>
                            @endforeach
                        </flux:table.rows>
                    </flux:table>
                </div>
            </flux:tab.panel>
        @endforeach
    </flux:tab.group>
@endsection 