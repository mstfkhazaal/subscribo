<?php

namespace App\Filament\Resources;

use AssertionError;
use Filament\Forms\Components\Component;
use App\Filament\Forms\Components\CurrencySelect;
use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Currency;
use App\Models\Service;
use Closure;
use Filament\Forms;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;
use TypeError;

class ServiceResource extends Resource
{
    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return ['en', 'ar'];
    }
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public $prefix = 'Hello, world!';


    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\Select::make('team_id')
                    ->relationship('teams', 'name', function ($query) {
                        $query->whereIn('teams.id', Auth::user()->allTeams()->pluck('id')->toArray());
                    })
                    ->default(Auth::user()->currentTeam()->pluck('id')->first())
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->reactive()
                    ->required(),
                Forms\Components\Select::make('currency')
                    ->relationship('currency', 'currency_name')
                    ->getOptionLabelFromRecordUsing(function (Currency $record) {
                        return $record->getTranslation('currency_name', app()->getLocale());
                    })
                    ->reactive()
                    ->preload()
                    ->required(),
                TextInput::make('amount')
                    ->prefix(function (Closure $get) {
                        return $get('currency') ==null?'':
                            Currency::find($get('currency'))->symbol;
                    })
                    ->mask(fn (TextInput\Mask $mask,Closure $get) => $mask->money(prefix:'',
                        thousandsSeparator: ',', decimalPlaces: 2, isSigned: false))
                    ->reactive()
                    ->required(),
                Forms\Components\Toggle::make('active')
                    ->inline(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('team_id'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('amount')
                    ->money(fn ($record): string => Currency::find($record->currency)->currency_code),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime(),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'view' => Pages\ViewService::route('/{record}'),
            'edit' => Pages\EditService::route('/{record}/edit'),
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
