<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Tables\Table;
use App\Models\Fixture;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;

class AllFixtures extends Component implements HasTable, HasForms
{

    use InteractsWithTable;
    use InteractsWithForms;

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
        return view('livewire.all-fixtures');
    }
}
