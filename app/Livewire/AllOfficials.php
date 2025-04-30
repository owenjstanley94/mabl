<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Models\Official;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;

class AllOfficials extends Component implements HasTable, HasForms
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->query(Official::query())
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->extraAttributes(['class' => 'font-bold']),
                TextColumn::make('email'),
                TextColumn::make('role')
                    ->badge(),
                TextColumn::make('licence_number'),
                TextColumn::make('level'),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options(Official::query()->pluck('role', 'role')->unique()->toArray()),
            ])
            ->filtersLayout(\Filament\Tables\Enums\FiltersLayout::AboveContent)
            ->actions([
                Action::make('email')
                    ->icon('heroicon-o-envelope')
                    ->label('Email')
                    ->url(fn($record) => 'mailto:' . $record->email . '?subject=' . urlencode('MABL'))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.all-officials');
    }
}
