<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Fixture;

class GamesThisWeekWidget extends BaseWidget
{
    protected string|int|array $columnSpan = '1/4';
    protected function getCards(): array
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $gamesThisWeek = Fixture::whereBetween('date', [$startOfWeek, $endOfWeek])->count();
        $gamesCompletedThisWeek = Fixture::whereBetween('date', [$startOfWeek, $endOfWeek])
            ->where('status', 'completed')
            ->count();
        $completedPercent = $gamesThisWeek > 0 ? round(($gamesCompletedThisWeek / $gamesThisWeek) * 100, 1) : 0;

        return [
            Card::make('Games This Week', $gamesThisWeek),
            Card::make('Games Completed This Week', $gamesCompletedThisWeek),
            Card::make('Completed % This Week', $completedPercent . '%'),
        ];
    }
}

class GamesThisSeasonWidget extends BaseWidget
{
    protected string|int|array $columnSpan = '1/4';
    protected function getCards(): array
    {
        $gamesThisSeason = Fixture::count();
        $gamesCompletedThisSeason = Fixture::where('status', 'completed')->count();
        $completedPercent = $gamesThisSeason > 0 ? round(($gamesCompletedThisSeason / $gamesThisSeason) * 100, 1) : 0;

        return [
            Card::make('Games This Season', $gamesThisSeason),
            Card::make('Games Completed This Season', $gamesCompletedThisSeason),
            Card::make('Completed % This Season', $completedPercent . '%'),
        ];
    }
}
