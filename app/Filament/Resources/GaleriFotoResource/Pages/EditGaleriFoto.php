<?php

namespace App\Filament\Resources\GaleriFotoResource\Pages;

use App\Filament\Resources\GaleriFotoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGaleriFoto extends EditRecord
{
    protected static string $resource = GaleriFotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
