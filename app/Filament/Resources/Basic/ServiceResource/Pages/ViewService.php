<?php

namespace App\Filament\Resources\Basic\ServiceResource\Pages;

use App\Filament\Resources\Basic\ServiceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewService extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;


    protected static string $resource = ServiceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
