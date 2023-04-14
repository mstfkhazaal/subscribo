<?php

namespace App\Filament\Resources\Basic\ServiceResource\Pages;

use App\Filament\Resources\Basic\ServiceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = ServiceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
