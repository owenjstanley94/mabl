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
                    ->required(),
                Forms\Components\Select::make('away_team_id')
                    ->relationship('awayTeam', 'name')
                    ->required(),
                Forms\Components\Select::make('crew_chief_id')
                    ->relationship('crewChief', 'name'),
                Forms\Components\Select::make('referee_1_id')
                    ->relationship('referee1', 'name'),
                Forms\Components\Select::make('referee_2_id')
                    ->relationship('referee2', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('league.name')->label('League'),
                Tables\Columns\TextColumn::make('homeTeam.name')->label('Home Team'),
                Tables\Columns\TextColumn::make('awayTeam.name')->label('Away Team'),
                Tables\Columns\TextColumn::make('crewChief.name')->label('Crew Chief'),
                Tables\Columns\TextColumn::make('referee1.name')->label('Referee 1'),
                Tables\Columns\TextColumn::make('referee2.name')->label('Referee 2'),
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
