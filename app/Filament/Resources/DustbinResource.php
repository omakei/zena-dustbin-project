<?php

namespace App\Filament\Resources;

use App\Filament\Pages\DustbinMap;
use App\Filament\Resources\DustbinResource\Pages;
use App\Filament\Resources\DustbinResource\RelationManagers;
use App\Forms\Components\ShowMap;
use App\Models\Dustbin;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class DustbinResource extends Resource
{
    protected static ?string $model = Dustbin::class;

    protected static ?string $navigationIcon = 'heroicon-o-trash';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('user')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('registration_number')
                    ->default('DUSTBIN/'.now()->year.'/'.now()->month.'/'. rand(111,999))
                    ->disabled()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('location')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('longitude')
                    ->required(),
                Forms\Components\TextInput::make('latitude')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('registration_number')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('location')->sortable(),
                Tables\Columns\BooleanColumn::make('is_full')->sortable(),
                Tables\Columns\TextColumn::make('filling_percent')->sortable(),
                Tables\Columns\BooleanColumn::make('is_active')->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->prependActions([
                Tables\Actions\Action::make('map')
                    ->action(fn (Dustbin $record): string => $record)->form([
                        ShowMap::make('map')
                            ->view('forms.components.show-map')
                            ->label(fn (Dustbin $record): string => $record->id)
                            ->default([0,0])
                    ])
                    ->modalHeading('Dustbin Map Location')
                    ->modalSubheading('This show where the dustbin coordinates are on the map')
                    ->modalButton('Close the Map')
                    ->icon('heroicon-o-location-marker')
                    ->color('success'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListDustbins::route('/'),
            'create' => Pages\CreateDustbin::route('/create'),
            'edit' => Pages\EditDustbin::route('/{record}/edit'),

        ];
    }
}
