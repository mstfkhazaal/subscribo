<?php

namespace App\Filament\Resources\Options\LocationResource\Pages;

use App\Filament\Resources\Options\LocationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLocations extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = LocationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }
}
