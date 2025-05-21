<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FixtureResource\Pages;
use App\Filament\Resources\FixtureResource\RelationManagers;
use App\Models\Fixture;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;

class FixtureResource extends Resource
{
    protected static ?string $model = Fixture::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('league_id')
                    ->relationship('league', 'name')
                    ->required(),
                Forms\Components\Select::make('home_team_id')
                    ->relationship('homeTeam', 'name')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            $team = \App\Models\Team::find($state);
                            if ($team && $team->tip_time) {
                                $set('tip_time', $team->tip_time);
                            }
                        }
                    }),
                Forms\Components\Select::make('away_team_id')
                    ->relationship('awayTeam', 'name')
                    ->required(),
                Forms\Components\Select::make('crew_chief_id')
                    ->relationship('crewChief', 'name'),
                Forms\Components\Select::make('referee_1_id')
                    ->relationship('referee1', 'name'),
                Forms\Components\Select::make('referee_2_id')
                    ->relationship('referee2', 'name'),
                DatePicker::make('date')
                    ->label('Date')
                    ->required()
                    ->helperText(function ($record) {
                        if ($record && $record->homeTeam) {
                            return "Home team's usual game night is: {$record->homeTeam->tip_day}";
                        }
                        return null;
                    }),
                TextInput::make('tip_time')
                    ->label('Tip Time')
                    ->helperText(function ($record) {
                        if ($record && $record->homeTeam) {
                            return "The home team's normal tip time is: {$record->homeTeam->tip_time}";
                        }
                        return null;
                    })
                    ->formatStateUsing(function ($state) {
                        if (!$state) return null;
                        return date('H:i', strtotime($state));
                    })
                    ->dehydrateStateUsing(function ($state) {
                        if (!$state) return null;
                        return date('H:i', strtotime($state));
                    })
                    ->required(),
                TextInput::make('home_team_score')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(999)
                    ->label('Home Score')
                    ->nullable()
                    ->rules(['nullable', 'integer', 'min:0', 'max:999'])
                    ->validationAttribute('home team score'),
                TextInput::make('away_team_score')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(999)
                    ->label('Away Score')
                    ->nullable()
                    ->rules(['nullable', 'integer', 'min:0', 'max:999'])
                    ->validationAttribute('away team score'),
                Forms\Components\Select::make('status')
                    ->options([
                        'planned' => 'Planned',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                        'forfeited' => 'Forfeited',
                        'contested' => 'Contested',
                    ])
                    ->default('planned')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('date')
                    ->date('d-m-y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tip_time')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return null;
                        return date('H:i', strtotime($state));
                    }),
                Tables\Columns\TextColumn::make('league.name')->label('League'),
                Tables\Columns\TextColumn::make('homeTeam.name')->label('Home Team'),
                Tables\Columns\TextColumn::make('awayTeam.name')->label('Away Team'),
                Tables\Columns\TextColumn::make('crewChief.name')->label('Crew Chief'),
                Tables\Columns\TextColumn::make('referee1.name')->label('Referee 1'),
                Tables\Columns\TextColumn::make('referee2.name')->label('Referee 2'),
                Tables\Columns\TextColumn::make('score')
                    ->label('Result')
                    ->formatStateUsing(function ($record) {
                        if (is_null($record->home_team_score) || is_null($record->away_team_score)) {
                            return '';
                        }
                        $home = $record->home_team_score;
                        $away = $record->away_team_score;
                        if ($home > $away) {
                            return "<strong>{$home}</strong> - {$away}";
                        } elseif ($away > $home) {
                            return "{$home} - <strong>{$away}</strong>";
                        } else {
                            return "{$home} - {$away}";
                        }
                    })
                    ->html(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'planned' => 'gray',
                        'confirmed' => 'blue',
                        'completed' => 'green',
                        'forfeited' => 'red',
                        'contested' => 'orange',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFixtures::route('/'),
            'create' => Pages\CreateFixture::route('/create'),
            'edit' => Pages\EditFixture::route('/{record}/edit'),
        ];
    }
}
