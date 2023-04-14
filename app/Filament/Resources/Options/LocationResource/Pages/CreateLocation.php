<?php

namespace App\Filament\Resources\Options\LocationResource\Pages;

use App\Filament\Resources\Options\LocationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLocation extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = LocationResource::class;
    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
