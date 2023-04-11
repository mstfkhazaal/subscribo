<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mstfkhazaal\FilamentPasswordReveal\Password;

class UserResource extends Resource
{

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getLabel(): ?string
    {
        return __('users.title');
    }

    public static function getPluralLabel(): ?string
    {
        return __('users.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_status')
                    ->relationship('status', 'name')
                    ->required()->label('users.status')
                    ->translateLabel(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)->label('users.name')
                    ->translateLabel(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)->label('users.email')
                    ->translateLabel(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255)->label('users.password')
                    ->translateLabel(),
                Password::make('password')->autocomplete('new_password'),
                Forms\Components\TextInput::make('profile_photo_path')
                    ->maxLength(2048)->label('users.photo')
                    ->translateLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('status.name')
                    ->getStateUsing(function (User $record) {
                        $decoded = json_decode($record->status['name']);
                        $col = collect($decoded);
                        $str = app()->getLocale();
                        return $col->get($str, $col->get('en', $col->first()));
                    })->label('users.status')
                    ->translateLabel()
                ->color('primary'),
                Tables\Columns\TextColumn::make('name')
                    ->label('users.name')
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('email')
                    ->label('users.email')
                    ->translateLabel(),
                //Tables\Columns\TextColumn::make('profile_photo_path'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->label('table.created_at')
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()->label('table.deleted_at')
                    ->translateLabel(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}