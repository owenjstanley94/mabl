<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Filament\Resources\TeamResource\RelationManagers;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Select::make('league_id')
                    ->relationship('league', 'name')
                    ->required(),
                Forms\Components\TextInput::make('court'),
                Forms\Components\TextInput::make('tip_day'),
                Forms\Components\TextInput::make('tip_time')
                    ->label('Tip Time')
                    ->placeholder('e.g. 19:45')
                    ->helperText('Enter time in 24-hour format (e.g. 19:45)')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return null;
                        return date('H:i', strtotime($state));
                    })
                    ->dehydrateStateUsing(function ($state) {
                        if (!$state) return null;
                        return date('H:i', strtotime($state));
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('league.name')->label('League'),
                Tables\Columns\TextColumn::make('court'),
                Tables\Columns\TextColumn::make('tip_day'),
                Tables\Columns\TextColumn::make('tip_time'),
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
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
