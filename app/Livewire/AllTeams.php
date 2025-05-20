<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Models\Team;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Filters\SelectFilter;

class AllTeams extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;
    
    public $search = '';
    public $leagueFilter = '';
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
    public function teams()
    {
        $query = Team::query()->with('league');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('court', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->leagueFilter) {
            $query->where('league_id', $this->leagueFilter);
        }

        return $query->orderBy($this->sortBy, $this->sortDirection)->paginate(10);
    }

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->query(Team::query()->with('league'))
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->extraAttributes(['class' => 'font-bold']),
                TextColumn::make('league.name')
                    ->searchable()
                    ->badge(),
                TextColumn::make('court')
                    ->searchable(),
                TextColumn::make('tip_day')->label('Tip Day'),
                TextColumn::make('tip_time')->label('Tip Time'),
            ])
            ->filters([
                SelectFilter::make('league_id')
                    ->label('League')
                    ->options(\App\Models\League::pluck('name', 'id')->toArray()),
            ])
            ->filtersLayout(\Filament\Tables\Enums\FiltersLayout::AboveContent)
            ->actions([
                \Filament\Tables\Actions\Action::make('map')
                    ->icon('heroicon-o-map')
                    ->label('Map')
                    ->url(fn($record) => 'https://www.google.com/maps/search/?api=1&query=' . urlencode($record->court))
                    ->openUrlInNewTab(),
                // \Filament\Tables\Actions\Action::make('view')
                //     ->label('View')
                //     ->url(fn($record) => route('team.show', $record->id))
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function makeFilamentTranslatableContentDriver(): ?\Filament\Support\Contracts\TranslatableContentDriver
    {
        return null;
    }

    public function render()
    {
        return view('livewire.all-teams', [
            'leagues' => \App\Models\League::pluck('name', 'id'),
        ]);
    }
}
