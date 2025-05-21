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
    public $thisWeekOnly = false;
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

    public function toggleThisWeek()
    {
        $this->thisWeekOnly = !$this->thisWeekOnly;
    }

    #[\Livewire\Attributes\Computed]
    public function fixtures()
    {
        $query = Fixture::query()
            ->with(['homeTeam', 'awayTeam', 'league', 'crewChief', 'referee1', 'referee2'])
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->whereHas('homeTeam', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('awayTeam', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('league', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->when($this->leagueFilter, function ($query) {
                $query->where('league_id', $this->leagueFilter);
            })
            ->when($this->teamFilter, function ($query) {
                $query->where(function ($query) {
                    $query->where('home_team_id', $this->teamFilter)
                        ->orWhere('away_team_id', $this->teamFilter);
                });
            })
            ->when($this->thisWeekOnly, function ($query) {
                $query->whereBetween('date', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]);
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate(10);
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
