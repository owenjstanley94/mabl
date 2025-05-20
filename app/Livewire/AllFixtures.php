<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Tables\Table;
use App\Models\Fixture;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use App\Models\Team;

class AllFixtures extends Component implements HasTable, HasForms
{

    use InteractsWithTable;
    use InteractsWithForms;

    public $search = '';
    public $leagueFilter = '';
    public $teamFilter = '';
    public $sortBy = 'date';
    public $sortDirection = 'asc';

    public function updatedLeagueFilter()
    {
        $this->teamFilter = ''; // Reset team filter when league changes
    }

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[\Livewire\Attributes\Computed]
    public function fixtures()
    {
        $query = Fixture::query()
            ->with(['homeTeam', 'awayTeam', 'league', 'crewChief', 'referee1', 'referee2']);

        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('homeTeam', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('awayTeam', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('league', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('crewChief', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('referee1', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('referee2', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            });
        }

        if ($this->leagueFilter) {
            $query->where('league_id', $this->leagueFilter);
        }

        if ($this->teamFilter) {
            $query->where(function($q) {
                $q->where('home_team_id', $this->teamFilter)
                  ->orWhere('away_team_id', $this->teamFilter);
            });
        }

        return $query->orderBy($this->sortBy, $this->sortDirection)->paginate(10);
    }

    #[\Livewire\Attributes\Computed]
    public function filteredTeams()
    {
        $query = Team::query();
        
        if ($this->leagueFilter) {
            $query->where('league_id', $this->leagueFilter);
        }
        
        return $query->orderBy('name')->get();
    }

    public function table(Table $table): Table
    {
        return $table
        ->paginated(false)
        ->query(Fixture::query()->with(['homeTeam', 'awayTeam', 'league', 'crewChief', 'referee1', 'referee2']))
        ->columns([
            TextColumn::make('hometeam.name')->searchable(),
            TextColumn::make('awayteam.name')->searchable(),
            TextColumn::make('crewchief.name'),
            TextColumn::make('referee1.name'),
            TextColumn::make('referee2.name'),
            TextColumn::make('league.name')        
        ]);
    }

    public function render()
    {
        return view('livewire.all-fixtures', [
            'leagues' => \App\Models\League::pluck('name', 'id'),
        ]);
    }
}
