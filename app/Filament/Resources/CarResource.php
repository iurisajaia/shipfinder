<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Filament\Resources\CarResource\RelationManagers;
use App\Models\Car;
use App\Models\DriverUserDetails;
use App\Models\User;
use App\Models\CarTrailerType;
use App\Models\PaymentMethod;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('model'),
                TextInput::make('description'),
                Select::make('trailer_type_id')->options(CarTrailerType::pluck('title', 'id')->toArray()),
                Select::make('payment_method_id')->options(PaymentMethod::pluck('title', 'id')->toArray()),
                Select::make('user_id')->options(User::pluck('firstname', 'id')->toArray()),
                TextInput::make('registration_number'),
//                Card::make([
//                    SpatieMediaLibraryFileUpload::make('images')->collection('images'),
//                ])->label('Images'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('model'),
                TextColumn::make('trailer_type.title')->label('Trailer Type'),
                TextColumn::make('payment_method.title')->label('Payment Method'),
                TextColumn::make('registration_number')->label('Registration Number'),
                TextColumn::make('user.firstname')->label('User'),

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
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'view' => Pages\ViewCar::route('/{record}'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
