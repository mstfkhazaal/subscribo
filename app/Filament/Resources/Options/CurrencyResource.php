<?php

namespace App\Filament\Resources\Options;

use App\Filament\Resources\CurrencyResource\Pages;
use App\Filament\Resources\CurrencyResource\RelationManagers;
use App\Filament\Resources\Options;
use App\Models\Currency;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * @method dispatchBrowserEvent(string $string, array $array)
 */
class CurrencyResource extends Resource implements HasShieldPermissions
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
    protected static ?string $navigationGroup = 'Options';

    protected static ?string $model = Currency::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function getLabel(): ?string
    {
        return __('currency.title');
    }

    public static function getPluralLabel(): ?string
    {
        return __('currency.plural');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('currency_code')
                    ->required()
                    ->label('currency.currency_code')
                    ->translateLabel()
                    ->maxLength(3),
                Forms\Components\TextInput::make('currency_name')
                    ->label('currency.currency_name')
                    ->translateLabel()
                    ->required(),
                Forms\Components\TextInput::make('symbol')
                    ->label('currency.symbol')
                    ->translateLabel()
                    ->required()
                    ->maxLength(10),
                Forms\Components\Toggle::make('active')
                    ->default(true)
                    ->inline(false)
                    ->label('currency.active')
                    ->translateLabel()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('currency_code')
                    ->label('currency.currency_code')
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('currency_name')
                    ->label('currency.currency_name')
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('symbol')
                    ->label('currency.symbol')
                    ->translateLabel(),
                Tables\Columns\IconColumn::make('active')
                    ->action( Action::make('active')
                        ->label('Toggleable Service (Active/Deactive)')
                        ->modalSubheading('Are You sure?')
                        ->requiresConfirmation()
                        ->action(function($record) {
                            $record->active =!$record->active;
                            $record->save();
                        }))
                    ->boolean()->label('currency.active')
                    ->translateLabel(),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                //Tables\Actions\ForceDeleteBulkAction::make(),
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
            'index' => Options\CurrencyResource\Pages\ListCurrencies::route('/'),
            'create' => Options\CurrencyResource\Pages\CreateCurrency::route('/create'),
            'edit' => Options\CurrencyResource\Pages\EditCurrency::route('/{record}/edit'),
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
