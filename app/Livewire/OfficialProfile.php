<?php

namespace App\Livewire;

use App\Models\Official;
use Livewire\Component;
use Illuminate\Support\Collection;

class OfficialProfile extends Component
{
    public Official $official;
    public $games;

    public function mount(Official $official)
    {
        $this->official = $official;
        $this->games = $this->getAssignedGames();
    }

    protected function getAssignedGames()
    {
        $crewChiefGames = $this->official->crewChiefGames()->with(['homeTeam', 'awayTeam', 'league'])->get()->map(function ($fixture) {
            $fixture->official_role = 'Crew Chief';
            return $fixture;
        });
        $ref1Games = $this->official->referee1Games()->with(['homeTeam', 'awayTeam', 'league'])->get()->map(function ($fixture) {
            $fixture->official_role = 'Referee 1';
            return $fixture;
        });
        $ref2Games = $this->official->referee2Games()->with(['homeTeam', 'awayTeam', 'league'])->get()->map(function ($fixture) {
            $fixture->official_role = 'Referee 2';
            return $fixture;
        });
        return $crewChiefGames->merge($ref1Games)->merge($ref2Games)->sortBy('date');
    }

    public function render()
    {
        return view('livewire.official-profile');
    }
}
