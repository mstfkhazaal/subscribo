<?php

namespace App\Filament\Resources\Options;

use App\Filament\Resources\LocationResource\Pages;
use App\Filament\Resources\LocationResource\RelationManagers;
use App\Filament\Resources\Options;
use App\Models\Location;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class LocationResource extends Resource  implements HasShieldPermissions
{
    use Translatable;

    public static function getPermissionPrefixes(): array
    {
        return [
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }
    public static function getTranslatableLocales(): array
    {
        return [app()->getLocale(),'en', 'ar'];
    }
    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';


    public static function getNavigationGroup(): ?string
    {
        return __('nav.options');
    }
    public static function getLabel(): ?string
    {
        return __('location.title');
    }

    public static function getPluralLabel(): ?string
    {
        return __('location.plural');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('team_id')
                    ->relationship('teams', 'name', function ($query) {
                        $query->whereIn('teams.id', Auth::user()->allTeams()->pluck('id')->toArray());
                    })
                    ->default(Auth::user()->currentTeam()->pluck('id')->first())
                    ->label('location.business')
                    ->translateLabel()
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('location.name')
                    ->translateLabel()
                    ->required(),
                Forms\Components\Toggle::make('active')
                    ->label('table.active')
                    ->translateLabel()
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('teams.name')
                    ->label('location.business')
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('name')
                    ->label('location.name')
                    ->translateLabel(),
                Tables\Columns\IconColumn::make('active')
                    ->label('table.active')
                    ->translateLabel()
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('table.created_at')
                    ->translateLabel()
                    ->dateTime(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('table.deleted_at')
                    ->translateLabel()
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
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
            'index' => Options\LocationResource\Pages\ListLocations::route('/'),
            'create' => Options\LocationResource\Pages\CreateLocation::route('/create'),
            'edit' => Options\LocationResource\Pages\EditLocation::route('/{record}/edit'),
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
