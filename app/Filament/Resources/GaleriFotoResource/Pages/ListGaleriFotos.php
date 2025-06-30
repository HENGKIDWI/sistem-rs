<?php

namespace App\Filament\Resources\GaleriFotoResource\Pages;

use App\Filament\Resources\GaleriFotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGaleriFotos extends ListRecords
{
    protected static string $resource = GaleriFotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
