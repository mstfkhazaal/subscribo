<?php

namespace App\Filament\Resources\Setting;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mstfkhazaal\FilamentPasswordReveal\Password;
use Wiebenieuwenhuis\FilamentCharCounter\TextInput;

class UserResource extends Resource implements HasShieldPermissions
{

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getLabel(): ?string
    {
        return __('users.title');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament-shield::filament-shield.nav.group');
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
                    ->required()
                    ->label('users.status')
                    ->translateLabel(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(32)->label('users.name')
                    ->translateLabel(),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(50)->label('users.email')
                    ->translateLabel(),
                Password::make('password')
                    ->autocomplete('new_password')
                    ->password()
                    ->required()
                    ->visibleOn('create')
                    ->maxLength(255)->label('users.password')
                    ->translateLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                BadgeColumn::make('status.name')
                    ->color(static function ($record): string {
                        return $record->status->variant;
                    })
                    ->label('users.status')
                    ->translateLabel(),
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
            'index' => UserResource\Pages\ListUsers::route('/'),
            'create' => UserResource\Pages\CreateUser::route('/create'),
            'view' => UserResource\Pages\ViewUser::route('/{record}'),
            'edit' => UserResource\Pages\EditUser::route('/{record}/edit'),
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
