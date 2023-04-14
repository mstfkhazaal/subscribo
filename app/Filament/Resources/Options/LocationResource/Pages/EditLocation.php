<?php

namespace App\Filament\Resources\Options\LocationResource\Pages;

use App\Filament\Resources\Options\LocationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLocation extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = LocationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            //Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }
}
