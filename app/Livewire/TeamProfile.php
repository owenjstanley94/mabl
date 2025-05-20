<?php

namespace App\Livewire;

use App\Models\Team;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class TeamProfile extends Component
{
    use WithPagination;

    public Team $team;
    public $search = '';
    public $venueFilter = '';
    public $showSearch = false;

    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function getGamesProperty()
    {
        $homeFixtures = $this->team->homeFixtures()
            ->with(['homeTeam', 'awayTeam', 'league'])
            ->get();

        $awayFixtures = $this->team->awayFixtures()
            ->with(['homeTeam', 'awayTeam', 'league'])
            ->get();

        $games = $homeFixtures->merge($awayFixtures);

        if ($this->search) {
            $games = $games->filter(function ($fixture) {
                $opponent = $fixture->homeTeam->id === $this->team->id 
                    ? $fixture->awayTeam 
                    : $fixture->homeTeam;
                return str_contains(strtolower($opponent->name), strtolower($this->search));
            });
        }

        if ($this->venueFilter) {
            $games = $games->filter(function ($fixture) {
                if ($this->venueFilter === 'home') {
                    return $fixture->homeTeam->id === $this->team->id;
                } elseif ($this->venueFilter === 'away') {
                    return $fixture->awayTeam->id === $this->team->id;
                }
                return true;
            });
        }

        return $games->sortBy('date');
    }

    public function render()
    {
        return view('livewire.team-profile', [
            'games' => $this->games,
        ]);
    }
} 