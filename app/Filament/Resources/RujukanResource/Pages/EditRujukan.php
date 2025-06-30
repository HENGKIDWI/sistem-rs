<?php

namespace App\Filament\Resources\RujukanResource\Pages;

use App\Filament\Resources\RujukanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRujukan extends EditRecord
{
    protected static string $resource = RujukanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
