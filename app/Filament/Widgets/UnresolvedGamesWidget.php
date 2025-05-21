<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use App\Models\Fixture;
use Illuminate\Database\Eloquent\Builder;

class UnresolvedGamesWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Attention Games';

    protected function getTableQuery(): Builder
    {
        $now = now();
        $fiveDaysAhead = $now->addDays(5)->endOfDay();
        $yesterday = $now->copy()->subDay()->startOfDay();
        return Fixture::query()
            ->with(['homeTeam', 'awayTeam', 'league'])
            ->where(function ($query) use ($now, $fiveDaysAhead, $yesterday) {
                $query->where('status', 'contested')
                    ->orWhere(function ($query) use ($now) {
                        // Not confirmed 5 days before scheduled time
                        $query->where('status', '!=', 'confirmed')
                              ->where('date', '>', $now)
                              ->where('date', '<=', $now->copy()->addDays(5)->endOfDay());
                    })
                    ->orWhere(function ($query) use ($yesterday) {
                        // Confirmed but not completed within 24 hours after scheduled time
                        $query->where('status', 'confirmed')
                              ->where('date', '<', $yesterday)
                              ->where('status', '!=', 'completed');
                    });
            });
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('date')->date('d-m-Y')->sortable(),
            Tables\Columns\TextColumn::make('league.name')->label('League')->sortable(),
            Tables\Columns\TextColumn::make('homeTeam.name')->label('Home Team')->sortable(),
            Tables\Columns\TextColumn::make('awayTeam.name')->label('Away Team')->sortable(),
            Tables\Columns\TextColumn::make('status')->badge()->color(fn ($state) => match ($state) {
                'contested' => 'orange',
                'planned' => 'gray',
                'confirmed' => 'blue',
                'completed' => 'green',
                'forfeited' => 'red',
                default => 'gray',
            }),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('edit')
                ->label('Edit')
                ->url(fn ($record) => route('filament.admin.resources.fixtures.edit', $record))
                ->icon('heroicon-o-pencil')
                ->color('primary')
                ->openUrlInNewTab(),
        ];
    }
} 