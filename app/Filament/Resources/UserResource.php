<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Closure;

class UserResource extends Resource
{

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';


    protected function handleRecordUpdate(array $data): Model
    {
        $record =  static::getModel()::update($data);

        return $record;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('firstname'),
                    TextInput::make('lastname'),
                    TextInput::make('email'),
                    TextInput::make('phone'),
                    Select::make('user_role_id')
                        ->relationship('role', 'title')
                        ->preload()
                        ->required()
                        ->reactive(),
                    TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->hidden(fn (Closure $get) => $get('user_role_id') !== 6),
                    Toggle::make('user_data_is_verified'),
                    DateTimePicker::make('phone_verified_at'),
                    DateTimePicker::make('email_verified_at'),

                ]),

                // driver info
                Card::make([
                    TextInput::make('room'),
                    TextInput::make('series'),
                    TextInput::make('issued_by'),
                    DatePicker::make('date_of_issue'),
                    TextInput::make('serial_number'),
                ])
                ->relationship('driverInfo')
                ->visible(fn (Closure $get) => $get('user_role_id') ===  5),


                // carrier info
                Card::make([
                    TextInput::make('legal_id'),
                    TextInput::make('company_id'),
                    TextInput::make('legal_name'),
                    TextInput::make('company_name'),
                ])
                ->relationship('carrier')
                ->visible(fn (Closure $get) => $get('user_role_id') ===  1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('firstname'),
                TextColumn::make('lastname'),
                TextColumn::make('email'),
                TextColumn::make('role.title'),
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
                FilamentExportBulkAction::make('export')
            ]);
    }


    public static function getRelations(): array
    {
        return [
            RelationManagers\RoleRelationManager::class,
//            RelationManagers\LanguagesRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
