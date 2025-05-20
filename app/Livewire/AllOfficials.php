<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Official;

class AllOfficials extends Component
{
    public $search = '';
    public $roleFilter = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

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
    public function officials()
    {
        $query = Official::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('licence_number', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter) {
            $query->where('role', $this->roleFilter);
        }

        return $query->orderBy($this->sortBy, $this->sortDirection)->paginate(10);
    }

    public function render()
    {
        return view('livewire.all-officials', [
            'roles' => Official::query()->pluck('role')->unique()->values(),
        ]);
    }
}
