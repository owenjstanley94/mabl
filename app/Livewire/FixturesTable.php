<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fixture;
use App\Models\Team;
use App\Models\Official;

class FixturesTable extends Component
{
    public $search = '';
    public $leagueFilter = '';
    public $teamFilter = '';
    public $thisWeekOnly = false;
    public $sortBy = 'date';
    public $sortDirection = 'asc';
    public $model;
    public $modelType;

    public function mount($model = null)
    {
        $this->model = $model;
        $this->modelType = $model ? get_class($model) : null;
    }

    public function updatedLeagueFilter()
    {
        $this->teamFilter = '';
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
            ->with(['homeTeam', 'awayTeam', 'league', 'crewChief', 'referee1', 'referee2']);

        // Filter based on model type
        if ($this->model) {
            if ($this->modelType === Team::class) {
                $query->where(function ($query) {
                    $query->where('home_team_id', $this->model->id)
                        ->orWhere('away_team_id', $this->model->id);
                });
            } elseif ($this->modelType === Official::class) {
                $query->where(function ($query) {
                    $query->where('crew_chief_id', $this->model->id)
                        ->orWhere('referee_1_id', $this->model->id)
                        ->orWhere('referee_2_id', $this->model->id);
                });
            }
        }

        $query->when($this->search, function ($query) {
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

    public function render()
    {
        return view('livewire.fixtures-table', [
            'leagues' => \App\Models\League::pluck('name', 'id'),
        ]);
    }
} 