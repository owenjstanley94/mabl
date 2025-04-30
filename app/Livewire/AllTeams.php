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
        return view('livewire.all-teams');
    }
}
