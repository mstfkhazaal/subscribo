<?php

namespace App\Filament\Resources\Options\CurrencyResource\Pages;

use App\Filament\Resources\Options\CurrencyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCurrency extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = CurrencyResource::class;
    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
