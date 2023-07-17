<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrailerResource\Pages;
use App\Filament\Resources\TrailerResource\RelationManagers;
use App\Models\Trailer;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;


class TrailerResource extends Resource
{
    use Translatable;
    protected static ?string $model = Trailer::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    public static function getTranslatableLocales(): array
    {
        return ['eng', 'geo' ,'tur' , 'rus'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('number')->required(),
                TextInput::make('title'),
                TextInput::make('model'),
                TextInput::make('identification_number'),
                Select::make('trailer_type_id')
                    ->relationship('type', 'title')
                    ->preload()
                    ->required()
                    ->reactive(),
                Card::make([
                    SpatieMediaLibraryFileUpload::make('tech_passport')
                        ->multiple()
                        ->collection('tech_passport')
                        ->enableReordering()
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('type.title'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTrailers::route('/'),
            'create' => Pages\CreateTrailer::route('/create'),
            'view' => Pages\ViewTrailer::route('/{record}'),
            'edit' => Pages\EditTrailer::route('/{record}/edit'),
        ];
    }
}
