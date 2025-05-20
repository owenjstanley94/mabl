<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Team;
use App\Models\Official;

class GlobalSearch extends Component
{
    public $search = '';
    public $isOpen = false;

    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function close()
    {
        $this->isOpen = false;
        $this->search = '';
    }

    #[\Livewire\Attributes\Computed]
    public function results()
    {
        if (empty($this->search)) {
            return collect();
        }

        $teams = Team::where('name', 'like', '%' . $this->search . '%')
            ->get()
            ->map(function ($team) {
                return [
                    'id' => $team->id,
                    'name' => $team->name,
                    'type' => 'team',
                    'url' => route('teams.show', $team->slug),
                    'icon' => 'user-group',
                ];
            });

        $officials = Official::where('name', 'like', '%' . $this->search . '%')
            ->get()
            ->map(function ($official) {
                return [
                    'id' => $official->id,
                    'name' => $official->name,
                    'type' => 'official',
                    'url' => route('officials.show', $official->slug),
                    'icon' => 'user',
                ];
            });

        return $teams->concat($officials);
    }

    public function render()
    {
        return view('livewire.global-search');
    }
} 