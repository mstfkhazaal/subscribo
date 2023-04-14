<?php

namespace App\Filament\Resources\Options\CurrencyResource\Pages;

use App\Filament\Resources\Options\CurrencyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCurrencies extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = CurrencyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }
}
