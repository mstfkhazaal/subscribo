<?php

namespace App\Filament\Resources\Options\CurrencyResource\Pages;

use App\Filament\Resources\Options\CurrencyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCurrency extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = CurrencyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }
}
